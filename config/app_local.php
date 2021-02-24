<?php
use Cake\Database\Connection;

/*
 * Local configuration file to provide any overrides to your app.php configuration.
 * Copy and save this file as app_local.php and make changes as required.
 * Note: It is not recommended to commit files with credentials such as app_local.php
 * into source code version control.
 */

// Generate secure salt
function create_salt() {

	// Acquire the original salt
	$original = getenv("CAKEPHP_SECURITY_SALT");

	// Attempts to get secret token from CAKEPHP_SECRET_TOKEN,
	// generated in openshift template in openshift/templates.
	// For development purposes a default secret token is used.
	if ( getenv('CAKEPHP_SECRET_TOKEN') != '' ) {
		$token = getenv('CAKEPHP_SECRET_TOKEN');
	} else {
		$token = 'te5t5tr1ng4l0c4ld3v3l0pm3nt';
	}

	// Hash the token
	$hash = hash('sha256',"$token-salt");

	$chars = '0123456789';
	$chars .= 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$chars .= '!@#$%^&*()-_ []{}<>~`+=,.;:/?|';

	// Convert the hash to an int to seed the RNG
	srand(hexdec(substr($hash,0,8)));
	// Create a random string the same length as the default
	$val = '';
	for($i = 1; $i <= strlen($original); $i++){
		$val .= substr( $chars, rand(0,strlen($chars))-1, 1);
	}
	// Reset the RNG
	srand();
	// Return the value
	return $val;

}

return [

	'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),
	/*
	 * Security and encryption configuration
	 *
	 * - salt - A random string used in security hashing methods.
	 *   The salt value is also used as the encryption key.
	 *   You should treat it as extremely sensitive data.
	 */
	'Security' => [
		'salt' => env('SECURITY_SALT', create_salt()),
	],

	/*
	 * Connection information used by the ORM to connect
	 * to your application's datastores.
	 *
	 * See app.php for more configuration options.
	 */
	'Datasources' => [
		'default' => [
			'className' => Connection::class,
			'driver' => 'Cake\Database\Driver\\' . ucfirst(env('DATABASE_ENGINE', 'Mysql')),
			'persistent' => false,
			'host' => env(strtoupper(env("DATABASE_SERVICE_NAME", 'Mysql'))."_SERVICE_HOST", ''),
			/**
			 * CakePHP will use the default DB port based on the driver selected
			 * MySQL on MAMP uses port 8889, MAMP users will want to uncomment
			 * the following line and set the port accordingly
			 */
			'port' => env(strtoupper(env("DATABASE_SERVICE_NAME", 'Mysql'))."_SERVICE_PORT", ''),
			'username' => env("DATABASE_USER", ''),
			'password' => env("DATABASE_PASSWORD", ''),
			'database' => env("DATABASE_NAME", ''),
			'encoding' => 'utf8',            /*
             * You do not need to set this flag to use full utf-8 encoding (internal default since CakePHP 3.6).
             */
			//'encoding' => 'utf8mb4',
			'timezone' => 'UTC',
			'flags' => [],
			'cacheMetadata' => true,
			'log' => false,

			/**
			 * Set identifier quoting to true if you are using reserved words or
			 * special characters in your table or column names. Enabling this
			 * setting will result in queries built using the Query Builder having
			 * identifiers quoted when creating SQL. It should be noted that this
			 * decreases performance because each query needs to be traversed and
			 * manipulated before being executed.
			 */
			'quoteIdentifiers' => false,

			/**
			 * During development, if using MySQL < 5.6, uncommenting the
			 * following line could boost the speed at which schema metadata is
			 * fetched from the database. It can also be set directly with the
			 * mysql configuration directive 'innodb_stats_on_metadata = 0'
			 * which is the recommended value in production environments
			 */
			//'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],

			'url' => env('DATABASE_URL', null),
		],

		/**
		 * The test connection is used during the test suite.
		 */
		'test' => [
			'className' => Connection::class,
			'driver' => 'Cake\Database\Driver\\' . ucfirst(env('DATABASE_ENGINE', 'Mysql')),
			'persistent' => false,
			'database' => 'test_database',
			//'encoding' => 'utf8mb4',
			'timezone' => 'UTC',
			'cacheMetadata' => true,
			'quoteIdentifiers' => false,
			'log' => false,
			//'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
			'url' => env('DATABASE_TEST_URL', null),
		],
	],

];
