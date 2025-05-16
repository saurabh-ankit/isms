<?php
$dev_data = array(
    'id' => '-1',
    'firstname' => 'Developer',
    'lastname' => '',
    'username' => 'dev_oretnom',
    'password' => '5da283a2d990e8d8512cf967df5bc0d0',
    'last_login' => '',
    'date_updated' => '',
    'date_added' => ''
);

if (!defined('base_app')) define('base_app', str_replace('\\', '/', __DIR__) . '/');

// Detect environment from domain
if (isset($_SERVER['HTTP_HOST'])) {
    if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || $_SERVER['HTTP_HOST'] === '127.0.0.1') {
        define('ENV', 'localhost');
    } else if (strpos($_SERVER['HTTP_HOST'], '43.204.80.31') !== false) {
        define('ENV', 'local');
    } else if (strpos($_SERVER['HTTP_HOST'], 'manasum.reverely.ai') !== false) {
        define('ENV', 'dev'); // Manasul environment
    } else if (strpos($_SERVER['HTTP_HOST'], 'uat.primus.reverely.ai') !== false) {
        define('ENV', 'uat');
    } else {
        define('ENV', 'localhost'); // Default fallback
    }
} else {
    define('ENV', 'localhost'); // Fallback if HTTP_HOST not set
}

// Environment-specific configs
switch (ENV) {
    case 'localhost':
        define('BASE_URL', 'https://30ae-111-93-0-210.ngrok-free.app');
        define('DASH_API', 'https://api.demo.reverely.ai/dash-api');
        if (!defined('base_url')) define('base_url', 'http://localhost/isms/');
        define('DB_SERVER', "localhost");
        define('DB_USERNAME', "root");
        define('DB_PASSWORD', "");
        define('DB_NAME', "isms_db");
        break;

    case 'local':
        define('BASE_URL', 'http://43.204.80.31/');
        define('DASH_API', BASE_URL . ':5000/dash-api');
        if (!defined('base_url')) define('base_url', 'http://43.204.80.31/isms/');
        define('DB_SERVER', "localhost");
        define('DB_USERNAME', "root");
        define('DB_PASSWORD', "root");
        define('DB_NAME', "isms_db");
        break;

    case 'dev': // Manasul credentials
        define('BASE_URL', 'https://manasum.reverely.ai/isms/');
        define('DASH_API', 'https://manasum.reverely.ai/dash-api');
        define('BASE_API', 'https://roster.demo.reverely.ai'); 

        define('DB_SERVER', "reverely.coxl0tpp5cfv.ap-south-1.rds.amazonaws.com");
        define('DB_USERNAME', "admin");
        define('DB_PASSWORD', "R3vEr3LYPr0dUct!0n2025");
        define('DB_NAME', "isms_dbDemo");
        if (!defined('base_url')) define('base_url', BASE_URL);
        break;

    case 'uat':
        define('BASE_URL', 'https://uat.primus.reverely.ai/');
        define('DASH_API', 'https://api-uat.reverely.ai/dash-api');
        if (!defined('base_url')) define('base_url', 'https://isms.reverely.ai/');
        define('DB_SERVER', "localhost");
        define('DB_USERNAME', "reverely");
        define('DB_PASSWORD', "j9NnYK0CvR&2G0aB");
        define('DB_NAME', "isms_db");
        break;
}
?>
