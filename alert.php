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

for ($i=0; $i < 501; $i++) {
   $log->addError('This is an error.... will it trigger an alert!!!', array('code' => 500));
}
