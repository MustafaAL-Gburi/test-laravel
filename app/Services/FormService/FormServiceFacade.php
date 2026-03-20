<?php

namespace App\Services\FormService;

use Illuminate\Support\Facades\Facade;

class FormServiceFacade extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'formservice';
    }
}

