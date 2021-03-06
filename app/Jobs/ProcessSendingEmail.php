<?php

namespace App\Jobs;

use App\Services\Action\Mailing;
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
    public $arr = [];

    /**
     * Create a new job instance.
     *
     * @param array $arr
     */
    public function __construct(Array $arr)
    {
        $this->arr = $arr;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mailing = new Mailing($this->arr);
        $mailing->sendEmailAdvUpdated($this->arr);
    }
}
