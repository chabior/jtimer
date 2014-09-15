<?php

namespace chabior\jTimer\Test;

use chabior\jTimer\Factory\TimerFactory;
use chabior\jTimer\Lexer;
use chabior\jTimer\Model\TimerFactoryInterface;
use chabior\jTimer\Parser;

/**
 * Description of jTimerTest
 *
 * @author chabior
 */
class jTimerTest extends BaseTest
{
    /**
     *
     * @var TimerFactoryInterface
     */
    protected $factory;
    
    public function setUp()
    {
        $lexer = new Lexer();
        
        $parser = new Parser();
        
        $this->factory = new TimerFactory($lexer, $parser);
    }
    
    public function testGetAsString()
    {
        $input = '2w 34d';
        
        $jTimer = $this->factory->create($input);
        
        $string = $jTimer->getAsString();
        
        $this->assertEquals('48d', $string);
    }
    
    public function testGetAsDateInterval()
    {
        $input = '3w22d2h34s';
        
        $jTimer = $this->factory->create($input);
        
        $dateInterval = $jTimer->getDateInterval();
        
        $this->assertEquals(1, $dateInterval->m);
        $this->assertEquals(13, $dateInterval->d);
        $this->assertEquals(2, $dateInterval->h);
        $this->assertEquals(34, $dateInterval->s);
        
        $this->assertEquals(1, $jTimer->getMonths());
        $this->assertEquals(13, $jTimer->getDays());
        $this->assertEquals(2, $jTimer->getHours());
        $this->assertEquals(34, $jTimer->getSeconds());
    }
}
