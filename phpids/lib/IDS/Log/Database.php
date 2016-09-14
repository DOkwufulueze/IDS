<?php


require_once 'IDS/Log/Interface.php';


class IDS_Log_Database implements IDS_Log_Interface
{

    /**
     * Database wrapper
     *
     * @var string
     */
    private $wrapper = null;

    /**
     * Database user
     *
     * @var string
     */
    private $user = null;

    /**
     * Database password
     *
     * @var string
     */
    private $password = null;

    /**
     * Database table
     *
     * @var string
     */
    private $table = null;

    /**
     * Database handle
     *
     * @var object  PDO instance
     */
    private $handle    = null;

    /**
     * Prepared SQL statement
     *
     * @var string
     */
    private $statement = null;

    /**
     * Holds current remote address
     *
     * @var string
     */
    private $ip = 'local/unknown';

    /**
     * Instance container
     *
     * Due to the singleton pattern this class allows to initiate only one instance
     * for each database wrapper.
     *
     * @var array
     */
    private static $instances = array();

    /**
     * Constructor
     *
     * Prepares the SQL statement
     *
     * @param mixed $config IDS_Init instance | array
     * 
     * @return void
     * @throws PDOException if a db error occurred
     */
    protected function __construct($config) 
    {

        if ($config instanceof IDS_Init) {
            $this->wrapper  = $config->config['Logging']['wrapper'];
            $this->user     = $config->config['Logging']['user'];
            $this->password = $config->config['Logging']['password'];
            $this->table    = $config->config['Logging']['table'];

        } elseif (is_array($config)) {
            $this->wrapper  = $config['wrapper'];
            $this->user     = $config['user'];
            $this->password = $config['password'];
            $this->table    = $config['table'];
        }

        // determine correct IP address and concat them if necessary
        $this->ip  = $_SERVER['REMOTE_ADDR'];
        $this->ip2 = isset($_SERVER['HTTP_X_FORWARDED_FOR']) 
            ? $_SERVER['HTTP_X_FORWARDED_FOR'] 
            : '';

        try {
            $this->handle = new PDO(
                $this->wrapper,
                $this->user,
                $this->password
            );

            $this->statement = $this->handle->prepare('
                INSERT INTO ' . $this->table . ' (
                    name,
                    value,
                    page,
                    tags,
                    ip,
                    ip2,
                    impact,
                    origin,
                    created
                )
                VALUES (
                    :name,
                    :value,
                    :page,
                    :tags,
                    :ip,
                    :ip2,
                    :impact,
                    :origin,
                    now()
                )
            ');

        } catch (PDOException $e) {
            throw new PDOException('PDOException: ' . $e->getMessage());
        }
    }

    /**
     * Returns an instance of this class
     *
     * This method allows the passed argument to be either an instance of IDS_Init or
     * an array.
     *
     * @param  mixed  $config    IDS_Init | array
     * @param  string $classname the class name to use
     * 
     * @return object $this
     */
    public static function getInstance($config, $classname = 'IDS_Log_Database')
    {
        if ($config instanceof IDS_Init) {
            $wrapper = $config->config['Logging']['wrapper'];
        } elseif (is_array($config)) {
            $wrapper = $config['wrapper'];
        }

        if (!isset(self::$instances[$wrapper])) {
            self::$instances[$wrapper] = new $classname($config);
        }

        return self::$instances[$wrapper];
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
     * Stores given data into the database
     *
     * @param object $data IDS_Report instance
     * 
     * @throws Exception if db error occurred
     * @return boolean
     */
    public function execute(IDS_Report $data) 
    {
        if (!isset($_SERVER['REQUEST_URI'])) {
            $_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'], 1);
            if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']) { 
                $_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING']; 
            } 
        }     	

        foreach ($data as $event) {
            $page = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
            $ip   = $this->ip;
            $ip2  = $this->ip2;
            
            $name   = $event->getName();
            $value  = $event->getValue();
            $impact = $event->getImpact();
            $tags   = implode(', ', $event->getTags());

            $this->statement->bindParam('name', $name);
            $this->statement->bindParam('value', $value);
            $this->statement->bindParam('page', $page);
            $this->statement->bindParam('tags', $tags);
            $this->statement->bindParam('ip', $ip);
            $this->statement->bindParam('ip2', $ip2);
            $this->statement->bindParam('impact', $impact);
            $this->statement->bindParam('origin', $_SERVER['SERVER_ADDR']);

            if (!$this->statement->execute()) {

                $info = $this->statement->errorInfo();
                throw new Exception(
                    $this->statement->errorCode() . ', ' . $info[1] . ', ' . $info[2]
                );
            }
        }

        return true;
    }
}
