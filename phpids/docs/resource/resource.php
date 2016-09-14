<?php
// set the include path properly for PHPIDS
set_include_path(
    get_include_path()
    . PATH_SEPARATOR
    . '../../lib/'
);

if (!session_id()) {
    session_start();
}

require_once '../../lib/IDS/Init.php';

try {

   $request = array(
        'REQUEST' => $_REQUEST,
        'GET' => $_GET,
        'POST' => $_POST,
        'COOKIE' => $_COOKIE
    );

    $init = IDS_Init::init(dirname(__FILE__) . '/../../lib/IDS/Config/Config.ini.php');

    
    $init->config['General']['base_path'] = dirname(__FILE__) . '/../../lib/IDS/';
    $init->config['General']['use_base_path'] = true;
    $init->config['Caching']['caching'] = 'none';

    $ids = new IDS_Monitor($request, $init);
    $result = $ids->run();

    if (!$result->isEmpty()) {
        echo $result;

        /*
        * The following steps are optional to log the results
        */
        require_once '../../lib/IDS/Log/File.php';
        require_once '../../lib/IDS/Log/Composite.php';

        $compositeLog = new IDS_Log_Composite();
        $compositeLog->addLogger(IDS_Log_File::getInstance($init));

        $compositeLog->execute($result);
        

    }
	else {
        echo 'No attack detected <br /><a href="?test=%22><script>eval(window.name)</script>">Click for example of an attack</a>';
		//echo 'No attack detected';
    }
}

catch (Exception $e) {
   printf(
        'An error occured: %s',
        $e->getMessage()
    );
}
?>