<?php

namespace pushprom;

class Connection
{
    /** @var string */
    private $protocol;

    /** @var string|false|null */
    private $host;

    /** @var int|false|null */
    private $port;

    /** @var string[] */
    private $constLabels;

    /** @var callable|null */
    private $warningLogger;

    public function __construct(string $url, array $constLabels = [], callable $warningLogger = null)
    {
        foreach ($constLabels as $label => $value) {
            $constLabels[$label] = (string) $value;
        }

        $this->constLabels   = $constLabels;
        $this->warningLogger = $warningLogger;
        $this->protocol      = strtolower((string) parse_url($url, PHP_URL_SCHEME));
        $this->host          = parse_url($url, PHP_URL_HOST);
        $this->port          = parse_url($url, PHP_URL_PORT);

        $supportedProtocols = ["http", "https", "udp"];
        if (in_array($this->protocol, $supportedProtocols) == false) {
            throw new \Exception(
                "Protocol " . $this->protocol . " not supported. Valid values are: " . implode(
                    ",",
                    $supportedProtocols
                ) . "."
            );
        }
    }

    /** @return bool|string|null */
    public function push(array $delta)
    {
        $delta["labels"] = array_merge($delta["labels"], $this->constLabels);

        if (sizeof($delta["labels"]) == 0) {
            // if the array for labels is [] then make it an obj so it gets json encoded as {} not []
            $delta["labels"] = new \stdClass();
        }

        $msg = json_encode($delta);
        if ($msg === false) {
            $this->warning(sprintf("Failed to encode to json %s", var_export($delta)));
            $msg = '';
        }
        $msg_len = strlen($msg);

        $response = null;

        if ($this->protocol == "udp") {
            $maxMsgLen = 508;
            if ($msg_len > $maxMsgLen) {
                $this->warning("Pushprom payload too big($msg_len). It needs to be smaller than $maxMsgLen.");
            }

            $sock = fsockopen("udp://" . (string) $this->host, (int) $this->port, $errno, $errstr);
            if ($sock === false) {
                $this->warning("Failed to open UDP socket connection");
                return $response;
            }

            $r = @fwrite($sock, $msg);
            if ($r == FALSE) {
                $this->warning("Error writing to pushprom's UDP socket");
            }

            @fclose($sock);

        } else {
            $ch = curl_init($this->protocol . '://' . $this->host . ':' . $this->port . "/");
            if ($ch === false) {
                $this->warning("Failed to initialize cURL session");
                return $response;
            }

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
            if ($this->protocol == "https") {
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                [
                    'Content-Type: application/json',
                    'Content-Length: ' . $msg_len,
                ]
            );
            $response = curl_exec($ch);
            curl_close($ch);
        }
        return $response;
    }

    private function warning(string $msg): void
    {
        if ($this->warningLogger != null) {
            call_user_func_array($this->warningLogger, [$msg]);
        } else {
            error_log($msg);
        }
    }
}
