<?php

namespace chabior\jTimer;

use chabior\jTimer\Model\LexerInterface;

/**
 * Description of Lexer
 *
 * @author chabior
 */
class Lexer implements LexerInterface
{
    const T_NEGATIVE = 't_negative';
    const T_SPACE = 't_space';
    const T_NUMBER = 't_number';
    const T_HOUR = 't_hour';
    const T_MINUTE = 't_minute';
    const T_SECOND = 't_second';
    const T_DAY = 't_day';
    const T_WEEK = 't_week';
    const T_MONTH = 't_month';
    const T_YEAR = 't_year';
    
    /**
     * 
     * @param string $input
     * @return array
     * @throws Exception\UnexcepectedCharacterException
     */
    public function tokenize($input)
    {
        $tokens = array();
        $offset = 0; // current offset in string
        
        
        while (isset($input[$offset])) { // loop as long as we aren't at the end of the string
            foreach ($this->getTermianals() as $token => $regex) {
                if (preg_match($regex, $input, $matches, null, $offset)) {
                    $tokens[] = array(
                        $token,      
                        $matches[0], 
                    );
                    $offset += strlen($matches[0]);
                    
                    continue 2; // continue the outer while loop
                }
            }
            
            throw Exception\UnexcepectedCharacterException::get($input[$offset]);
        }

        return $tokens;
    }
    
    /**
     * 
     * @return array
     */
    protected function getTermianals()
    {
        static $terminals = null;
        
        if (null === $terminals) {
            $terminals = array(
                self::T_NEGATIVE => '/-{1}/Ai',
                self::T_SPACE => '/\s/Ai',
                self::T_NUMBER => '/[0-9.]+/Ai',

                self::T_MONTH => sprintf('/%s{1}/Ai', Enum\TimePrefix::MONTH()->getPrefix()),
                self::T_HOUR => sprintf('/%s{1}/Ai', Enum\TimePrefix::HOUR()->getPrefix()),
                self::T_MINUTE => sprintf('/%s{1}/Ai', Enum\TimePrefix::MINUTE()->getPrefix() ),
                self::T_SECOND => sprintf('/%s{1}/Ai', Enum\TimePrefix::SECOND()->getPrefix()),
                self::T_DAY => sprintf('/%s{1}/Ai', Enum\TimePrefix::DAY()->getPrefix()),
                self::T_WEEK => sprintf('/%s{1}/Ai', Enum\TimePrefix::WEEK()->getPrefix()),
                self::T_YEAR => sprintf('/%s{1}/Ai', Enum\TimePrefix::YEAR()->getPrefix()),
            );
        }
        
        return $terminals;
    }
}
