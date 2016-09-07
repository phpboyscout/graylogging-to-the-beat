<?php
require_once './vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\GelfHandler;
use Gelf\Publisher;
use Gelf\Transport\UdpTransport;


$graylogServer = "127.0.0.1";
$graylogPort = "12202";

$gelfTransport = new UdpTransport(
    $graylogServer, 
    $graylogPort , 
    UdpTransport::CHUNK_SIZE_LAN
);

$gelfPublisher = new Publisher($gelfTransport);

$gelfHandler = new GelfHandler($gelfPublisher);

$log = new Logger('php-application');
$log->pushHandler($gelfHandler);


try {

  throw new Exception('This is a test Exception', 500);

} catch (Exception $e) {

    $context = array(
        'code' => $e->getCode(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTrace(),
        'traceAsString' => $e->getTraceAsString()
    );
    $log->addError($e->getMessage(), $context);
}
