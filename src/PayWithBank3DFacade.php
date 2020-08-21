<?php

namespace Parkwayprojects\PayWithBank3D;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Parkwayprojects\LaravelPaywithbank3d\Skeleton\SkeletonClass
 * @method static setUrl(array $data)
 * @method static mixed redirectNow()
 * @method static mixed getData()
 */
class PayWithBank3DFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-paywithbank3d';
    }
}
