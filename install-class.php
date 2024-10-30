<?php

################################################  HEAD TAG HOOK (CSS, JS) ####################################################

add_action('init', 'youtubeChannelInitMethods');

function youtubeChannelInitMethods() {
    wp_enqueue_style('style-front', YT_CSS_WWW . 'front-end.css');

    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-front', YT_JS_WWW . 'front.js');
}

add_action('admin_init', 'youtubeChannelAdminInitMethods');

function youtubeChannelAdminInitMethods() {
    wp_enqueue_style('style-admin', YT_CSS_WWW . 'admin.css');
    wp_enqueue_script('jquery-admin', YT_JS_WWW . 'admin.js');
}

##############################################################################################################################
add_action('admin_notices', 'youtubeChannelAdminNotice');

function youtubeChannelAdminNotice() {
    $config = get_option('yp_options');

    $apivalid = $config['apivalid'];
    $apikey = $config['apikey'];

    adminYoutubeChannelAPIValid($apivalid, $apikey);
}

function adminYoutubeChannelAPIValid($apivalid, $apikey) {
    if ($apivalid == 1) {
        $l = strlen($apikey);
        if ($l <= 10)
            echo <<<EOF
<div class="error"><p>
<strong>Configuration of MYT not complete!</strong> With the new Google API you must add an API key 
  		<a href="https://developers.google.com/youtube/registering_an_application" target="_blank"> you can get one here</a>
</p></div>
EOF;
    }
}

##############################################################################################################################
################################################  Install Function ###########################################################
// INSTALL / UPGRADE
register_activation_hook(__FILE__, 'installYoutubeChannelHook');

function installYoutubeChannelHook() {
    if (get_option('yp_options')) {
        $config = get_option('yp_options');
        $yp_options = array(
            'feed_name' => $config['feed_name'],
            'feature_video' => $config['feature_video'],
            'autoscroll_delay' => $config['autoscroll_delay'],
            'autoscroll' => $config['autoscroll'],
            'effect' => $config['effect'],
            'autoscroll_speed' => $config['autoscroll_speed'],
            'videos_limit' => $config['videos_limit'],
            'videos_rows' => $config['videos_rows'],
            'videos_column' => $config['videos_column'],
            'thumb_width' => $config['thumb_width'],
            'lastupdated' => $config['lastupdated'],
            'playlist_id' => $config['playlist_id'],
            'use_playlist' => $config['use_playlist'],
            'use_channel' => $config['use_channel'],
            'apikey' => $config['apikey'],
            'apivalid' => $config['apivalid']
        );
    } else {
        $yp_options = array(
            'feed_name' => 'rte',
            'feature_video' => 'aHSfnnY-BSc',
            'autoscroll_delay' => 10,
            'autoscroll' => 'on',
            'effect' => 'fade',
            'autoscroll_speed' => 500,
            'videos_limit' => 40,
            'videos_rows' => 3,
            'videos_column' => 2,
            'thumb_width' => 220,
            'lastupdated' => 0,
            'playlist_id' => 0,
            'use_playlist' => 0,
            'use_channel' => 1,
            'apikey' => '',
            'apivalid' => -1
        );
    }
    update_option('yp_options', $yp_options);
    delete_option('yp_options');
    if (!get_option('yp_options')) {
        update_option('yp_options', $yp_options);
    }
}

##############################################################################################################################
?>
