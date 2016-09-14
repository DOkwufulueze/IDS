<?php

require_once 'IDS/Log/Interface.php';

class IDS_Log_File implements IDS_Log_Interface
{

    /**
     * Path to the log file
     *
     * @var string
     */
    private $logfile = null;

    /**
     * Instance container
     *
     * Due to the singleton pattern this class allows to initiate only one 
     * instance for each file.
     *
     * @var array
     */
    private static $instances = array();

    /**
     * Holds current remote address
     *
     * @var string
     */
    private $ip = 'local/unknown';

    /**
     * Constructor
     *
     * @param string $logfile path to the log file
     * 
     * @return void
     */
    protected function __construct($logfile) 
    {

        // determine correct IP address and concat them if necessary
        $this->ip = $_SERVER['REMOTE_ADDR'] .
            (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ?
                ' (' . $_SERVER['HTTP_X_FORWARDED_FOR'] . ')' : '');

        $this->logfile = $logfile;
    }

    /**
     * Returns an instance of this class
     *
     * This method allows the passed argument to be either an instance of 
     * IDS_Init or a path to a log file. Due to the singleton pattern only one 
     * instance for each file can be initiated.
     *
     * @param  mixed  $config    IDS_Init or path to a file
     * @param  string $classname the class name to use
     * 
     * @return object $this
     */
    public static function getInstance($config, $classname = 'IDS_Log_File') 
    {
        if ($config instanceof IDS_Init) {
            $logfile = $config->getBasePath() . $config->config['Logging']['path'];
        } elseif (is_string($config)) {
            $logfile = $config;
        }
        
        if (!isset(self::$instances[$logfile])) {
            self::$instances[$logfile] = new $classname($logfile);
        }

        return self::$instances[$logfile];
    }

    /**
     * Permitting to clone this object
     *
     * For the sake of correctness of a singleton pattern, this is necessary
     * 
     * @return void
     */
    private function __clone() 
    { 
    }

    /**
     * Prepares data
     *
     * Converts given data into a format that can be stored into a file. 
     * You might edit this method to your requirements.
     *
     * @param mixed $data incoming report data
     * 
     * @return string
     */
    protected function prepareData($data) 
    {

        $format = '"%s",%s,%d,"%s","%s","%s","%s"';

        $attackedParameters = '';
        foreach ($data as $event) {
            $attackedParameters .= $event->getName() . '=' .
                rawurlencode($event->getValue()) . ' ';
        }

        $dataString = sprintf($format,
            urlencode($this->ip),
            date('c'),
            $data->getImpact(),
            join(' ', $data->getTags()),
            urlencode(trim($attackedParameters)),
            urlencode($_SERVER['REQUEST_URI']),
            $_SERVER['SERVER_ADDR']
        );

        return $dataString;
    }

    /**
     * Stores given data into a file
     *
     * @param  object $data IDS_Report
     * 
     * @throws Exception if the logfile isn't writeable
     * @return boolean
     */
    public function execute(IDS_Report $data) 
    {

        /*
         * In case the data has been modified before it might  be necessary 
         * to convert it to string since we can't store array or object 
         * into a file
         */
        $data = $this->prepareData($data);

        if (is_string($data)) {

            if (file_exists($this->logfile)) {
                $data = trim($data);

                if (!empty($data)) {
                    if (is_writable($this->logfile)) {

                        $handle = fopen($this->logfile, 'a');
                        fwrite($handle, trim($data) . "\n");
                        fclose($handle);

                    } else {
                        throw new Exception(
                            'Please make sure that ' . $this->logfile . 
                                ' is writeable.'
                        );
                    }
                }
            } else {
                throw new Exception(
                    'Given file does not exist. Please make sure the
                    logfile is present in the given directory.'
                );
            }
        } else {
            throw new Exception(
                'Please make sure that data returned by
                IDS_Log_File::prepareData() is a string.'
            );
        }

        return true;
    }
}