<?php

namespace chabior\JTimer\Exception;

/**
 * Description of InvalidTimePrefixException
 *
 * @author chabior
 */
class InvalidTimePrefixException extends Exception
{
    /**
     * 
     * @param string $prefix
     * @return InvalidTimePrefixException
     */
    public static function get($prefix)
    {
        return parent::get(sprintf('Invalid time prefix %s!', $prefix));
    }
}
