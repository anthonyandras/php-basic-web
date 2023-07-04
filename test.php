<?php

// saw define() used in some php scripts, so thought i'd play around a bit

define("CONSTANT", "Hello world.");
echo CONSTANT;
//echo Constant;

define("GREETING", "Hello you.", true); // no longer really works in PHP7+
echo GREETING;
//echo Greeting; // Breaks, case insensitive comments no longer supported

define('ANIMALS', array( 
	'dog',
	'cat',
	'bird'
));

echo ANIMALS[1];


//var_dump(defined('__LINE__'));
//var_dump(defined('__LINE__'), 'test');
//var_dump(constant('__LINE__'));
//var_dump(__LINE__);
?>
