<?php

namespace App\Http\Controllers;

use App\User;
use App\Jobs\SendNoticeEmail;

class UserController extends Controller
{
    public function sendNoticeEmail()
    {
        $user = User::findOrFail(1);

        $job  = (new SendNoticeEmail($user))->onQueue('emails');
        // php artisan queue:listen --queue=emails
        //$job  = (new SendNoticeEmail($user))->delay('10');

        $this->dispatch($job);

        return view('emails.sendmail');
    }
}