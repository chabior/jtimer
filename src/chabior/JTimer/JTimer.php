<?php

namespace chabior\JTimer;

/**
 * Description of JTimer
 *
 * @author chabior
 */
class JTimer
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
     * @param \chabior\JTimer\Enum\TimePrefix $timePreFix
     * @param mixed $value
     * @throws Exception\InvalidTimePrefixException
     */
    public function changeTime(Enum\TimePrefix $timePreFix, $value)
    {
        $prefix = $timePreFix->getPrefix();
        
        if ($timePreFix->isTimeModifer()) {
            $modifers = & $this->timeModifers;
        } else {
            $modifers = & $this->dayModifers;
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
        return $this->getAsPrefix('m');
    }
    
    /**
     * 
     * @return integer
     */
    public function getDays()
    {
        return $this->getAsPrefix('d');
    }
    
    /**
     * 
     * @return integer
     */
    public function getSeconds()
    {
        return $this->getAsPrefix('s');
    }
    
    /**
     * 
     * @return integer
     */
    public function getMinutes()
    {
        return $this->getAsPrefix('i');
    }
    
    /**
     * 
     * @return integer
     */
    public function getHours()
    {
        return $this->getAsPrefix('h');
    }
    
    /**
     * 
     * @return integer
     */
    public function getYears()
    {
        return $this->getAsPrefix('y');
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
     * @param string $prefix
     * @return int
     * @throws Exception\InvalidTimePrefixException
     */
    public function getAsPrefix($prefix)
    {
        $interval = $this->getDateInterval();
        
        if (!property_exists($interval, $prefix)) {
            throw Exception\InvalidTimePrefixException::get($prefix);
        }
        
        return $interval->$prefix;
    }
    
    /**
     * Change time to proper value like 3600s to 1 hour
     */
    protected function recalculate()
    {
        $interval = new \DateInterval($this->getIntervalSpec());
        
        $obj1 = new \DateTime();
        $obj2 = new \DateTime();
        $obj2->modify($interval);
        
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
        
        $timeSpec .= $this->getDayString();
        
        if (count($this->timeModifers) > 0) {
            $timeSpec .= 'T';

            $timeSpec .= $this->getTimeString();
        }
        
        return $timeSpec;
    }
    
    /**
     * 
     * @return string
     */
    protected function getDayString()
    {
        $timeSpec = '';
        
        foreach ($this->dayModifers as $prefix => $value) {
            $timeSpec .= $value.$prefix;
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

        foreach ($this->timeModifers as $prefix => $value) {
            $timeSpec .= $value.$prefix;
        }
        
        return $timeSpec;
    }
}
