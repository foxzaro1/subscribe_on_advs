<?php

namespace App\Http\Controllers;

use App\Services\Action\Process;

class WebScrapController extends Controller
{
    public function get_data(){
        $treatment = new Process();
        $treatment->init();
    }
}