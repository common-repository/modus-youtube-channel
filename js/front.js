jQuery(document).ready(function (jQuery) {
    var sliderSpeed = jQuery('#autoscroll_speed').val();
    sliderSpeed = parseInt(sliderSpeed);

    jQuery(".single-video-img").hover(
            function () {
                jQuery('.overlap', this).fadeTo(sliderSpeed, 1);
            },
            function () {
                jQuery('.overlap', this).fadeTo(500, 0);
            }
    );

    jQuery('.video-nav-button').click(function () {
        var toshow_id = jQuery(this).attr('data-id');
        jQuery('.small-video-block').each(function () {
            jQuery(this).hide();
        })

        jQuery('.video-nav-button').each(function () {
            jQuery(this).removeClass('video-nav-selected-button');
        })

        if (jQuery('#effect').val() == 'fade') {
            jQuery('#' + toshow_id).fadeIn('slow');

            var get_id = toshow_id.split('_');
            var current_pageno_str = get_id[1];

            var count_li = jQuery(".video-nav-button").length - 2;
            var maxpage = count_li;
            var current_pageno = parseInt(current_pageno_str);
            var pages = jQuery("#videos_pages").val();
            var displayed_pages = parseInt(pages);
            var startloop = "";
            var toloop = "";

            var startloop = parseInt(current_pageno - (displayed_pages / 2));
            if (startloop < 1) {
                startloop = 1;
            }

            if ((startloop + displayed_pages) > maxpage) {
                toloop = maxpage;
                if (maxpage < displayed_pages) {
                    startloop = 1;
                } else {
                    startloop = maxpage - displayed_pages + 1;
                }
            } else {
                toloop = startloop + displayed_pages - 1;
            }

            jQuery(".video-nav-button").hide();
            //jQuery('#video-nav-prev-button').show();
            for (var i = startloop; i <= toloop; i++) {
                jQuery('#page_num_' + i).show();
            }
            //jQuery('#video-nav-next-button').show();


            var value_prev = current_pageno - 1;
            if (value_prev == 0 || value_prev == -1) {
                jQuery('#video-nav-prev-button').hide();
            } else {
                var int_to_str_prev = value_prev.toString();
                var get_prev_id = 'num_' + int_to_str_prev;
                jQuery('#video-nav-prev-button').show();
                jQuery('#video-nav-prev-button').attr("data-id", get_prev_id);
            }

            var value_next = current_pageno + 1;
            for (var a = current_pageno_str; a <= count_li; a++) {
                if (current_pageno_str == count_li) {
                    jQuery('#video-nav-next-button').hide();
                } else {
                    jQuery('#video-nav-next-button').show();
                }
            }

            var int_to_str_next = value_next.toString();
            var get_next_id = 'num_' + int_to_str_next;
            jQuery('#video-nav-next-button').attr("data-id", get_next_id);

            jQuery('#page_num_' + current_pageno_str).show();
            jQuery('#page_num_' + current_pageno_str).addClass('video-nav-selected-button');

        } else {
            var item_el = jQuery(this).html();
            item_el = parseInt(item_el);
            var offset = (item_el - 1) * 660;
            var str2use = "-" + offset + "px";
            jQuery('.small-video-sub-container').animate({
                marginLeft: str2use
            }, sliderSpeed);
        }
    })

    jQuery('.overlap, .single-video-img').click(function () {
        jQuery('.main-video-container iframe').attr('src', 'https://www.youtube.com/embed/' + jQuery(this).attr('data-video') + '?autoplay=1')
    })

    // autoscrolling
    if ((jQuery('#autoscroll').val() == 'on') && (jQuery('#big_block_n').val() != '1')) {
        console.log('on');
        var counter = 0;
        setInterval(function () {
            console.log('on');
            if (counter >= parseInt(jQuery('#autoscroll_delay').val())) {

                // main step action.
                var cur_nav = jQuery('.video-nav-selected-button');
                if (cur_nav.next().hasClass('video-nav-button')) {
                    cur_nav.next().addClass('video-nav-selected-button');
                    cur_nav.removeClass('video-nav-selected-button');
                    jQuery('.video-nav-selected-button').click();
                    counter = 0;
                } else {
                    jQuery('.video-nav-selected-button').removeClass('video-nav-selected-button');
                    jQuery('.video-nav-button:first-child').addClass('video-nav-selected-button');
                    jQuery('.video-nav-selected-button').click();
                    counter = 0;
                }

            } else {
                counter++;
            }
        }, 1000)
    }

}); // main jquery container
