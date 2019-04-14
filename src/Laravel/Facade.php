<?php

namespace Intervention\Image\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method mixed lang(string $lang)
 * @method array naselja()
 * @method string naselje($postanskiBroj)
 * @method array opstine()
 * @method array opstina($postanskiBroj)
 * @method string[] okruzi()
 * @method string okrug($postanskiBroj)
 */
class SrbijaNaselja extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'srbijaNaselja';
    }
}