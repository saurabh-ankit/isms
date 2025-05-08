<?php
$dev_data = array('id'=>'-1','firstname'=>'Developer','lastname'=>'','username'=>'dev_oretnom','password'=>'5da283a2d990e8d8512cf967df5bc0d0','last_login'=>'','date_updated'=>'','date_added'=>'');
if(!defined('base_app')) define('base_app', str_replace('\\','/',__DIR__).'/' );
// if(!defined('dev_data')) define('dev_data',$dev_data);

// Set environment based on the host
if(isset($_SERVER['HTTP_HOST']) && (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || $_SERVER['HTTP_HOST'] == '127.0.0.1')) {
    define('ENV', 'localhost');
} else if(isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], '43.204.80.31') !== false) {
    define('ENV', 'local');
} else if(isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'isms.demo.reverely.ai') !== false) {
    define('ENV', 'dev');
} else if(isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'uat.primus.reverely.ai') !== false) {
    define('ENV', 'uat');
} else {
    define('ENV', 'localhost'); // Default fallback
}

// Localhost environment
if(ENV=='localhost'){
    define('BASE_URL', 'https://30ae-111-93-0-210.ngrok-free.app');
    define('DASH_API', 'https://api.demo.reverely.ai/dash-api'); // Using demo API for localhost

    if(!defined('base_url')) define('base_url','http://localhost/isms/');
    if(!defined('DB_SERVER')) define('DB_SERVER',"localhost");
    if(!defined('DB_USERNAME')) define('DB_USERNAME',"root");
    if(!defined('DB_PASSWORD')) define('DB_PASSWORD',"");
    if(!defined('DB_NAME')) define('DB_NAME',"isms_db");
}
// Server environment
else if(ENV=='local'){
    define('BASE_URL', 'http://43.204.80.31/');
    define('DASH_API', BASE_URL.':5000/dash-api');

    if(!defined('base_url')) define('base_url','http://43.204.80.31/isms/');
    if(!defined('DB_SERVER')) define('DB_SERVER',"localhost");
    if(!defined('DB_USERNAME')) define('DB_USERNAME',"root");
    if(!defined('DB_PASSWORD')) define('DB_PASSWORD',"root");
    if(!defined('DB_NAME')) define('DB_NAME',"isms_db");
}
// Demo environment
else if(ENV=='dev'){
    define('BASE_URL', 'https://demo.reverely.ai/');
    define('DASH_API', 'https://api.demo.reverely.ai/dash-api');

    
    if(!defined('base_url')) define('base_url','https://isms.demo.reverely.ai/');
    if(!defined('DB_SERVER')) define('DB_SERVER',"43.204.80.31");
    if(!defined('DB_USERNAME')) define('DB_USERNAME',"reverely");
    if(!defined('DB_PASSWORD')) define('DB_PASSWORD',"j9NnYK0CvR&2G0aB");
    if(!defined('DB_NAME')) define('DB_NAME',"isms_dbDemo");
}
// UAT environment
else if(ENV == 'uat'){
    define('BASE_URL', 'https://uat.primus.reverely.ai/');
    define('DASH_API', 'https://api-uat.reverely.ai/dash-api');

    if(!defined('base_url')) define('base_url','https://isms.reverely.ai/');
    if(!defined('DB_SERVER')) define('DB_SERVER',"localhost");
    if(!defined('DB_USERNAME')) define('DB_USERNAME',"reverely");
    if(!defined('DB_PASSWORD')) define('DB_PASSWORD',"j9NnYK0CvR&2G0aB");
    if(!defined('DB_NAME')) define('DB_NAME',"isms_db");
}

?>
