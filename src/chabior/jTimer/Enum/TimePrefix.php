<?php

namespace chabior\jTimer\Enum;

use Eloquent\Enumeration\AbstractMultiton;

/**
 * Description of TimePrefix
 *
 * @author chabior
 * 
 * @method TimePrefix SECOND() 
 * @method TimePrefix MINUTE() 
 * @method TimePrefix HOUR() 
 * @method TimePrefix DAY() 
 * @method TimePrefix WEEK() 
 * @method TimePrefix MONTH() 
 * @method TimePrefix YEAR() 
 */
class TimePrefix extends AbstractMultiton
{
    /**
     *
     * @var string
     */
    protected $inputPrefix;
    
    /**
     *
     * @var string
     */
    protected $intervalPrefix;
    
    /**
     *
     * @var string
     */
    protected $name;
    
    /**
     *
     * @var boolean
     */
    protected $isTime;
    
    /**
     * 
     * @return string
     */
    public function getPrefix()
    {
        return $this->inputPrefix;
    }
    
    /**
     * 
     * @return string
     */
    public function getIntervalPrefix()
    {
        return $this->intervalPrefix;
    }
    
    /**
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * 
     * @return boolean
     */
    public function isTimeModifer()
    {
        return $this->isTime;
    }
    
    protected static function initializeMembers() 
    {
        new static('SECOND', 's', 'S', 'second', true);
        new static('MINUTE', 'i', 'M', 'minute', true);
        new static('HOUR', 'h', 'H', 'hour', true);
        new static('DAY', 'd', 'D', 'day', false);
        new static('WEEK', 'w', 'W', 'week', false);
        new static('MONTH', 'm', 'M', 'month', false);
        new static('YEAR', 'y', 'Y', 'year', false);
    }
    
    /**
     * 
     * @param string $key
     * @param string $inputPrefix
     * @param string $intervalPrefix
     * @param string $name
     * @param boolean $isTime
     */
    protected function __construct($key, $inputPrefix, $intervalPrefix, $name, $isTime)
    {
        parent::__construct($key);
        
        $this->inputPrefix = $inputPrefix;
        $this->intervalPrefix = $intervalPrefix;
        $this->name = $name;
        $this->isTime = $isTime;
    }
}
