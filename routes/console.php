<?php

use App\Http\Helpers\Log;
use App\Jobs\ProcessCliBackend;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
  $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('test:dispatch {seconds?}', function($seconds=5){
  Artisan::call('down');
  ProcessCliBackend::dispatch()
    ->delay(now()->addSeconds($seconds))
    ->onQueue('dev')
  ;

  Log::to('queue', 'dispatch job using cli');
  $this->comment('dispatched a job: '.$seconds.'s');
});
