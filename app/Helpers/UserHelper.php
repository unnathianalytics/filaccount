<?php

use Illuminate\Support\Facades\Auth;


if (!function_exists('current_user')) {
    /**
     * @return \App\Models\User|null
     */
    function current_user()
    {
        return Auth::user();
    }
}
