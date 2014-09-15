<?php

namespace chabior\jTimer\Test;

use chabior\jTimer\Lexer;
use chabior\jTimer\Parser;

/**
 * Description of ParserTest
 *
 * @author chabior
 */
class ParserTest extends BaseTest
{
    /**
     * 
     */
    public function testParse()
    {
        $tokens = $this->getValidTokens();
        
        $parser = new Parser();
        
        $jTimer = $parser->parse($tokens);
        
        $this->assertInstanceOf('\chabior\jTimer\jTimer', $jTimer);
    }
    
    /**
     * @expectedException \chabior\jTimer\Exception\UnexcepectedCharacterException
     */
    public function testFailParse()
    {
        $tokens = array(array('fail', 'h'));
        
        $parser = new Parser();
        
        $parser->parse($tokens);
    }
    
    /**
     * 
     * @param string $input
     * @return array
     */
    protected function getValidTokens($input = '12h 3i')
    {
        $lexer = new Lexer();
        
        return $lexer->tokenize($input);
    }
}
