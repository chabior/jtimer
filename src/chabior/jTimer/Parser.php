<?php

namespace chabior\jTimer;

/**
 * Description of Parser
 *
 * @author chabior
 */
class Parser implements Model\ParserInterface
{
    /**
     * 
     * @param array $tokens
     * @return \chabior\jTimer\jTimer
     * @throws Exception\UnexcepectedCharacterException
     */
    public function parse(array $tokens)
    {
        $timer = new jTimer();
        $timeValue = 0;
        
        foreach ($tokens as $data) {
            list ($token, $value) = $data;
            
            switch ($token) {
                case Lexer::T_NEGATIVE:
                    $timer->setIsNegative(true);
                    break;
                case Lexer::T_NUMBER:
                    $timeValue = $value;
                    break;
                case Lexer::T_DAY:
                    $timer->changeTime(Enum\TimePrefix::DAY(), $timeValue);
                    break;
                case Lexer::T_HOUR:
                    $timer->changeTime(Enum\TimePrefix::HOUR(), $timeValue);
                    break;
                case Lexer::T_MINUTE:
                    $timer->changeTime(Enum\TimePrefix::MINUTE(), $timeValue);
                    break;
                case Lexer::T_MONTH:
                    $timer->changeTime(Enum\TimePrefix::MONTH(), $timeValue);
                    break;
                case Lexer::T_SECOND:
                    $timer->changeTime(Enum\TimePrefix::SECOND(), $timeValue);
                    break;
                case Lexer::T_WEEK:
                    $timer->changeTime(Enum\TimePrefix::WEEK(), $timeValue);
                    break;
                case Lexer::T_YEAR:
                    $timer->changeTime(Enum\TimePrefix::YEAR(), $timeValue);
                    break;
                case Lexer::T_SPACE:
                    break;
                default:
                    throw Exception\UnexcepectedCharacterException::get($token);
            }
        }
        
        return $timer;
    }
}
