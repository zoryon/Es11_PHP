<?php
$host = "localhost";
$db = "concerti";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

class Response {
    // attribute
    private $statusCode = null;
    private $headers = [];

    // constructors
    public function __construct() {
        $this->setContentTypeJson();
    }

    // methods
    public function setStatusCode(int $code): self {
        $this->statusCode = $code;
        return $this;
    }

    public function addHeader(string $name, string $value): self {
        $this->headers[] = "$name: $value";
        return $this;
    }

    public function redirect(string $url): self {
        return $this->addHeader("Location", $url);
    }

    public function setContentTypeJson(): self {
        return $this->addHeader("Content-Type", "application/json");
    }

    public function send(): void {
        if ($this->statusCode !== null) {
            http_response_code($this->statusCode);
        }
        foreach ($this->headers as $header) {
            header($header);
        }
        $this->clear();
    }

    private function clear(): void {
        $this->statusCode = null;
        $this->headers = [];
    }
}
?>
