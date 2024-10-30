<?php

add_shortcode('youtube-player', 'youtubeChannelListShortcode');

function youtubeChannelListShortcode($atts) {
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

    if ($use_channel == 1 && $api_key != "") {
        $channel_id = $config['playlist_id'];
        if ($channel_id != "") {
            $url = "https://www.googleapis.com/youtube/v3/channels?part=contentDetails&id=" . $channel_id . "&key=" . $api_key;
        } else {
            $url = "https://www.googleapis.com/youtube/v3/channels?part=contentDetails&forUsername=" . $feed_name . "&key=" . $api_key;
        }
        $response = wp_remote_get($url);

        $html = $response['body'];
        $o = json_decode($html);
        $playlist_id = @$o->items[0]->contentDetails->relatedPlaylists->uploads;
    }
    if ($use_playlist == 1) {
        $playlist_id = $config['playlist_id'];
    }

    if ($playlist_id == "" && $feed_name != "" && $api_key != "") {
        $url = "https://www.googleapis.com/youtube/v3/channels?part=contentDetails&forUsername=" . $feed_name . "&key=" . $api_key;
        $response = wp_remote_get($url);

        $html = $response['body'];
        $o = json_decode($html);
        $playlist_id = @$o->items[0]->contentDetails->relatedPlaylists->uploads;
    }
    ##########################################################################################
    if (isset($atts) && !empty($atts)) {
        if (isset($atts['api-key'])) {
            $api_key = @$atts['api-key'];
        }
        if (isset($atts['feed-name'])) {
            $feed_name = @$atts['feed-name'];
        }
        if (isset($atts['featured'])) {
            $feature_video = @$atts['featured'];
        }

        if (isset($atts['channel-id']) && $api_key != "") {
            $channel_id = @$atts['channel-id'];
            $url = "https://www.googleapis.com/youtube/v3/channels?part=contentDetails&id=" . $channel_id . "&key=" . $api_key;
            $response = wp_remote_get($url);

            $html = $response['body'];
            $o = json_decode($html);
            $playlist_id = @$o->items[0]->contentDetails->relatedPlaylists->uploads;
        }
        if (isset($atts['playlist-id'])) {
            $playlist_id = @$atts['playlist-id'];
        }
    }
    ##########################################################################################

    if ($video_pages == "" || $video_pages < 1) {
        $video_pages = 5;
    }

    $youtube_video_container_class = "";
    if ($video_layout == "two_column") {
        $youtube_video_container_class .= " two-column-layout";
    }

    if ($video_column < 2) {
        $youtube_video_container_class .= " title-align";
    } else if ($video_column < 3 && $video_layout == "one_column") {
        $youtube_video_container_class .= " title-align";
    }

    if ($video_column == 2) {
        $youtube_video_container_class .= " single-col-2";
    } else if ($video_column == 3) {
        $youtube_video_container_class .= " single-col-3";
    } else if ($video_column == 4) {
        $youtube_video_container_class .= " single-col-4";
    } else if ($video_column == 5) {
        $youtube_video_container_class .= " single-col-5";
    }

    if ($youtube_play_icon != "") {
        $youtube_play_icon_url = $youtube_play_icon;
    } else {
        $youtube_play_icon_url = YT_IMAGES_WWW . "play.png";
    }

    $str = "";

    global $is_IE;
    if ($is_IE) {
        $str .='<style>
            .overlap{
                background: #000 url("' . $youtube_play_icon_url . '");
                opacity: 0.75; -ms-filter: "alpha (opacity=75)"; filter: alpha (opacity=75); 
            }
        </style>';
    } else {
        $str .='<style>
            .overlap{
                background: url("' . $youtube_play_icon_url . '"); 
            }
        </style>';
    }

    $video_api_limit = 50;
    if ($video_limit <= 0) {
        $video_limit = $video_api_limit;
    }
    if ($video_limit < $video_api_limit) {
        $video_api_limit = $video_limit;
    }

    $total_video_blocks = $video_limit / $video_api_limit;
    $total_video_blocks = ceil($total_video_blocks);

    $next_page_token = "";

    $all_video_arr = array();
    $display_video_count = 0;
    if ($playlist_id != "" && $api_key != "") {
        for ($i = 1; $i <= $total_video_blocks; $i++) {
            $loop_count = $video_api_limit * $i;
            if ($loop_count > $video_limit) {
                //$video_api_limit = $loop_count - $video_limit;
                $video_api_limit = $video_limit - $display_video_count;
            }
            $display_video_count = $display_video_count + $video_api_limit;

            $url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=" . $video_api_limit . "&playlistId=" . $playlist_id . "&key=" . $api_key;
            if ($next_page_token != "") {
                $url.="&pageToken=" . $next_page_token;
            }
            $response = wp_remote_get($url);

            $html = $response['body'];
            $o = json_decode($html);
            $next_page_token = @$o->nextPageToken;
            $total_results = @$o->pageInfo->totalResults;
            $results_per_page = @$o->pageInfo->resultsPerPage;
            $items = @$o->items;

            $video_arr = array();
            foreach ($items as $item) {
                $title = $item->snippet->title;
                $v = $item->snippet->resourceId->videoId;

                $video_arr['video'] = $v;
                $video_arr['title'] = $title;
                $video_arr['date'] = $item->snippet->publishedAt;
                $all_video_arr[] = $video_arr;
            }
        }
    }

    if ($playlist_id != "" && !empty($all_video_arr)) {
        $total_records = $video_rows * $video_column;
        /* if (count($all_video_arr) % 6 == 0) {
          $n_blocks = count($all_video_arr) / $total_records;
          $n_blocks = (int) $n_blocks;
          } else {
          $n_blocks = count($all_video_arr) / $total_records;
          $n_blocks = (int) $n_blocks + 1;
          } */
        $n_blocks = count($all_video_arr) / $total_records;

        $pagination_str = '';
        if ($n_blocks > 1) {
            $pagination_str.='<ul class="video-nav-links"> ';
            $pagination_str.='<li class="video-nav-button" id="video-nav-prev-button"> << </li>';
            for ($k = 0; $k < $n_blocks; $k++) {
                $selected_nav = '';
                if ($k == 0) {
                    $selected_nav = ' video-nav-selected-button ';
                }
                $pagination_str.='<li class="video-nav-button ' . $selected_nav . '" data-id="num_' . ($k + 1) . '" id="page_num_' . ($k + 1) . '" >' . ($k + 1) . '</li>'; //style="display:none;"
            }
            $pagination_str.='<li class="video-nav-button" id="video-nav-next-button"> >> </li>';
            $pagination_str.='</ul>';
        }

        $str .='<script>
            jQuery(document).ready(function () {
                jQuery(\'.video-nav-button[data-id="num_1"]\').click();
            });
        </script>';

        $str .='<div class="youtube-video-container ' . $youtube_video_container_class . '">';
        ########################################################################
        $str .='<div class="main-video-container">';
        if (isset($atts['featured'])) {
            $feature = @$atts['featured'];
        } else if (!empty($last_updated)) {
            $temp = 0; //count( $all_video_arr ) - 1;
            $feature = $all_video_arr[$temp]['video'];
        } else if ($feature_video != "") {
            $feature = $feature_video;
        }
        $str .='<div class="embed-container">';
        $str .='<iframe src="https://www.youtube-nocookie.com/embed/' . $feature . '" frameborder="0" allow="encrypted-media" allowfullscreen></iframe>';
        $str .='</div>';
        if ($pagination_position == "left") {
            $str .= $pagination_str;
        }
        $str .='</div>';
        ########################################################################
        $str .='<div class="small-video-container">';
        $str .='<div class="small-video-sub-container">';
        for ($k = 0; $k < $n_blocks; $k++) {
            $offset1 = $k * $total_records;
            $offset2 = ($k + 1) * $total_records;

            $selected_ul = "";
            if ($k == 1) {
                $selected_ul = "active";
            }
            $str .='<ul id="num_' . ($k + 1) . '" class="small-video-block ' . $selected_ul . '">';
            $cnt = 0;
            foreach ($all_video_arr as $single_video) {
                if ($cnt >= $offset1 && $cnt < $offset2) {
                    $single_video_li_style = "";
                    if ($cnt % $video_column == 0) {
                        $single_video_li_style = "clear:both;";
                    }
                    $single_video_img_style = "";
                    if (!empty($thumb_width)) {
                        $single_video_img_style = "width: 100%;";
                    }

                    $str .='<li class="single-video" style="' . $single_video_li_style . '">';
                    $str .='<div class="single-video-img" style="' . $single_video_img_style . '"  data-video="' . $single_video['video'] . '">';
                    $str .='<img src="https://img.youtube.com/vi/' . $single_video['video'] . '/hqdefault.jpg" />';
                    $str .='<div class="overlap" style="' . $single_video_img_style . '" data-video="' . $single_video['video'] . '"></div>';
                    $str .='</div>';
                    $str .='<div class="text-wrap">';
                    $str .='<p class="cuffon single-video-title">' . $single_video['title'] . '</p>';
                    $str .='</div>';
                    $str .='</li>';
                }
                $cnt++;
            }
            $str .='<div class="clearfix"></div>';
            $str .='</ul>';
        }
        $str .='</div>';
        if ($pagination_position == "right") {
            $str .= $pagination_str;
        }
        $str .='</div>';
        ########################################################################
        if ($n_blocks <= 10 && ($pagination_position == "center" || $pagination_position == "")) {
            $str .='<div class="video-center-nav">';
            $str .= $pagination_str;
            $str .='</div>';
        } else {
            $str .= $pagination_str;
        }
        $str .='<div class="clearfix"></div>';
        $str .='</div>';

        $str .='
            <input type="hidden" value="' . $effect . '" id="effect" />
            <input type="hidden" value="' . $autoscroll . '" id="autoscroll" />
            <input type="hidden" value="' . $autoscroll_delay . '" id="autoscroll_delay" />
            <input type="hidden" value="' . $autoscroll_speed . '" id="autoscroll_speed" />
            <input type="hidden" value="' . $n_blocks . '" id="big_block_n" />
            <input type="hidden" value="' . $video_pages . '" id="videos_pages" />
            ';
    }

    return $str;
}

?>
