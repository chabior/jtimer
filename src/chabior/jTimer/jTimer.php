<?php

namespace chabior\jTimer;

/**
 * Description of jTimer
 *
 * @author chabior
 */
class jTimer
{
    /**
     *
     * @var boolean
     */
    protected $isNegative = false;
    
    /**
     *
     * @var array
     */
    protected $dayModifers = array();
    
    /**
     *
     * @var array
     */
    protected $timeModifers = array();
    
    /**
     *
     * @var \DateInterval
     */
    protected $recalculated;
    
    /**
     * 
     * @param boolean $isNegative
     */
    public function setIsNegative($isNegative) 
    {
        $this->isNegative = $isNegative;
    }
    
    /**
     * 
     * @param \chabior\jTimer\Enum\TimePrefix $timePreFix
     * @param mixed $value
     * @throws Exception\InvalidTimePrefixException
     */
    public function changeTime(Enum\TimePrefix $timePreFix, $value)
    {
        $prefix = $timePreFix->key();
        
        if ($timePreFix->isTimeModifer()) {
            $modifers = & $this->timeModifers;
        } else {
            $modifers = & $this->dayModifers;
        }
        
        if ('WEEK' === $prefix) {
            $value *= 7;
            $prefix = 'DAY';
        }
        
        if (!isset($modifers[$prefix])) {
            $modifers[$prefix] = 0;
        }
        
        
        $modifers[$prefix] += $value;
        
        $this->recalculated = null;
    }
    
    /**
     * 
     * @return \DateInterval
     */
    public function getDateInterval()
    {
        if (null === $this->recalculated) {
            $this->recalculate();
        }
        
        return $this->recalculated;
    }
    
    /**
     * 
     * @return integer
     */
    public function getMonths()
    {
        return $this->getAsPrefix(Enum\TimePrefix::MONTH());
    }
    
    /**
     * 
     * @return integer
     */
    public function getDays()
    {
        return $this->getAsPrefix(Enum\TimePrefix::DAY());
    }
    
    /**
     * 
     * @return integer
     */
    public function getSeconds()
    {
        return $this->getAsPrefix(Enum\TimePrefix::SECOND());
    }
    
    /**
     * 
     * @return integer
     */
    public function getMinutes()
    {
        return $this->getAsPrefix(Enum\TimePrefix::MINUTE());
    }
    
    /**
     * 
     * @return integer
     */
    public function getHours()
    {
        return $this->getAsPrefix(Enum\TimePrefix::HOUR());
    }
    
    /**
     * 
     * @return integer
     */
    public function getYears()
    {
        return $this->getAsPrefix(Enum\TimePrefix::YEAR());
    }
    
    /**
     * 
     * @return string
     */
    public function getAsString()
    {
        $timeSpec = $this->getDayString().$this->getTimeString();
        
        if (true === $this->isNegative) {
            $timeSpec = '-'.$timeSpec;
        }
        
        return $timeSpec;
    }
    
    /**
     * 
     * @param Enum\TimePrefix $prefix
     * @return int
     * @throws Exception\InvalidTimePrefixException
     */
    public function getAsPrefix($prefix)
    {
        $interval = $this->getDateInterval();
        
        $timePrefix = $prefix->getPrefix();
        if (!property_exists($interval, $timePrefix)) {
            throw Exception\InvalidTimePrefixException::get($timePrefix);
        }
        
        return $interval->$timePrefix;
    }
    
    /**
     * Change time to proper value like 3600s to 1 hour
     */
    protected function recalculate()
    {
        $timeSpec = $this->getIntervalSpec();
        $interval = new \DateInterval($timeSpec);
        
        $obj1 = new \DateTime();
        $obj2 = clone $obj1;
        $obj2->add($interval);
        
        $this->recalculated = $obj2->diff($obj1);
        
        $this->recalculated->invert = (int) $this->isNegative;
    }
    
    /**
     * 
     * @return string
     */
    protected function getIntervalSpec()
    {
        $timeSpec = 'P';
        
        $timeSpec .= $this->getIntervalDayString();
        
        if (count($this->timeModifers) > 0) {
            $timeSpec .= 'T';

            $timeSpec .= $this->getIntervalTimeString();
        }
        
        return strtoupper($timeSpec);
    }
    
    /**
     * 
     * @return string
     */
    protected function getDayString()
    {
        $timeSpec = '';
        
        foreach ($this->dayModifers as $key => $value) {
            $timePrefix = Enum\TimePrefix::memberByKey($key);
            /* @var $timePrefix Enum\TimePrefix */
            $timeSpec .= $value.$timePrefix->getPrefix();
        }
        
        return $timeSpec;
    }
    
    /**
     * 
     * @return string
     */
    protected function getTimeString()
    {
       $timeSpec = '';

        foreach ($this->timeModifers as $key => $value) {
            $timePrefix = Enum\TimePrefix::memberByKey($key);
            /* @var $timePrefix Enum\TimePrefix */
            $timeSpec .= $value.$timePrefix->getPrefix();
        }
        
        return $timeSpec;
    }
    
    /**
     * 
     * @return string
     */
    protected function getIntervalDayString()
    {
        $timeSpec = '';
        
        foreach ($this->dayModifers as $key => $value) {
            $timePrefix = Enum\TimePrefix::memberByKey($key);
            /* @var $timePrefix Enum\TimePrefix */
            $timeSpec .= $value.$timePrefix->getIntervalPrefix();
        }
        
        return $timeSpec;
    }
    
    /**
     * 
     * @return string
     */
    protected function getIntervalTimeString()
    {
       $timeSpec = '';

        foreach ($this->timeModifers as $key => $value) {
            $timePrefix = Enum\TimePrefix::memberByKey($key);
            /* @var $timePrefix Enum\TimePrefix */
            $timeSpec .= $value.$timePrefix->getIntervalPrefix();
        }
        
        return $timeSpec;
    }
}
