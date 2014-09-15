<?php

namespace chabior\jTimer\Test;

use chabior\jTimer\Lexer;

/**
 * Description of LexerTest
 *
 * @author chabior
 */
class LexerTest extends BaseTest
{
    /**
     * @dataProvider tokenizerDataProvider
     */
    public function testTokenizer($input, $expected, $isEqual)
    {
        $lexer = new Lexer();
        
        $tokens = $lexer->tokenize($input);
        
        if (true === $isEqual) {
            $this->assertEquals($expected, $tokens);
        } else {
            $this->assertNotEquals($tokens, $lexer);
        }
    }
    
    /**
     * @expectedException \chabior\jTimer\Exception\UnexcepectedCharacterException
     * @dataProvider failTokenizerDataProvider
     */
    public function testFailTokenizer($input)
    {
        $lexer = new Lexer();
        
        $lexer->tokenize($input);
    }
    
    public function tokenizerDataProvider()
    {
        return array(
            array('2h', array(array(Lexer::T_NUMBER, '2'), array(Lexer::T_HOUR, 'h')), true),
            array('10i', array(array(Lexer::T_NUMBER, '10'), array(Lexer::T_MINUTE, 'i')), true),
            array('5m', array(array(Lexer::T_NUMBER, '5'), array(Lexer::T_MONTH, 'm')), true),
            array('2s', array(array(Lexer::T_NUMBER, '2'), array(Lexer::T_SECOND, 's')), true),
            array('3d', array(array(Lexer::T_NUMBER, '3'), array(Lexer::T_DAY, 'd')), true),
            array('7y', array(array(Lexer::T_NUMBER, '7'), array(Lexer::T_YEAR, 'y')), true),
            array('10.15y', array(array(Lexer::T_NUMBER, '10.15'), array(Lexer::T_YEAR, 'y')), true),
            array('7y', array(array(Lexer::T_NUMBER, '34'), array(Lexer::T_MONTH, 'y')), false),
            
            array('12h34i', array(array(Lexer::T_NUMBER, '12'), array(Lexer::T_HOUR, 'h'),array(Lexer::T_NUMBER, '34'), array(Lexer::T_MINUTE, 'i')), true),
            array('-12h34i', array(array(Lexer::T_NEGATIVE, '-'), array(Lexer::T_NUMBER, '12'), array(Lexer::T_HOUR, 'h'),array(Lexer::T_NUMBER, '34'), array(Lexer::T_MINUTE, 'i')), true),
            array('-4d 13s', array(array(Lexer::T_NEGATIVE, '-'), array(Lexer::T_NUMBER, '4'), array(Lexer::T_DAY, 'd'), array(Lexer::T_SPACE, ' '), array(Lexer::T_NUMBER, '13'), array(Lexer::T_SECOND, 's')), true),
        );
    }
    
    public function failTokenizerDataProvider()
    {
        return array(
            array('źdfds.Yuasdl'),
            array('+12h'),
            array('14s 145r 12h'),
        );
    }
}
