<?php

namespace CubesDoo\SrbijaNaselja\Laravel;

use Illuminate\Support\Facades\Facade as BaseFacade;

/**
 * @method mixed lang(string $lang)
 * @method array naselja()
 * @method string naselje($postanskiBroj)
 * @method array opstine()
 * @method array opstina($postanskiBroj)
 * @method string[] okruzi()
 * @method string okrug($postanskiBroj)
 */
class Facade extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return 'SrbijaNaselja';
    }
}