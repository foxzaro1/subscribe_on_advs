<?php

namespace App\Jobs;

use App\Services\Action\Mailing;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSendingEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     *
     */
    private $arr = [];
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Array $arr)
    {
        $this->arr = $arr;
        $this->handle();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mailing = new Mailing($this->arr);
        $mailing->sendEmailJobs($this->arr);
    }
}
