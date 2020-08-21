<?php

namespace Parkwayprojects\PayWithBank3D\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Parkwayprojects\PayWithBank3D\Exceptions\CouldNotProcess;

abstract class ApiRequest
{
    protected $baseUrl;
    /**
     * @var mixed
     */
    private $secretKey;

    private $publicKey;

    protected $client;
    private $response;

    public function __construct()
    {
        $this->setUrl();
        $this->setConstant();
        $this->checkConstant();
        $this->prepareRequest();
    }

    public function setUrl()
    {
        $this->baseUrl = Config::get('paywithbank3d.mode') === 'test' ? Config::get('paywithbank3d.testUrl') : Config::get('paywithbank3d.liveURL');
    }

    public function setConstant()
    {
        $this->secretKey = Config::get('paywithbank3d.secretKey');
        $this->publicKey = Config::get('paywithbank3d.publicKey');
    }

    protected function checkConstant()
    {
        if (! $this->secretKey) {
            throw CouldNotProcess::notSetSecretKey();
        }

        if (! $this->publicKey) {
            throw CouldNotProcess::notSetPublicKey();
        }

        if (! $this->baseUrl) {
            throw CouldNotProcess::notSetUrl();
        }
    }

    protected function prepareRequest()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'auth' => [$this->secretKey, $this->publicKey],
            'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'],
        ]);
    }

    public function getResponse()
    {
        $response = new Response($this->response);
        $json = $response->toJSON();

        return json_decode($json, true);
    }

    protected function performGetRequest($relativeUrl)
    {
        $this->response = $this->client->request('GET', $relativeUrl);

        return $this->getResponse();
    }

    protected function performPostRequest($relativeUrl, $data)
    {
        $this->response = $this->client->request('POST', $relativeUrl, ['json'=> $data]);

        return $this->getResponse();
    }
}
