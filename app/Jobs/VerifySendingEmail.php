<?php

namespace App\Jobs;

use App\Services\Action\Mailing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VerifySendingEmail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;


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
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mailing = new Mailing($this->arr);
        $mailing->sendEmailVerifyCode($this->arr);
    }
}
