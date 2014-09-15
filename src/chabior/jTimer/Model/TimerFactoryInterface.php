<?php

namespace chabior\jTimer\Model;

/**
 * Description of TimerFactoryInterface
 *
 * @author chabior
 */
interface TimerFactoryInterface
{
    /**
     * 
     * @param string $input
     * @return \chabior\jTimer\jTimer
     */
    public function create($input);
}
