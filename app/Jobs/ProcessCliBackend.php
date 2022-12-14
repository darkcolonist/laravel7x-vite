<?php

namespace App\Jobs;

use App\Http\Helpers\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class ProcessCliBackend implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $_id;

  /**
  * Create a new job instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->_id = Str::random(8);
    Log::to('queue', $this->_id . ' queued');

    return $this->_id;
  }

  public function displayName(){
    return get_class($this) . ":" . $this->_id;
  }

  /**
  * Execute the job.
  *
  * @return void
  */
  public function handle()
  {
    // Artisan::call('down');
    // sleep(3);
    Artisan::call('up');
    Log::to('queue', $this->_id.' done');
  }
}
