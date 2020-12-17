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
if( ! function_exists( 'wpcd_coupon_print_link' ) ) {
    function wpcd_coupon_print_link( $coupon_unic_attr ) {
        if( ! $coupon_unic_attr ) return '';

        $out = '<div style="text-align:center">';
        $wpcd_frontend_style_url = WPCD_Assets::wpcd_frontend_css_url_get();
        $out .= '<a class="coupon-print-link" style="cursor: pointer" 
            onclick="wpcd_printCoupon( \'' . $coupon_unic_attr . '\', \'' . $wpcd_frontend_style_url . '\' )">' .
            __( "Click To Print", "wpcd-coupon" ) .
            '</a>';
        $out .= '</div>';

        echo $out;
    }
}

// generation uniq string
if( ! function_exists( 'wpcd_uniq_attr' ) ) {
    function wpcd_uniq_attr( $length = 10 ) {
        if ( function_exists( 'random_bytes' ) ) {
            $bytes = random_bytes( ceil( $length / 2 ) );
        } elseif ( function_exists( 'openssl_random_pseudo_bytes' ) ) {
            $bytes = openssl_random_pseudo_bytes( ceil( $length / 2 ) );
        } else {
            return false;
        }
        return substr( bin2hex( $bytes ), 0, $length );
    }
}

if( ! function_exists( 'infinite_scroll_in_archive' ) ) {

    /**
     * check option's activity infinite scroll in archive
     * @return bool
     */
    function infinite_scroll_in_archive() {
        $infinite_scroll_in_archive = get_option( 'wpcd_infinite-scroll-in-archive' );
        if ( !empty( $infinite_scroll_in_archive ) && $infinite_scroll_in_archive == 'on' ) {
            return true;
        } else {
            return false;
        }
    }
}
