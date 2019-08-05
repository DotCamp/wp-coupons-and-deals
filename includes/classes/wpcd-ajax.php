<?php

/**
 * This class is responsible for catching all ajax calls in wpcd
 *
 * @author Mohmed Elwany
 * @since 2.5.0.1
 */
class WPCD_AJAX {

    /**
     * Hook in methods - uses WordPress ajax handlers (admin-ajax).
     */
    public static function LoadEvents() {

        $ajax_events = array(
            'vote' => true,
        );

        foreach ( $ajax_events as $ajax_event => $status ) {
            if ( $status ) {
                add_action( 'wp_ajax_wpcd_' . $ajax_event, array( __CLASS__, $ajax_event ) );
                add_action( 'wp_ajax_nopriv_wpcd_' . $ajax_event, array( __CLASS__, $ajax_event ) );
            }
        }
    }

    /**
     * AJAX adding new vote
     */
    public static function vote() {
        if ( ! check_ajax_referer( 'wpcd-security-nonce', 'security' ) ) {
            wp_die();
        }
        $coupon_id = intval( $_POST['coupon_id'] );
        $meta = esc_sql( $_POST['meta'] );

        //Get the ip address of the client
        if ( !empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        if ( $meta === "up" || $meta === "down" ) {
            $meta = "_" . $meta;

            $other_meta = "_down";

            //if the main meta is up then other meta is down and vice versa
            $other_meta = ( $meta == "_up" ) ? $other_meta : "_up";
            //Get voted IPs in the selected meta
            $IPs = array_filter( explode( ",", get_post_meta( $coupon_id, $meta, true ) ) );
            //Get voted IPs in the other meta
            $other_IPs = array_filter( explode( ",", get_post_meta( $coupon_id, $other_meta, true ) ) );

            //Combine them to get all voted Ip
            $all_voted_IPs = array_merge( $IPs, $other_IPs );

            if ( empty( $all_voted_IPs ) ):
                //it's the first user that wants to vote to this coupon
                array_push( $IPs, $ip );
                array_push( $all_voted_IPs, $ip );
                update_post_meta( $coupon_id, $meta, $ip );
            else:
                if ( in_array( $ip, $all_voted_IPs ) ):
                    // this user already voted
                    echo "voted";
                    wp_die();
                else:
                    // new user want to vote
                    array_push( $IPs, $ip );
                    array_push( $all_voted_IPs, $ip );
                    update_post_meta( $coupon_id, $meta, implode( ",", $IPs ) );
                endif;
            endif;

            //calculate the percentage
            $up_votes = ( $meta == '_up' ) ? $IPs : $other_IPs;
                       
            // Return the percent of success
            $percent = ceil( count( $up_votes ) / count( $all_voted_IPs ) * 100 );
            echo "{$percent}% Success";
            
        } else {
            echo "Failed";
        }
        wp_die();
    }

}
