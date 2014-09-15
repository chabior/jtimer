<?php

namespace chabior\jTimer\Model;

/**
 * Description of LexerInterface
 *
 * @author chabior
 */
interface LexerInterface
{
    /**
     * 
     * @param string $input
     */
    public function tokenize($input);
}
