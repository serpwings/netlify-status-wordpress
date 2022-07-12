<?php
/*
 Plugin Name: Netlify Status
 Plugin URI: https://www.seowings.org/netlify-status-plugin/ 
 Description: This plugin displays the status of any website deployed on Netlify.
 Version: 1.0
 Author: Faisal Shahzad
 Author URI: https://www.seowings.org/
*/

function admin_bar_netlify_status_callback() {
	global $wp_admin_bar;
	$wp_admin_bar->add_node(array(
		'id'    => 'netlify-status-topbar',
		'title' => get_option( 'netlify_status_website_id' ) != '' ? '<div id="netlify-badge"><img src="https://api.netlify.com/api/v1/badges/'. get_option( 'netlify_status_website_id' ) .'/deploy-status"></div>': '<div id="netlify-badge">Netlify Badge Not Set</div>',
		'href'  => admin_url( 'options-general.php?page=netlify-status%2Fswtopbar.php' )
		));
}
add_action( 'wp_before_admin_bar_render', 'admin_bar_netlify_status_callback' ); 


add_action( 'admin_menu', 'netlify_status_create_menu' );
function netlify_status_create_menu() {
	add_submenu_page( 'options-general.php', 'Netlify Status', 'Netlify Status', 'manage_options', 'netlify-status/swtopbar.php', 'netlify_status_settings_page' );
	add_action( 'admin_init', 'netlify_status_register_settings' );
}

function netlify_status_register_settings() {
	register_setting( 'netlify-status-settings-group', 'netlify_status_website_id', $netlify_website_id );
}

function netlify_status_settings_page() { ?>
	<div class="wrap">
        <h2>Netlify Badge</h2>
		<div id="main-container">
            <form method="post" action="options.php">
                <?php settings_fields( 'netlify-status-settings-group' ); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">
							Netlify Site ID
						</th>
                        <td>
							<label for="netlify_status_website_id">
								<input type="text" id="netlify_status_website_id" size="40" name="netlify_status_website_id" value="<?php echo get_option( 'netlify_status_website_id' ); ?>" />
                            </label>
                        </td>
                    </tr>
                    </table>
                <p class="submit">
                    <input type="submit" class="button-primary" value='Save Changes'/>
                </p>
            </form>
        </div>
    </div>
<?php }; ?>
