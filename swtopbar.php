<?php
/*
Plugin Name: Netlify Status on WordPress
Plugin URI: https://www.seowings.org/software/netlify-status-on-wordpress/ 
Description: This WordPress plugin displays the status of any website deployed on Netlify. You only need to provide the "Site ID" of a netlify website.
Version: 1.1
Author: Faisal Shahzad
Author URI: https://www.serpwings.com/
*/

function netlify_status_admin_bar_callback()
{
    global $wp_admin_bar;
    $wp_admin_bar->add_node(
        array(
            'id' => 'netlify-status-topbar',
            'title' => get_option('netlify_status_website_id') != '' ? '<div id="netlify-badge" class="netlify-status-badge"><img src="https://api.netlify.com/api/v1/badges/' . get_option('netlify_status_website_id') . '/deploy-status"></div>' : '<div id="netlify-badge">Netlify Badge Not Set</div>',
            'href' => admin_url('options-general.php?page=netlify-status%2Fswtopbar.php'),
            'parent' => 'top-secondary'
        )
    );
}

function netlify_status_enqueue_scripts()
{
    wp_enqueue_script('netlify-status-topbar-script', plugins_url('updater.js', __FILE__), array('jquery'));
}

function netlify_status_create_menu()
{
    add_submenu_page('options-general.php', 'Netlify Status', 'Netlify Status', 'manage_options', 'netlify-status/swtopbar.php', 'netlify_status_settings_page');
    add_action('admin_init', 'netlify_status_register_settings');
}

function netlify_status_register_settings()
{
    register_setting('netlify-status-settings-group', 'netlify_status_website_id', '');
}

function netlify_status_settings_page()
{ ?>
    <div class="wrap">
        <h2>Netlify Badge</h2>
        <div id="main-container">
            <form method="post" action="options.php">
                <?php settings_fields('netlify-status-settings-group'); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">
                            Netlify Site ID
                        </th>
                        <td>
                            <label for="netlify_status_website_id">
                                <input type="text" id="netlify_status_website_id" size="60" name="netlify_status_website_id"
                                    value="<?php echo get_option('netlify_status_website_id'); ?>" />
                            </label>
                        </td>
                    </tr>
                </table>
                <p class="submit">
                    <input type="submit" class="button-primary" value='Save Changes' />
                </p>
            </form>
        </div>
    </div>
<?php }

add_action('wp_before_admin_bar_render', 'netlify_status_admin_bar_callback');
add_action('wp_enqueue_scripts', 'netlify_status_enqueue_scripts');
add_action('admin_enqueue_scripts', 'netlify_status_enqueue_scripts');
add_action('admin_menu', 'netlify_status_create_menu');
?>
