<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    /**
     * Public Key From PayWithBank3D.
     */
    'publicKey' => getenv('PWB3D_PUBLIC_KEY'),

    /**
     * Secret Key From PayWithBank3D.
     */
    'secretKey' => getenv('PWB3D_SECRET_KEY'),

    /**
     * switch to live or test.
     */
    'mode' => getenv('PWB3D_MODE', 'live'),

    /**
     * PayWithBank3D Test Payment URL.
     */
    'testUrl' => getenv('PWB3D_TEST_URL'),

    /**
     * PayWithBank3D Live Payment URL.
     */
    'liveURL' => getenv('PWB3D_LIVE_URL'),
];
