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

  /**
   * preferred process, as included in the ProcessCliBackend, it will
   * also display a much more verbose displayName()
   */
  ProcessCliBackend::dispatch()
    ->delay(now()->addSeconds($seconds))
    ->onQueue('dev')
  ;

  /**
   * below also works but will only display:
   *   Processing: Closure (console.php:30)
   *   Processed:  Closure (console.php:30)
   */
  // dispatch(function(){
  //   Artisan::call('up');
  // })->onQueue('dev')->delay(now()->addSeconds($seconds));

  Log::to('queue', 'dispatch job using cli');
  $this->comment('dispatched a job: '.$seconds.'s');
});
