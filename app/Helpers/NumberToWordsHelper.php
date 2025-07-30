<?php

if (!function_exists('in_words')) {
    function in_words($number)
    {
        $number = round($number, 2);
        $no = floor($number);
        $decimal = round(($number - $no) * 100);

        $words = [
            0 => '',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Forty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety'
        ];

        $digits = ['', 'Thousand', 'Lakh', 'Crore'];
        $str = [];

        $numStr = (string) $no;
        $numLength = strlen($numStr);

        $segments = [];

        if ($numLength > 3) {
            $lastThree = substr($numStr, -3);
            $remaining = substr($numStr, 0, -3);

            // Break the remaining into 2 digits
            $remainingSegments = str_split(strrev($remaining), 2);
            $remainingSegments = array_map('strrev', $remainingSegments);
            $remainingSegments = array_reverse($remainingSegments);

            foreach ($remainingSegments as $seg) {
                $segments[] = (int) $seg;
            }
            $segments[] = (int) $lastThree;
        } else {
            $segments[] = (int) $numStr;
        }

        $segments = array_reverse($segments);

        foreach ($segments as $index => $segmentValue) {
            if ($segmentValue == 0) continue;

            $text = '';

            if ($segmentValue < 21) {
                $text = $words[$segmentValue];
            } else {
                $tens = floor($segmentValue / 10) * 10;
                $units = $segmentValue % 10;
                $text = $words[$tens] . ' ' . $words[$units];
            }

            if ($index == 0) {
                // Last three digits (Hundreds)
                if ($segmentValue > 99) {
                    $hundreds = floor($segmentValue / 100);
                    $remainder = $segmentValue % 100;
                    $text = $words[$hundreds] . ' Hundred';
                    if ($remainder > 0) {
                        if ($remainder < 21) {
                            $text .= ' ' . $words[$remainder];
                        } else {
                            $tens = floor($remainder / 10) * 10;
                            $units = $remainder % 10;
                            $text .= ' ' . $words[$tens] . ' ' . $words[$units];
                        }
                    }
                }
                $str[] = trim($text);
            } else {
                $str[] = trim($text . ' ' . $digits[$index]);
            }
        }

        $result = implode(' ', array_reverse($str));
        $result = preg_replace('/\s+/', ' ', $result);

        if ($result == '') {
            $result = 'Zero';
        }

        $paise = '';
        if ($decimal > 0) {
            if ($decimal < 21) {
                $paiseWords = $words[$decimal];
            } else {
                $paiseWords = $words[floor($decimal / 10) * 10] . ' ' . $words[$decimal % 10];
            }
            $paise = ' and ' . trim($paiseWords) . ' Paise';
        }

        return trim($result) . ' Rupees' . $paise . ' Only';
    }
}
