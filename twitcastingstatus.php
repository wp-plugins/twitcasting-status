<?php
/*
Contributors: katz515
Plugin Name: Twitcasting Status
Plugin URI: http://katzueno.com/wordpress/twitcasting-status/
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=TYQTWQ7QGN36J
Description: Display the online/offline status of a Twitcasting channel.
Version: 2.0.0
Author: Katz Ueno
Author URI: http://katzueno.com/
Tags: livecasting, status, twitcasting, twitter, facebook
License: GPL2
*/

/*  Copyright 2011  Katsuyuki Ueno  (email : katz515@deerstudio.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class wp_twitcasting_status_widget extends WP_Widget {

	// ============================================================
	// Constructer
	// ============================================================
	function wp_twitcasting_status_widget () {
		$widget_ops = array(
        'description' => 'Display Twitcasting online status'
	);
	parent::WP_Widget(false, $name = 'Twitcasting Status' ,$widget_ops);
	}

	// ============================================================
    // Form
	// ============================================================
    function form( $instance ) {
		//Reading the existing data from $instance
		$instance = wp_parse_args( (array) $instance, array( 'account' => 'YokosoNews', 'online' => '', 'offline' => '') );
		$account = esc_attr( $instance['account'] );
		$online = esc_attr( $instance['online'] );
		$offline = esc_attr( $instance['offline'] );
    ?>
    <!--Form-->
    <p><label for="<?php echo $this->get_field_id('account'); ?>"><?php _e('Twitcasting ID:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('account'); ?>" name="<?php echo $this->get_field_name('account'); ?>" type="text" value="<?php echo $account; ?>" /></label></p>

    <p><label for="<?php echo $this->get_field_id('online'); ?>"><?php _e('Online image URL:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('online'); ?>" name="<?php echo $this->get_field_name('online'); ?>" type="text" value="<?php echo $online; ?>" /></label></p>

    <p><label for="<?php echo $this->get_field_id('offline'); ?>"><?php _e('Offline image URL:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('offline'); ?>" name="<?php echo $this->get_field_name('offline'); ?>" type="text" value="<?php echo $offline; ?>" /></label></p>
    <!--/Form-->
    <?php    }


	// ============================================================
    // Update
	// ============================================================
    function update( $new_instance, $old_instance ) {
    // Old Instance and New instance
    		$instance = $old_instance;
    		$instance['account'] = preg_replace("#^.*/([^/]+)/?$#",'${1}',$new_instance['account']);
    		$instance['online'] = esc_url( $new_instance['online'] );
    		$instance['offline'] = esc_url( $new_instance['offline'] );
    return $instance;
    }

	// ============================================================
	// View
	// ============================================================
	function widget( $args, $instance ) {

		extract($args);
		$account = esc_html($instance['account']);
		$online = esc_url($instance['online']);
		$offline = esc_url($instance['offline']);

        echo $before_widget;
		if ( $account )
		echo $before_title . 'Twitcasting Status' . $after_title;
		// ==============================
		// Twitcasting Status starts here
		// ==============================
		// TRANSIENT STARTS HERE
        $transientName = 'wp_twitcasting_status_' . $account;
		if ( false === ( $TwitcastingStatusSerial = get_transient( $transientName ) ) ) {
			if (function_exists(json_decode)){
				// It wasn't there, so regenerate the data and save the transient
				$opt = stream_context_create(array(
					'http' => array( 'timeout' => 3 )
				));
				$TwitcastingStatusJson = @file_get_contents('http://api.twitcasting.tv/api/livestatus?type=jason&user=' . $account ,0,$opt);
				$TwitcastingStatusSerial = json_decode($TwitcastingStatusJson);
				set_transient( $transientName, $TwitcastingStatusSerial, 60 );
			}
		}
		// TRANSIENT ENDS HERE
			// For DEBUG
			// echo '<!--' . $TwitcastingStatusJson . '-->';
			// Decode JSON
		if (function_exists(json_decode)) {
			if ($TwitcastingStatusSerial->{'islive'}) {
				// If live
				?>
				<div align="center"><a href="http://twitcasting.tv/<?php echo $account;?>" alt="<?php _e('Click here to visit the Twitcasting page'); ?>" target="_blank">
				<img src="<?php echo $online; ?>" alt="<?php _e('Live now'); ?>" target="_blank" />
				</a></div>
			<?php } else {
				// If not live, including when the API does not respond
				?>
				<div align="center"><a href="http://twitcasting.tv/<?php echo $account;?>" alt="<?php _e('Click here to visit the Twitcasting page'); ?>" target="_blank">
				<img src="<?php echo $offline; ?>" alt="<?php _e('Offline'); ?>" />
				</a></div>
				<?php }
		} else {
			echo _e('There is no JSON support on your server. Please contact your administrator.');
		}
		// ==============================
		// Twitcasting Status ends here
		// ==============================
		echo $after_widget;
	}
}
// ============================================================
// Registering shortcode
// [twitcasting-status account='http://twitcasting.tv/yokosonews' online='online image URL' offline='offline image URL']
// ============================================================
function twitcasting_status_shortcode($atts) {
	$account = preg_replace("#^.*/([^/]+)/?$#",'${1}',$atts['account']);
    $online = esc_url($atts['online']);
    $offline = esc_url($atts['offline']);
    // ==============================
    // Twitcasting Status starts here
    // ==============================
    // TRANSIENT STARTS HERE
    $transientName = 'wp_twitcasting_status_' . $account;
    if ( false === ( $TwitcastingStatusSerial = get_transient( $transientName ) ) ) {
        if (function_exists(json_decode)){
            // It wasn't there, so regenerate the data and save the transient
            $opt = stream_context_create(array(
                'http' => array( 'timeout' => 3 )
            ));
            $TwitcastingStatusJson = @file_get_contents('http://api.twitcasting.tv/api/livestatus?type=jason&user=' . $account ,0,$opt);
            $TwitcastingStatusSerial = json_decode($TwitcastingStatusJson);
            set_transient( $transientName, $TwitcastingStatusSerial, 60 );
        }
    }
    // TRANSIENT ENDS HERE
    if (function_exists(json_decode)) {
        if ($TwitcastingStatusSerial->{'islive'}) {
            // If live
            ?>
            <a href="http://twitcasting.tv/<?php echo $account;?>" alt="<?php _e('Click here to visit the Twitcasting page'); ?>" target="_blank">
            <img src="<?php echo $online; ?>" alt="<?php _e('Live now'); ?>" target="_blank" />
            </a>
        <?php } else {
            // If not live, including when the API does not respond
            ?>
            <a href="http://twitcasting.tv/<?php echo $account;?>" alt="<?php _e('Click here to visit the Twitcasting page'); ?>" target="_blank">
            <img src="<?php echo $offline; ?>" alt="<?php _e('Offline'); ?>" />
            </a>
            <?php }
    } else {
        echo _e('There is no JSON support on your server. Please contact your administrator.');
    }
    // ==============================
    // Twitcasting Status ends here
    // ==============================
}

// ============================================================
// Registering plug-ins
// ============================================================
function wpTwitcastingStatusInit() {
    // Registering class name
    register_widget('wp_twitcasting_status_widget');
}

// ============================================================
// execute wpTwitcastingStatusInit()
// ============================================================
add_action('widgets_init', 'wpTwitcastingStatusInit');
add_shortcode('twitcasting-status', 'twitcasting_status_shortcode' );
?>
