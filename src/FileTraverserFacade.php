<?php

namespace KevinRuscoe\FileTraverser;

use Illuminate\Support\Facades\Facade;

class FacadeExample extends Facade 
{
    protected static function getFacadeAccessor()
    {
        return 'FileTraverser'; 
    }
}