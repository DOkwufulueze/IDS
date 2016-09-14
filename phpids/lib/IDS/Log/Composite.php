<?php
require_once 'IDS/Log/Interface.php';

class IDS_Log_Composite
{

    /**
     * Holds registered logging wrapper
     *
     * @var array
     */
    public $loggers = array();

    /**
     * Iterates through registered loggers and executes them
     *
     * @param object $data IDS_Report object
     * 
     * @return void
     */
    public function execute(IDS_Report $data) 
    {
    	// make sure request uri is set right on IIS
        if (!isset($_SERVER['REQUEST_URI'])) {
            $_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'], 1);
            if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']) { 
                $_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING']; 
            } 
        } 
        
        // make sure server address is set right on IIS
        if (isset($_SERVER['LOCAL_ADDR'])) {
            $_SERVER['SERVER_ADDR'] = $_SERVER['LOCAL_ADDR'];
        } 
    	
        foreach ($this->loggers as $logger) {
            $logger->execute($data);
        }
    }

    /**
     * Registers a new logging wrapper
     *
     * Only valid IDS_Log_Interface instances passed to this function will be 
     * registered
     *
     * @return void
     */
    public function addLogger() 
    {

        $args = func_get_args();

        foreach ($args as $class) {
            if (!in_array($class, $this->loggers) && 
                ($class instanceof IDS_Log_Interface)) {
                $this->loggers[] = $class;
            }
        }
    }

    /**
     * Removes a logger
     *
     * @param object $logger IDS_Log_Interface object
     * 
     * @return boolean
     */
    public function removeLogger(IDS_Log_Interface $logger) 
    {
        $key = array_search($logger, $this->loggers);

        if (isset($this->loggers[$key])) {
            unset($this->loggers[$key]);
            return true;
        }

        return false;
    }
}

