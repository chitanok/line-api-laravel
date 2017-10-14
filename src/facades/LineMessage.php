<?php 

namespace Chitanok\LineApiLaravel\Facades;
use Illuminate\Support\Facades\Facade;

/**
 * summary
 */
class LineMessage extends Facade
{
    /**
     * summary
     */
    public function __construct()
    {
        protected static function getFacadeAccessor(){
        	return 'line-message';
        }
    }
}

