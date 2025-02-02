<?php

class Calculator
{
    public function calculate_fibonacci($number){
        $n = $number;
        if ($n == 0) return 0;
        if ($n == 1) return 1;
        $a = 0;
        $b = 1;
        for ($i = 2; $i <= $n; $i++) {
            $temp = $a + $b;
            $a = $b;
            $b = $temp;
        }
        return $b;
    }
}