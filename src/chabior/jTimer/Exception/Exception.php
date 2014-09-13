<?php

namespace chabior\jTimer\Exception;

/**
 * Description of Exception
 *
 * @author chabior
 */
class Exception extends \RuntimeException
{
    /**
     * 
     * @param srting $message
     * @return Exception
     */
   public static function get($message)
   {
       return new static($message);
   }
}
