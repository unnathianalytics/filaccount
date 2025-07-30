<?php

if (!function_exists('rupees')) {

    function rupees($num, $decimals = 2, $decimalSeparator = '.', $thousandsSeparator = ',')
    {
        if (!is_numeric($num)) {
            return $num; // Return unchanged if not a number
        }

        // Handle negative numbers
        $isNegative = $num < 0;
        $num = abs((float)$num);

        // Split the number into integer and decimal parts
        $numParts = explode('.', $num);
        $integerPart = $numParts[0];
        $decimalPart = isset($numParts[1]) ? $decimalSeparator . str_pad($numParts[1], $decimals, '0', STR_PAD_RIGHT) : $decimalSeparator . str_repeat('0', $decimals);

        // Format the integer part with Indian numbering system
        if (strlen($integerPart) > 3) {
            $lastthree = substr($integerPart, -3);
            $restunits = substr($integerPart, 0, -3);
            $restunits = (strlen($restunits) % 2 == 1) ? "0$restunits" : $restunits;
            $expunit = str_split($restunits, 2);
            $explrestunits = '';
            for ($i = 0; $i < sizeof($expunit); $i++) {
                if ($i == 0) {
                    $explrestunits .= (int)$expunit[$i] . $thousandsSeparator;
                } else {
                    $explrestunits .= $expunit[$i] . $thousandsSeparator;
                }
            }
            $thecash = $explrestunits . $lastthree;
        } else {
            $thecash = $integerPart;
        }

        // Combine integer and decimal parts
        $result = $thecash . $decimalPart;

        // Handle negative sign
        return $isNegative ? '-' . $result : $result;
    }
}
if (!function_exists('formatAmountWithDrCr')) {
    function formatAmountWithDrCr($amount, $format = true)
    {
        if ($amount > 0) {
            return $format == true ? abs($amount) . ' Cr' : $amount;
        } elseif ($amount <= 0) {
            return $format == true ? abs($amount) . ' Dr' : $amount;
        }
    }
}
