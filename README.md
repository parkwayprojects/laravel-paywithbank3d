# PayWithBank3D Laravel Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/parkwayprojects/laravel-paywithbank3d.svg?style=flat-square)](https://packagist.org/packages/parkwayprojects/laravel-paywithbank3d)
[![Build Status](https://img.shields.io/travis/parkwayprojects/laravel-paywithbank3d/master.svg?style=flat-square)](https://travis-ci.org/parkwayprojects/laravel-paywithbank3d)
[![Quality Score](https://img.shields.io/scrutinizer/g/parkwayprojects/laravel-paywithbank3d.svg?style=flat-square)](https://scrutinizer-ci.com/g/parkwayprojects/laravel-paywithbank3d)
[![Total Downloads](https://img.shields.io/packagist/dt/parkwayprojects/laravel-paywithbank3d.svg?style=flat-square)](https://packagist.org/packages/parkwayprojects/laravel-paywithbank3d)

A Laravel Package For Working With PayWithBank3D Seamlessly

## Installation

You can install the package via composer:

```bash
composer require parkwayprojects/laravel-paywithbank3d
```

> If you use **Laravel >= 5.5** you can skip this step and go to [**`configuration`**](https://github.com/infinitypaul/laravel-paywithbank3d#configuration)

* `Parkwayprojects\PayWithBank3D\PayWithBank3DServiceProvider::class`

Also, register the Facade like so:

```php
'aliases' => [
    ...
    'PayWithBank3D' => Parkwayprojects\PayWithBank3D\Facades\PayWithBank3DFacade::class,
    ...
]
```

## Configuration

You can publish the configuration file using this command:

```bash
php artisan vendor:publish --provider="Parkwayprojects\PayWithBank3D\PayWithBank3DServiceProvider"
```
A configuration-file named `paywithbank3d.php` with some sensible defaults will be placed in your `config` directory:

```php
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

```

## Usage
Open your .env file and add your PayWithBank3D public key,  PayWithBank3D secret key, PayWithBank3D mode which by default is live, live url , and test url like so:

``` php
PWB3D_PUBLIC_KEY=****
PWB3D_SECRET_KEY=****
PWB3D_MODE=test
PWB3D_TEST_URL=https://staging.paywithbank3d.com
PWB3D_LIVE_URL=https://paywithbank3d.com
```

Set up routes and controller methods like so:

```php
// Laravel 5.1.17 and above
Route::post('/pay', 'PaymentController@redirectToGateway')->name('pay'); 
```

OR

```php
Route::post('/pay', [
    'uses' => 'PaymentController@redirectToGateway',
    'as' => 'pay'
]);

Route::post('/pay2', [
    'uses' => 'PaymentController@PaymentData',
    'as' => 'data'
]);
```

```php
Route::get('/payment/callback', 'PaymentController@handleGatewayCallback')->name('callback');
```
OR

```php
// Laravel 5.0
Route::get('payment/callback', [
    'uses' => 'PaymentController@handleGatewayCallback'
]); 
```

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PayWithBank3D;

class PaymentController extends Controller
{

    /**
     * Redirect the User to PayWithBank3D Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        return PayWithBank3D::setUrl()->redirectNow();
    }

    /**
     * Get The PayWithBank3D Redirect Url
     * @return array
     */
    public function redirectUrl()
    {
        return  PayWithBank3D::getUrl();
    }

    /**
     * Obtain PayWithBank3D payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails =  PayWithBank3D::getData();

        dd($paymentDetails);
        // Now you have the payment details,
        // you can then redirect or do whatever you want
    }
}
```
Let me explain the fluent methods this package provides a bit here.

```php
/**
 *  This fluent method does all the dirty work of sending a POST request with the form data
 *  to PayWithBank3D Api, then it gets the payment Url and redirects the user to PayWithBank3D
 *  Payment Page. I abstracted all of it, so you don't have to worry about that.
 *  Just eat your cookies while coding!
 */
PayWithBank3D::setUrl()->redirectNow();

/**
*  SetUrl can also accept an array instead of a request object and you are good to go, it will be in this format
 */

        $data = [
                    'reference' => time(),
                    'amount'=> 20000,
                    'currencyCode' => 'NGN',
                    'customer' => [
                        'name' => 'Edward Paul',
                        'email' => 'infinitypaul@live.com',
                        'phone' => '08170574789'
                    ],
                    'returnUrl' => route('verify'),
                    'metadata' => [
                        'orderId'=> '1234'
                    ]
                ];
       return PayWithBank3DFacade::setUrl($data)->redirectNow();


/**
 * This fluent method does all the dirty work of verifying that the just concluded transaction was actually valid,
 */
PayWithBank3D::getData();

/**
 * This method gets the return the redirect url in the case your frontend is detached from your backend
 * @returns array
 */
PayWithBank3D::setUrl()->getUrl();

```

A sample form will look like so:

```html
<form method="POST" action="{{ route('pay') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
        <div class="row" style="margin-bottom:40px;">
          <div class="col-md-8 col-md-offset-2">
            <p>
                <div>
                    Infinity Biscuit
                    ₦ 5,980
                </div>
            </p>

            <input type="hidden" name="email" value="infinitypaul@live"> {{-- required --}}
            <input type="hidden" name="name" value="Edward Paul">
<input type="hidden" name="phone" value="0702323463">
            <input type="hidden" name="amount" value="1000"> {{-- required --}}
           
            <input type="hidden" name="returnUrl" value="{{ route('callback') }}"> {{-- required --}}

          
            {{ csrf_field() }} {{-- works only when using laravel 5.1, 5.2 --}}

             <input type="hidden" name="_token" value="{{ csrf_token() }}"> {{-- employ this in place of csrf_field only in laravel 5.0 --}}

            <p>
              <button class="btn btn-success btn-lg btn-block" type="submit" value="Pay Now!">
              <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
              </button>
            </p>
          </div>
        </div>
</form>
```

When clicking the submit button the customer gets redirected to the PayWithBank3D site.

So now we've redirected the customer to PayWithBank3D. The customer did some actions there (hopefully he or she paid the order) and now gets redirected back to our  site.

A Request is sent to our callback url (we don't want imposters to wrongfully place non-paid order).

In the controller that handles the request coming from the payment provider, we have

`PayWithBank3D::getData()` - This function does the calculation and ensure it is a valid transaction else it throws an exception.


## Credits

- [Paul Edward](https://github.com/parkwayprojects)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
