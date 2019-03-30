<?php

// getting date format for PHP date function
if( ! function_exists( 'wpcd_getExpireDateFormatFun' ) ) {
    function wpcd_getExpireDateFormatFun( $expireDateFormat ) {
        if ( $expireDateFormat == 'mm/dd/yy' ) {
            $expireDateFormatFun = 'm/d/Y';
        } elseif ( $expireDateFormat == 'yy/mm/dd' ) {
            $expireDateFormatFun = 'Y/m/d';
        } else {
            $expireDateFormatFun = 'd-m-Y';
        }

        return $expireDateFormatFun;
    }
}

// parsing date and convert it to timestamp
if ( ! function_exists( 'wpcd_datetotime' ) ) {
    function wpcd_datetotime ( $date ) {
        $strtotime = strtotime( $date );
        if( empty( $strtotime ) ) {
            $date_arr = explode( '-', $date );
            if ( is_array( $date_arr ) && $date_arr[0] == $date ) {
                $date_arr = explode( '/', $date );
            }
            if ( is_array( $date_arr ) && $date_arr[0] == $date ) {
                $date_arr = explode( '.', $date );
            }
            if( ( is_array( $date_arr ) && $date_arr[0] == $date ) || ! $date_arr ) {
                return false;
            } else {
                $year;
                $a;
                $b;
                foreach( $date_arr as $val ) {
                    if ( empty( $a ) && mb_strlen( $val ) == 2 ) {
                        $a = $val;
                        continue;
                    }
                    if( empty( $b ) && mb_strlen( $val ) == 2 ) {
                        $b = $val;
                        continue;
                    }
                    if ( mb_strlen( $val ) >= 4 ) {
                        $year = $val;
                    }
                }
            }
            $date = $a . '-' . $b . '-' . $year;
            $strtotime = strtotime( $date );
            if( empty( $strtotime ) ) {
                $date = $b . '-' . $a . '-' . $year;
                $strtotime = strtotime( $date );
            }
        }
        return $strtotime;
    }
}
