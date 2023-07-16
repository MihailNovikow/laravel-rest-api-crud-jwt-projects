<?php

namespace App\Http\Controllers\Api;
use App\Jobs\SendTextJob;
use App\Http\Controllers\Controller;
class SendController extends Controller
{
    public function sendText()
    {
        SendTextJob::dispatch()->onQueue('text');
    }
}
