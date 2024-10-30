<div class="wrap">
    <h2> <?php echo __('MYT Channel Settings'); ?> </h2>
    <?php
    if ((isset($_POST['posted']) && $_POST['posted'] == 1) && (is_admin() ) && wp_verify_nonce($_POST['_wpnonce'])) {
        adminYoutubeChannelAPIValid(1, $_POST['apikey']);
        ?>
        <div id="message" class="updated"> <?php echo __('Settings saved successfully'); ?></div> 
        <?php
        $api_key = @$_POST['apikey'];

        $effect = @$_POST['effect'];
        $autoscroll = @$_POST['autoscroll'];
        $autoscroll_delay = @$_POST['autoscroll_delay'];
        $autoscroll_speed = @$_POST['autoscroll_speed'];

        $feed_name = @$_POST['feed_name'];
        $playlist_id = @$_POST['playlist_id'];
        $use_playlist = @$_POST['use_playlist'];
        $use_channel = @$_POST['use_channel'];

        $feature_video = @$_POST['feature_video'];
        $last_updated = @$_POST['lastupdated'];
        $video_layout = @$_POST['video_layout'];
        $video_limit = @$_POST['videos_limit'];
        $video_pages = @$_POST['videos_pages'];
        $video_rows = @$_POST['videos_rows'];
        $video_column = @$_POST['videos_column'];

        $thumb_width = @$_POST['thumb_width'];
        $pagination_position = @$_POST['pagination_position'];
        $youtube_play_icon = @$_FILES['youtube_play_icon']['name'];

        $remove_youtube_play_icon = @$_POST['remove_youtube_play_icon'];

        if (isset($use_playlist) && $use_playlist == 'on') {
            $use_playlist = '1';
        } else {
            $use_playlist = '0';
        }
        if (isset($use_channel) && $use_channel == 'on') {
            $use_channel = '1';
        } else {
            $use_channel = '0';
        }
        if (isset($last_updated) && $last_updated == 'on') {
            $last_updated = '1';
        } else {
            $last_updated = '0';
        }

        if ($youtube_play_icon != "") {
            $uploaded_file = $_FILES['youtube_play_icon'];
            $upload_overrides = array('test_form' => false);
            $move_file = wp_handle_upload($uploaded_file, $upload_overrides);

            $youtube_play_icon = $move_file['url'];
        } else if ($remove_youtube_play_icon == 'on') {
            $youtube_play_icon = '';
        } else {
            $config = get_option('yp_options');
            $youtube_play_icon = $config['youtube_play_icon'];
        }

        $yp_options = array(
            'apivalid' => 1,
            'apikey' => $api_key,
            'effect' => $effect,
            'autoscroll' => $autoscroll,
            'autoscroll_delay' => $autoscroll_delay,
            'autoscroll_speed' => $autoscroll_speed,
            'feed_name' => $feed_name,
            'playlist_id' => $playlist_id,
            'use_playlist' => $use_playlist,
            'use_channel' => $use_channel,
            'feature_video' => $feature_video,
            'lastupdated' => $last_updated,
            'video_layout' => $video_layout,
            'videos_limit' => $video_limit,
            'videos_pages' => $video_pages,
            'videos_rows' => $video_rows,
            'videos_column' => $video_column,
            'thumb_width' => $thumb_width,
            'pagination_position' => $pagination_position,
            'youtube_play_icon' => $youtube_play_icon,
        );

        update_option('yp_options', $yp_options);
    }
    ###########################################################################
    $config = get_option('yp_options');

    $api_key = $config['apikey'];

    $effect = $config['effect'];
    $autoscroll = $config['autoscroll'];
    $autoscroll_delay = $config['autoscroll_delay'];
    $autoscroll_speed = $config['autoscroll_speed'];

    $feed_name = $config['feed_name'];
    $playlist_id = $config['playlist_id'];
    $use_playlist = $config['use_playlist'];
    $use_channel = $config['use_channel'];

    $feature_video = $config['feature_video'];
    $last_updated = $config['lastupdated'];
    $video_layout = $config['video_layout'];
    $video_limit = $config['videos_limit'];
    $video_pages = $config['videos_pages'];
    $video_rows = $config['videos_rows'];
    $video_column = $config['videos_column'];

    $thumb_width = $config['thumb_width'];
    $pagination_position = $config['pagination_position'];
    $youtube_play_icon = $config['youtube_play_icon'];
    ?>   
    <form method="post" action="" enctype="multipart/form-data">
        <?php
        wp_nonce_field();
        ?>  
        <table class="form-table">
            <tr valign="top" >
                <th scope="row"><?php echo __('Effect'); ?> </th>
                <td>
                    <select name="effect">
                        <option value="fade" <?php if ($effect == 'fade') echo ' selected '; ?> /><?php echo __('Fade'); ?>
                        <option value="slide" <?php if ($effect == 'slide') echo ' selected '; ?> /><?php echo __('Slide experimental'); ?>
                    </select>
                </td>
            </tr>
            <tr valign="top" >
                <th scope="row"><?php echo __('Use Autoscroll'); ?> </th>
                <td>
                    <input type="checkbox" name="autoscroll" value="on" <?php if ($autoscroll == 'on') echo ' checked '; ?> />
                </td>
            </tr>
            <tr valign="top" >
                <th scope="row"><?php echo __('Autoscroll Delay'); ?> </th>
                <td>
                    <input type="number" name="autoscroll_delay" value="<?php echo $autoscroll_delay; ?>"  min="1" max="20"/>
                </td>
            </tr>
            <tr valign="top" >
                <th scope="row"><?php echo __('Autoscroll Speed'); ?> </th>
                <td>
                    <input type="number" name="autoscroll_speed" value="<?php echo $autoscroll_speed; ?>"  min="1" max="2000"/>
                </td>
            </tr>
            <tr valign="top" >
                <th scope="row"><?php echo __('Feed Name'); ?> </th>
                <td>
                    <input type="text" name="feed_name" value="<?php echo $feed_name; ?>" />
                </td>
            </tr>
            <tr valign="top" >
                <th scope="row"><?php echo __('Channel/Playlist ID'); ?> </th>
                <td>
                    <input type="text" name="playlist_id" value="<?php echo $playlist_id; ?>" /><br/>
                    <input type="checkbox" <?php if (!empty($use_playlist)) { ?> checked<?php } ?> name="use_playlist"><?php echo __('Playlist'); ?>
                    <input type="checkbox" <?php if (!empty($use_channel)) { ?> checked<?php } ?> name="use_channel"><?php echo __('Channel'); ?>
                </td>
            </tr>
            <tr valign="top" >
                <th scope="row"><?php echo __('Feature Video'); ?> </th>
                <td>
                    <input type="text" name="feature_video" value="<?php echo $feature_video; ?>" />
                    <input type="checkbox" <?php if (!empty($last_updated)) { ?> checked<?php } ?> name="lastupdated"><?php echo __('Show from the list'); ?>
                </td>
            </tr>
            <tr valign="top" >
                <th scope="row"><?php echo __('Video Layout'); ?> </th>
                <td>
                    <input type="radio" <?php if ($video_layout == 'one_column' || $video_layout == "") { ?> checked<?php } ?> name="video_layout" value="one_column"><?php echo __('One Column Layout'); ?>
                    <input type="radio" <?php if ($video_layout == 'two_column') { ?> checked<?php } ?> name="video_layout" value="two_column"><?php echo __('Two Column Layout'); ?>
                </td>
            </tr>
            <tr valign="top" >
                <th scope="row"><?php echo __('Total Limit for Video'); ?> </th>
                <td>
                    <input type="number" name="videos_limit" value="<?php echo $video_limit; ?>" min="1" max="999"/>
                </td>
            </tr>
            <tr valign="top" >
                <th scope="row"><?php echo __('No. of Pagination Pages'); ?> </th>
                <td>
                    <input type="number" name="videos_pages" value="<?php echo $video_pages; ?>" min="1" max="20"/> <?php echo __('Default'); ?>: 5
                </td>
            </tr>
            <tr valign="top" >
                <th scope="row"><?php echo __('No. of Rows for Video'); ?> </th>
                <td>
                    <input type="number" name="videos_rows" value="<?php echo $video_rows; ?>"  min="1" max="50"/>
                </td>
            </tr>
            <tr valign="top" >
                <th scope="row"><?php echo __('No. of Column for Video'); ?> </th>
                <td>
                    <input type="number" name="videos_column" value="<?php echo $video_column; ?>"  min="1" max="5"/>
                </td>
            </tr>
            <?php /* <tr valign="top" >
              <th scope="row"><?php echo __('Minimum Width'); ?> </th>
              <td>
              <input type="text" name="thumb_width" value="<?php echo $thumb_width; ?>" />
              </td>
              </tr> */ ?>
            <tr valign="top" >
                <th scope="row"><?php echo __('Pagination Position'); ?> </th>
                <td>
                    <input type="radio" <?php if ($pagination_position == 'left') { ?> checked<?php } ?> name="pagination_position" value="left"><?php echo __('Left'); ?>
                    <input type="radio" <?php if ($pagination_position == 'center' || $config['pagination_position'] == "") { ?> checked<?php } ?> name="pagination_position" value="center"><?php echo __('Center'); ?>
                    <input type="radio" <?php if ($pagination_position == 'right') { ?> checked<?php } ?> name="pagination_position" value="right"><?php echo __('Right'); ?>
                </td>
            </tr>             
            <tr valign="top" >
                <th scope="row"><?php echo __('API KEY'); ?> </th>
                <td>
                    <input type="text" name="apikey" value="<?php echo $api_key; ?>" />
                    <small><a href="https://developers.google.com/youtube/registering_an_application" target="_blank"><?php echo __('Get key from here'); ?></a></small>
                </td>
            </tr>
            <tr valign="top" >
                <th scope="row"><?php echo __('Upload Play Icon'); ?> </th>
                <td>
                    <input type="file" name="youtube_play_icon" id="youtube_play_icon">
                    <?php
                    if ($youtube_play_icon != "") {
                        ?>
                        <img src="<?php echo $youtube_play_icon; ?>" height="30px" width="30px">
                        <br/><input type="checkbox" name="remove_youtube_play_icon"><?php echo __('Remove Uploaded Play Icon'); ?>
                        <?php
                    }
                    ?>                    
                </td>
            </tr>
        </table>
        <input type="hidden" value="1" name="posted" />
        <input type="Submit" value="<?php echo __('Save'); ?>" class="button-primary" />
    </form>
</div> 
