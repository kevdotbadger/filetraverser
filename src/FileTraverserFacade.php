<?php

namespace KevinRuscoe\FileTraverser;

use Illuminate\Support\Facades\Facade;

class FileTraverserFacade extends Facade
{
    /**
     * The name of the facade accessor.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'FileTraverser';
    }
}
