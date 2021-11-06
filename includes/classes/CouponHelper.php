<?php

class CouponHelper
{
    public static function processTime($expire_time)
    {
        if (!$expire_time)
            return $expire_time;

        $tmpTime = explode(':', $expire_time);

        if ($tmpTime[1] == '0 pm')
            return $tmpTime[0] . ':00';

        $hours = 12 + $tmpTime[0];
        return $hours . ':00';
    }
}
