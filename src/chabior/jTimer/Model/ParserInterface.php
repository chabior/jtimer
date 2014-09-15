<?php

namespace chabior\jTimer\Model;
/**
 * Description of ParserInterface
 *
 * @author chabior
 */
interface ParserInterface
{
    /**
     * 
     * @param array $tokens
     */
    public function parse(array $tokens);
}
