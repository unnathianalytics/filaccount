<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class InjectFinancialYearDates
{
    public function handle(Request $request, Closure $next)
    {
        View::share('financialYearDates', getUserFinancialYearDates() ?? ['start_date' => null, 'end_date' => null]);
        return $next($request);
    }
}
