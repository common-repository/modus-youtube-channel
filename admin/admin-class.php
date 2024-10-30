<?php
#############################################################################################################################	
#
################################################  ADMIN MENU HOOK  ###########################################################
add_action('admin_menu', 'adminYoutubeChannelMenu');

function adminYoutubeChannelMenu() {
    $config = get_option('yp_options');

    add_options_page('MYT Admin listing', 'MYT Admin', 'edit_published_posts', 'settingYoutubeChannel', 'settingYoutubeChannel');
}

################################################  Include Admin File ########################################################

function settingYoutubeChannel() {
    include_once(YT_ADMIN_FILES_DIR . 'setting.php');
}

?>
