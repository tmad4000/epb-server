

<?php
//display and log

ini_set("log_errors", 1);
ini_set("error_log", "tmp/php-error.log");
error_log( "Hello, errors2!" );

echo 'aoeu';
error_reporting(-1);
ini_set('display_errors','On');
echo 'aoeu2';
reqauire('aoeu')



/*
log but don't display

ini_set("log_errors", 1);
ini_set("error_log", "tmp/php-error.log");
error_log( "Hello, errors2!" );

echo 'aoeu';
error_reporting(-1);
ini_set('display_errors','Off');
echo 'aoeu2';
reqauire('aoeu')


*/
?>