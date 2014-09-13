<?php

namespace chabior\JTimer\Enum;

use Eloquent\Enumeration\AbstractMultiton;

/**
 * Description of TimePrefix
 *
 * @author chabior
 * 
 * @method TimePrefix MILI_SECOND() 
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
    protected $prefix;
    
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
        return $this->prefix;
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
        new static('SECOND', 's', 'second', true);
        new static('MINUTE', 'i', 'minute', true);
        new static('HOUR', 'h', 'hour', true);
        new static('DAY', 'd', 'day', false);
        new static('WEEK', 'w', 'week', false);
        new static('MONTH', 'm', 'month', false);
        new static('YEAR', 'y', 'year', false);
    }
    
    /**
     * 
     * @param string $key
     * @param string $prefix
     * @param string $name
     */
    protected function __construct($key, $prefix, $name, $isTime)
    {
        parent::__construct($key);
        
        $this->prefix = $prefix;
        $this->name = $name;
        $this->isTime = $isTime;
    }
}
