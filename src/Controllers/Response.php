<?php

namespace Parkwayprojects\PayWithBank3D\Controllers;

class Response
{
    // The actual Guzzle response:
    private $response;

    // Core response:
    private $headers;
    private $bodyRaw;
    private $body;

    // Properties:
    private $statusCode;
    private $timestamp;

    public function __construct(\GuzzleHttp\Psr7\Response $response)
    {
        $this->response = $response;
        $this->headers = $response->getHeaders();
        $this->bodyRaw = (string) $response->getBody();
        $this->body = json_decode($this->bodyRaw);

        // Set our properties:
        $this->statusCode = $response->getStatusCode();
        $this->timestamp = date('c');
    }

    public function getStatusCode()
    {
        return (int) $this->statusCode;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getData()
    {
        return $this->body;
    }

    public function getHeader()
    {
        return $this->headers;
    }

    public function toJSON()
    {
        return json_encode([
            'statusCode'   => $this->getStatusCode(),
            'timestamp'    => $this->getTimestamp(),
            'body' => $this->getData(),
        ], true);
    }
}
