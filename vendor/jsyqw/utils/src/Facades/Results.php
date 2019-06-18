<?php
/**
 * Created by PhpStorm.
 * @author  jason <jasonwang1211@gmail.com>
 */

namespace Jsyqw\Utils\Facades;

use Jsyqw\Utils\Results as ResultsEntity;

class Results extends Facade
{
    /**
     * @return  ResultsEntity
     */
    protected static function getFacadeAccessor()
    {
        return \Jsyqw\Utils\Results::class;
    }
}