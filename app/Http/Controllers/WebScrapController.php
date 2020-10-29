<?php

namespace App\Http\Controllers;

use App\Services\Action\Process;

class WebScrapController extends Controller
{
    public function get_data()
    {
        (new Process())->init();
    }
}
