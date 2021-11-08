<?php

class CouponHelper
{

    /*
     * This function used to make time processable for jquery countdown
     */
    public static function processTime($expire_time)
    {
        if (!$expire_time)
            return $expire_time;

        $tmpTime = explode(':', $expire_time);
        $seconds = explode(' ', $tmpTime[1]);

        if ($seconds[1] == 'am') {
            $sec = ($seconds[0] == '0') ? ':00' : ':' . $seconds[0];
            return $tmpTime[0] . $sec;
        }

        $sec = ($seconds[0] == '0') ? ':00' : ':' . $seconds[0];
        return (12 + $tmpTime[0]) . $sec;
    }

}
