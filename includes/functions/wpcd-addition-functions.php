<?php
 
if( !function_exists( 'getExpireDateFormatFun' ) ) {
    function getExpireDateFormatFun( $expireDateFormat ) {
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
