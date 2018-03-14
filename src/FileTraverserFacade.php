<?php

namespace KevinRuscoe\FileTraverser;

use Illuminate\Support\Facades\Facade;

class FileTraverserFacade extends Facade 
{
    protected static function getFacadeAccessor()
    {
        return 'FileTraverser'; 
    }
}