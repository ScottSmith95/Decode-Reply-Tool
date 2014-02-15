<?php
/*
Plugin Name: Decode Reply Tool
Plugin URI: http://ScottHSmith.com/projects/decode
Description: The perfect compliment to the Decode theme, this plugin allows your readership to reply to your posts via Twitter and App.net using a beautiful, simple reply tool placed on above or below your posts.
Version: 1.1.7
Author: Scott Smith
Author URI: http://ScottHSmith.com/
License: GPLv3
*/

/*  This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

function decode_reply_tool_options() {
    add_theme_page( __( 'Decode Reply Tool', 'decode-reply-tool' ), __( 'Decode Reply Tool', 'decode-reply-tool' ), 'manage_options', 'decode_reply_tool', 'decode_reply_tool_options_page' );
}
add_action( 'admin_menu', 'decode_reply_tool_options' );


function decode_reply_tool_init() {
	register_setting( 'decode-reply-tool-settings-group', 'enable-reply-tool' );
	register_setting( 'decode-reply-tool-settings-group', 'display-above-posts' );
	register_setting( 'decode-reply-tool-settings-group', 'display-below-posts' );
	register_setting( 'decode-reply-tool-settings-group', 'twitter-username' );
	register_setting( 'decode-reply-tool-settings-group', 'adn-username' );

	// Sections
	add_settings_section( 'enable-section', __( 'Enable/Disable', 'decode-reply-tool' ), 'decode_reply_tool_enable_section_callback', 'decode_reply_tool' );
	add_settings_section( 'display-section', __( 'Display', 'decode-reply-tool' ), 'decode_reply_tool_display_section_callback', 'decode_reply_tool' );
	add_settings_section( 'usernames-section', __( 'Usernames', 'decode-reply-tool' ), 'decode_reply_tool_usernames_section_callback', 'decode_reply_tool' );

	//Fields
	add_settings_field( 'enable-reply-tool', __( 'Enable Reply Tool', 'decode-reply-tool' ), 'decode_reply_tool_enable_reply_tool_callback', 'decode_reply_tool', 'enable-section' );
	add_settings_field( 'display-above-posts', __( 'Display Above Posts', 'decode-reply-tool' ), 'decode_reply_tool_display_above_posts_callback', 'decode_reply_tool', 'display-section' );
	add_settings_field( 'display-below-posts', __( 'Display Below Posts', 'decode-reply-tool' ), 'decode_reply_tool_display_below_posts_callback', 'decode_reply_tool', 'display-section' );
	add_settings_field( 'twitter-username', __( 'Twitter Username', 'decode-reply-tool' ), 'decode_reply_tool_twitter_username_callback', 'decode_reply_tool', 'usernames-section' );
	add_settings_field( 'adn-username', __( 'App.net Username', 'decode-reply-tool' ), 'decode_reply_tool_adn_username_callback', 'decode_reply_tool', 'usernames-section' );
}
add_action( 'admin_init', 'decode_reply_tool_init' );

function decode_reply_tool_enable_section_callback() {
    echo __( 'Do you want to enable or disable the reply tool on your site?', 'decode-reply-tool' );
}

function decode_reply_tool_display_section_callback() {
    echo __( 'Choose how the reply tool is displayed on your site:', 'decode-reply-tool' );
}

function decode_reply_tool_usernames_section_callback() {
    echo __( 'Enter the usernames you want to be @mentioned to for replies:', 'decode-reply-tool' );
}


function decode_reply_tool_enable_reply_tool_callback() {
    echo '<input name="enable-reply-tool" id="enable-reply-tool" type="checkbox" value="1" class="code" '
    . checked( 1, get_option('enable-reply-tool'), false ) . ' />';
}

function decode_reply_tool_display_above_posts_callback() {
    echo '<input name="display-above-posts" id="display-above-posts" type="checkbox" value="1" class="code" '
    . checked( 1, get_option('display-above-posts', true), false ) . ' />';
}

function decode_reply_tool_display_below_posts_callback() {
    echo '<input name="display-below-posts" id="display-below-posts" type="checkbox" value="1" class="code" '
    . checked( 1, get_option('display-below-posts', false), false ) . ' />';
}

function decode_reply_tool_twitter_username_callback() {
    $setting_value = esc_attr( get_option( 'twitter-username' ) );
	echo "<input class='regular-text' type='text' name='twitter-username' value='$setting_value' />";
}

function decode_reply_tool_adn_username_callback() {
    $setting_value = esc_attr( get_option( 'adn-username' ) );
	echo "<input class='regular-text' type='text' name='adn-username' value='$setting_value' />";
}


function decode_reply_tool_options_page() {
    ?>
    <div class="wrap">
        <h2><?php _e( 'Decode Reply Tool Options', 'decode-reply-tool'); ?></h2>
        <form action="options.php" method="POST">
            <?php settings_fields( 'decode-reply-tool-settings-group' ); ?>
            <?php do_settings_sections( 'decode_reply_tool' ); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function decode_reply_tool_setup() {
    load_plugin_textdomain('decode-reply-tool', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action( 'init', 'decode_reply_tool_setup' );


if ( get_option( 'enable-reply-tool' ) == true ) {
	
	//Add Reply Tool to post content
	function insert_decode_reply_tool( $content ) {

		ob_start();
		include 'reply-tool-insert.php';
		$reply_tool = ob_get_clean();

		if( is_home() && is_main_query() && !has_post_format('quote') && !has_post_format('aside') && !is_attachment() || is_single() && is_main_query() && !has_post_format('quote') && !has_post_format('aside') && !is_attachment() ) {
			if( get_option( 'display-above-posts', true ) == true ) {
				$content = $reply_tool . $content;
			}
			if( get_option( 'display-below-posts', false ) == true ) {
				$content = $content . $reply_tool;
			}
		}
		elseif( has_post_format('quote') && is_home() && is_main_query() || has_post_format('aside') && is_home() && is_main_query() || has_excerpt() ) {
			$content = $content;
		}
		elseif( has_post_format('quote') && is_single() || has_post_format('aside') && is_single() || is_attachment() ) {
			$content = $content . $reply_tool;
		}
		return $content;
	}
	add_filter( 'the_content', 'insert_decode_reply_tool' );

	//Remove Reply Tool text from post excerpts
	function remove_decode_reply_tool( $content ){
	   remove_filter('the_content', 'insert_decode_reply_tool');
	   return $content;
	}
	add_filter('get_the_excerpt', 'remove_decode_reply_tool', 5);

	//Enqueue necessary scripts and styles
	function decode_reply_tool_enqueue_scripts() {
			wp_enqueue_script( 'decode-reply-tool-script', plugins_url('decode-reply-tool.js', __FILE__), array(), '1.1.4', true );
			wp_enqueue_style( 'decode-reply-tool-style', plugins_url('decode-reply-tool.css', __FILE__), array(), '1.0.2' );
	}
	add_action( 'wp_enqueue_scripts', 'decode_reply_tool_enqueue_scripts' );
}
?>