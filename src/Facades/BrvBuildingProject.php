<?php

namespace Phobrv\BrvBuildingProject\Facades;

use Illuminate\Support\Facades\Facade;

class BrvBuildingProject extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'brvbuildingproject';
    }
}
