<?php

namespace chabior\jTimer\Factory;

use chabior\jTimer\Model\LexerInterface;
use chabior\jTimer\Model\ParserInterface;
use chabior\jTimer\Model\TimerFactoryInterface;

/**
 * Description of TimerFactory
 *
 * @author chabior
 */
class TimerFactory implements TimerFactoryInterface
{
    /**
     *
     * @var \chabior\jTimer\Model\ParserInterface
     */
    protected $parser;
    
    /**
     *
     * @var \chabior\jTimer\Model\LexerInterface
     */
    protected $lexer;
    
    /**
     * @param \chabior\jTimer\Model\LexerInterface $lexer
     * @param \chabior\jTimer\Model\ParserInterface $parser
     */
    public function __construct(LexerInterface $lexer, ParserInterface $parser)
    {
        $this->lexer = $lexer;
        
        $this->parser = $parser;
    }
    
    /**
     * 
     * @param string $input
     * @return \chabior\jTimer\jTimer
     */
    public function create($input)
    {
        $tokens = $this->lexer->tokenize($input);
        
        $jTimer = $this->parser->parse($tokens);
        
        return $jTimer;
    }
}
