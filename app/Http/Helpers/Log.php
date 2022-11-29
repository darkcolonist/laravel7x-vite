<?php
namespace App\Http\Helpers;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log{
  static function to($file, $dump){
    //first parameter passed to Monolog\Logger sets the logging channel name
    $logger = new Logger('');
    $logger->pushHandler(new StreamHandler(storage_path('logs/'.$file.'.log')), Logger::INFO);
    $logger->info('', [$dump]);
  }
}
?>
