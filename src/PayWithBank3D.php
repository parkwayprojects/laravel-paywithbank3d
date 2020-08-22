<?php

namespace Parkwayprojects\PayWithBank3D;

use Exception;
use Parkwayprojects\PayWithBank3D\Controllers\ApiRequest;
use Parkwayprojects\PayWithBank3D\Exceptions\CouldNotProcess;

class PayWithBank3D extends ApiRequest
{
    protected $initializeUrl = 'api/transaction/initialize';
    protected $verifyUrl = 'api/payment/verify/';

    protected $redirectUrl;

    protected function generateUrl($data)
    {
        if (empty($data)) {
            $data = [
                'amount' => intval(request()->amount),
                'currencyCode' => request()->currencyCode ? request()->currencyCode : 'NGN',
                'customer' => [
                    'name' => request()->name,
                    'email' => request()->email,
                    'phone' => request()->phone,
                ],
                'returnUrl' => request()->returnUrl,
                'color' => request()->color ? request()->color : '#FF0000',
                'metadata' => request()->metadata,
            ];
        }
        array_filter($data);
        $result = $this->performPostRequest($this->initializeUrl, $data);
        $this->redirectUrl = $result['body']['data']['paymentUrl'];
    }

    public function setUrl($data = [])
    {
        try {
            $this->generateUrl($data);

            return $this;
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function getUrl()
    {
        return $this->redirectUrl;
    }

    /**
     *  Redirect to PayWithBank3D Payment Page.
     */
    public function redirectNow()
    {
        return redirect($this->redirectUrl);
    }

    /**
     * Query PayWithBank3d Verify Route And Return True Or False If Payment Is Successful.
     * @return bool
     */
    protected function verifyReference()
    {
        $reference = request()->query('reference');
        $result = $this->performGetRequest($this->verifyUrl.$reference);

        return $result['body']['code'] === '00';
    }

    /**
     * Get Payment details if the transaction was verified successfully.
     * @throws \Parkwayprojects\PayWithBank3D\Exceptions\CouldNotProcess
     */
    public function getData()
    {
        if ($this->verifyReference()) {
            return $this->getResponse();
        }
        throw CouldNotProcess::invalidTransaction();
    }
}
