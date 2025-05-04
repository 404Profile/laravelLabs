<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;

class AssignUserRandomColor
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $randomColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        Session::put('user_color', $randomColor);
    }
}
