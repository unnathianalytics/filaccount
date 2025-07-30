<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('getUserFinancialYearDates')) {
    /**
     * Get the start and end dates of the authenticated user's financial year.
     *
     * @return array{start_date: ?string, end_date: ?string}|null
     */
    function getUserFinancialYearDates(): array
    {
        $user = Auth::user();
        if ($user && $user->financialYear) {
            return [
                'from_date' => $user->financialYear->start_date->format('Y-m-d'),
                'to_date' => $user->financialYear->end_date->format('Y-m-d'),
            ];
        } else {
            $currentDate = new DateTime();
            $currentMonth = (int) $currentDate->format('m');
            $currentYear = (int) $currentDate->format('Y');

            // If current date is before April, use previous year as start of financial year
            $fromYear = ($currentMonth < 4) ? $currentYear - 1 : $currentYear;

            $toYear = $fromYear + 1;

            return [
                'from_date' => sprintf('%d-04-01', $fromYear),
                'to_date' => sprintf('%d-03-31', $toYear),
            ];
        }
    }
}
