<?php
/*
	Plugin Name: Replytocom Controller
	Description: Remove ?replytocom= from links and redirect those who use it anyway
	Author: Clayton Leis
	Version: 1.2
	Author URI: http://claytonleis.com/
	License: GPL (http://www.gnu.org/licenses/gpl.txt)
*/
//This plugin comes to solve a problem with some bots that do not know how to handle the replytocom parameter as part of a wordpress url. This solves the redundant traffic and content duplication caused by those bots.
/*  Copyright 2013 Clayton Leis (website : http://claytonleis.com)
 *
 *	This program is free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation; either version 2 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program; if not, write to the Free Software
 *	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//avoid direct calls to this file where wp core files not present
if (!function_exists ('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

/**
 * This class represents the complete plugin
 */
class replytocom_controller {
    /**
     * class constructor
     */
    function replytocom_controller() {
        add_action('init', array($this,'on_init'),0); // really high priority
		if(is_admin()){
			add_action('admin_menu', array($this, 'add_plugin_page'));
			add_action('admin_init', array($this, 'page_init'));
		}
    }

    /**
     * Here we'll catch the annoying bot requests for replytocom and redirect them away
     */
    function on_init() {
        // remove replytocom query paramater
		add_filter( 'comment_reply_link', array( $this, 'replace_reply_to_com' ) );

	    // if it has the annoying replytocom in the request
	    if ( stripos($_SERVER['REQUEST_URI'],'replytocom=') !== false) {
	        $options = get_option('replytocom_options');
		    $destination = $options['destination'];
			if( !$destination ) {
				$urlpart = explode('replytocom=',$_SERVER["REQUEST_URI"],2);
				$destination = rtrim($urlpart[0],"?&");
			}
			wp_redirect($destination,302);
			exit;
	    }
    }

    /**
     * Removes the ?replytocom variable from the link, replacing it with a #comment-<number> anchor.
     *
     * @param string $link The comment link as a string.
     * @return string
     */
	public function replace_reply_to_com( $link ) {
		return preg_replace( '/href=\'(.*(\?|&)replytocom=(\d+)#respond)/', 'href=\'#comment-$3', $link );
	}

	
	//*************** Admin functionality ***************
	 public function add_plugin_page(){
		// This page will be under "Settings"
		add_options_page('Replytocom Controller Options', 'Replytocom Controller', 'manage_options', 'replytocom-controller-admin', array($this, 'create_admin_page'));
    }

    public function create_admin_page(){
        ?>
		<div class="wrap">
			<h2>Replytocom Controller Settings</h2>			
			<form method="post" action="options.php">
				<?php
                // This prints out all hidden setting fields
				settings_fields('replytocom_option_group');	
				do_settings_sections('replytocom-controller-admin');
				?>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
    }
	
    public function page_init(){		
		register_setting('replytocom_option_group', 'replytocom_options', array($this, 'check_URL'));
			
		add_settings_section(
			'first_section',
			'Redirect Destination',
			array($this, 'print_section_info'),
			'replytocom-controller-admin'
		);	
			
		add_settings_field(
			'destination', 
			'Redirect Destination', 
			array($this, 'create_a_url_field'), 
			'replytocom-controller-admin',
			'first_section'			
		);		
    }
	
    public function check_URL($options){
        $options['destination'] = esc_url_raw($options['destination']);
        return $options;
    }
	
    public function print_section_info(){
		print 'The URL that requests with "replytocom=" in the url will be forwarded to. If blank, removes the ?replytocom variable from the link, replacing it with a #comment-<number> anchor.';
    }
	
    public function create_a_url_field(){
        $options = get_option('replytocom_options');
        ?><input type="text" id="input_whatever_unique_id_I_want" name="replytocom_options[destination]" value="<?=$options['destination'];?>" /><?php
    }
}

$my_replytocom_controller = new replytocom_controller();
?>