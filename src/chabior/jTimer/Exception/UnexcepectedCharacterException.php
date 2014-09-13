<?php

namespace chabior\jTimer\Exception;

/**
 * Description of UnexcepectedCharacterException
 *
 * @author chabior
 */
class UnexcepectedCharacterException extends Exception
{
    /**
     * 
     * @param string $character
     * @return UnexcepectedCharacterException
     */
    public static function get($character)
    {
        $message = sprintf('Unexpected character "%s"', $character);
        
        return parent::get($message);
    }
}
