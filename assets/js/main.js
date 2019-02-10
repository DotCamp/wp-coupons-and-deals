// all coupons archive nav active
jQuery(document).ready(function ($) {

    function more_less_description() {
        var num_words = Number(wpcd_main_js.word_count);
        var full_description = $('.wpcd-full-description');
        var more = $('.wpcd-more-description');
        var less = $('.wpcd-less-description');
        full_description.each(function () {
            $this = $(this);

            var full_content = $this.html();
            var check = full_content.split(' ').length > num_words;
            if (check) {
                var short_content = full_content.split(' ').slice(0, num_words).join(' ');
                $this.siblings('.wpcd-short-description').html(short_content + '...');
                $this.hide();
                $this.siblings('.wpcd-less-description').hide();
            } else {
                $(this).siblings('.wpcd-more-description').hide();
                $(this).siblings('.wpcd-more-description');
                $(this).siblings('.wpcd-less-description').hide();
                $(this).siblings('.wpcd-short-description').hide();
            }
        });
        // more and less link
        more.click(function (e) {
            e.preventDefault();
            $(this).siblings('.wpcd-full-description').show();
            $(this).siblings('.wpcd-less-description').show();
            $(this).siblings('.wpcd-short-description').hide();
            $(this).hide();

        });
        less.click(function (e) {
            e.preventDefault();
            $(this).siblings('.wpcd-short-description').show();
            $(this).siblings('.wpcd-more-description').show();
            $(this).siblings('.wpcd-full-description').hide();
            $(this).hide();
        });
    };
    more_less_description();

    
    $.each($('#wpcd_cat_ul > li'), function () {
        if ($(this).children('a').attr('href') === window.location.href) {
            $(this).children('a').addClass('active');
        }
    });
    // $('#wpcd_cat_ul .wpcd_category').on('click', function (e) {
    //     e.preventDefault();
    //     if ($(this).attr('data-category') !== 'all') {
    //         $('.wpcd_item').hide();
    //         $('.' + $(this).attr('data-category')).fadeIn();
    //     } else {
    //         $('.wpcd_item').fadeIn();
    //     }
    // });
    function ajax_coupon_categories_pagination(wpcd_category, page_num) {
        var coupon_template;
        var coupon_items_count;
        var wpcd_data_coupon_page_url;
        var wpcd_coupon_template = $('#wpcd_coupon_template');
        if(wpcd_coupon_template.length > 0) {
            coupon_template = wpcd_coupon_template.attr('wpcd-data-coupon_template');
            coupon_items_count = wpcd_coupon_template.attr('wpcd-data-coupon_items_count');
            var wpcd_data_coupon_page_url = wpcd_coupon_template.attr('wpcd-data-coupon_page_url');
        }
        if(!page_num) {
            page_num = undefined;
        }
        var ajaxurl = '/wp-admin/admin-ajax.php';
        $.ajax({
            type : 'post',
            dataType : 'json',
            url : ajaxurl,
            data : {
                action: 'wpcd_coupons_category_action',
                wpcd_category: wpcd_category,
                coupon_template: coupon_template,
                coupon_items_count: coupon_items_count,
                wpcd_data_coupon_page_url: wpcd_data_coupon_page_url,
                page_num: page_num
            },
            success: function( response ) {
                if( response ) {
                    var coupon_container = $('#wpcd_wpcd_coupon_container');
                    if(coupon_container.length > 0) {
                        coupon_container.html(response);
                        $('#wpcd_coupon_pagination_wr a.page-numbers').off('click');
                        $('#wpcd_coupon_pagination_wr a.page-numbers').on('click', function(e) {
                            e.preventDefault();
                            var href = $(this).attr('href');
                            var href_arr = getUrlVar(href);
                            var page_num = href_arr['page_num'];
                            ajax_coupon_categories_pagination(wpcd_category, page_num);
                        });
                        $('.masterTooltip').hover(function () {
                            var title = $(this).attr('title');
                            $(this).data('tipText', title).removeAttr('title');
                            $('<p class="wpcd-copy-tooltip"></p>')
                                .text(title)
                                .appendTo('body')
                                .fadeIn('slow');
                        }, function () {
                            $(this).attr('title', $(this).data('tipText'));
                            $('.wpcd-copy-tooltip').remove();
                        }).mousemove(function (e) {
                            var mousex = e.pageX + 20;
                            var mousey = e.pageY + 10;
                            $('.wpcd-copy-tooltip')
                                .css({ top: mousey, left: mousex })
                        });
                        $.each($('#wpcd_cat_ul > li'), function () {
                            if ($(this).children('a').attr('data-category') == wpcd_category) {
                                $(this).children('a').addClass('active');
                            } else {
                                $(this).children('a').removeClass('active');
                            }
                        });
                        more_less_description();
                        var scrollTop = $('#wpcd_coupon_template').offset().top;
                        $('html, body').animate({scrollTop: scrollTop}, 600);
                    }
                } 
            }
        });

    };

    $('#wpcd_cat_ul .wpcd_category').on('click', function (e) {
        e.preventDefault();
        var wpcd_category = $(this).attr('data-category');
        ajax_coupon_categories_pagination(wpcd_category);
    });

    $('#wpcd_coupon_pagination_wr a.page-numbers').on('click', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var href_arr = getUrlVar(href);
        var page_num = href_arr['page_num'];
        var data_category = href_arr['wpcd_category'];
        console.log(data_category);
        ajax_coupon_categories_pagination(data_category,page_num);
    });

    function getUrlVar(urlVar){
        var urlVar = urlVar;
        var arrayVar = []; 
        var valueAndKey = []; 
        var resultArray = []; 
        arrayVar = (urlVar.substr(1)).split('&'); 
        if(arrayVar[0]=="") return false; 
        for (i = 0; i < arrayVar.length; i ++) { 
            valueAndKey = arrayVar[i].split('='); 
            resultArray[valueAndKey[0]] = valueAndKey[1]; 
        }
        return resultArray; 
    }
    /*
    $('.wpcd_search2 .wpcd_searchbar_search input').hide();
    $('.wpcd_search2 #wpcd_searchbar_search_close').hide();
    $('#wpcd_searchbar_search_icon').on('click', function (e) {
        $('.wpcd_search2 .wpcd_searchbar_search input').fadeIn();
        $('.wpcd_search2 #wpcd_searchbar_search_close').fadeIn();
    });
    $('.wpcd_search2 #wpcd_searchbar_search_close').on('click', function (e) {
        $('.wpcd_search2 .wpcd_searchbar_search input').fadeOut();
        $('.wpcd_search2 #wpcd_searchbar_search_close').fadeOut();
        $('.wpcd_item').fadeIn();
        $('.wpcd_searchbar_search input').val('');
    });*/
    function wpcd_categories_dropdown() {
        var sw = jQuery(".wpcd_div_nav_block").width();
        if (sw < 850) {
            jQuery(".wpcd_categories_in_dropdown").css('display', 'block');
            jQuery(".wpcd_categories_full").css('display', 'none');
        } else {
            jQuery(".wpcd_categories_full").css('display', 'block');
            jQuery(".wpcd_categories_in_dropdown").css('display', 'none');
        }
    }
    wpcd_categories_dropdown();

    $('#wpcd_searchbar_search_icon').on('click', function (e) {
        $('.wpcd_searchbar_search input').fadeIn();
        $('#wpcd_searchbar_search_close').fadeIn();
    });
    $('#wpcd_searchbar_search_close').on('click', function (e) {
        $('.wpcd_searchbar_search input').fadeOut();
        $('#wpcd_searchbar_search_close').fadeOut();
        $('.wpcd_item').fadeIn();
        $('.wpcd_searchbar_search input').val('');
    });
    let delayTimer;
    $('.wpcd_searchbar_search input').on('input', function (e) {
        clearTimeout(delayTimer);
        delayTimer = setTimeout(() => {
            let search_string = $(this).val();

            $('.wpcd_item').each(function () {
                let name = $(this).attr('wpcd-data-search').toLowerCase();
                let n = name.indexOf(search_string.toLowerCase());
                if (n != -1) {
                    $(this).fadeIn();
                } else {
                    $(this).hide();
                }
            })
        }, 800);
    })
});

//for count down
jQuery(document).ready(function ($) {
    var count_down_span = $('[data-countdown_coupon]');
    count_down_span.each(function () {
        var $this = $(this), finalDate = $(this).data('countdown_coupon');
        $this.countdown(finalDate, function (event) {
            var format = '%M ' + wpcd_main_js.minutes + ' %S ' + wpcd_main_js.seconds;
            if (event.offset.hours > 0) {
                format = '%H ' + wpcd_main_js.hours + ' %M ' + wpcd_main_js.minutes + ' %S ' + wpcd_main_js.seconds;
            }
            if (event.offset.totalDays > 0) {
                format = '%-d ' + wpcd_main_js.day + '%!d ' + format;
            }
            if (event.offset.weeks > 0) {
                format = '%-w ' + wpcd_main_js.week + '%!w ' + format;
            }
            if (event.offset.weeks == 0 && event.offset.totalDays == 0 && event.offset.hours == 0 && event.offset.minutes == 0 && event.offset.seconds == 0) {
                jQuery(this).parent().addClass('wpcd-countdown-expired').html(wpcd_main_js.expired_text);
            } else {
                jQuery(this).html(event.strftime(format));
            }
        }).on('finish.countdown', function (event) {
            jQuery('.wpcd-coupon-two-countdown-text').hide();
            jQuery(this).html(wpcd_main_js.expired_text).parent().addClass('disabled');
        });
    });
});

jQuery(document).ready(function ($) {

    // For social share
    $('.fb-share,.tw-share,.go-share').click(function (e) {
        e.preventDefault();
        window.open($(this).attr('href'), 'fbShareWindow', 'height=450, width=550, top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
        return false;
    });

    /*
     * Vote System
     */
    $('a[class^=wpcd-vote]').click(function (e) {
        e.preventDefault();
        var $this = $(this),
            coupon_id = $this.data('id'),
            meta = "up",
            el_sibling_percentage = $this.siblings(".wpcd-vote-percent"),
            el_percentage = $('.wpcd-vote-percent[data-id=' + coupon_id + ']');

        if ($this.hasClass("wpcd-vote-down")) {
            meta = "down";
        }
        var data = {
            'action': 'wpcd_vote',
            'meta': meta,
            'coupon_id': coupon_id,
        };

        jQuery.post(wpcd_object.ajaxurl, data, function (response) {
            if (response === "Failed") {
                displayMsg(wpcd_main_js.vote_failed, el_percentage, 2000);
            } else if (response === "voted") {
                displayMsg(wpcd_main_js.vote_already, el_sibling_percentage, 2000);
            } else {
                displayMsg(wpcd_main_js.vote_success, el_percentage, 2000);
                setTimeout(function () {
                    displayMsg(response, el_percentage, 0);
                }, 2000);

            }
        });

        /*
         * This function dispaly msg in a specific element for a little time
         * 
         * @param string 'Msg' is the message that will be displayed in the element
         * @param object 'el' is the element
         * @param int 'Time' is the time in milliSecond or 0 if this will be the text for ever
         */
        function displayMsg(Msg, el, Time = 0) {

            if (typeof (el) === "object") {
                if (Time === 0) {
                    el.html(Msg);
                } else {
                    var old_text = el.html();
                    el.html(Msg);
                    setTimeout(function () {
                        el.html(old_text);
                    }, Time);
                }
            }
        }
    });
});

jQuery(document).ready(function ($) {
    
    
    /*var newUrl = "?page=" + $(this).val() + "&" + $.param(params);
     var newUrl = location.href.replace("page="+currentPageNum, "page="+newPageNum);*/
});

jQuery(document).ready(function ($) {
    $(document).ready(function () {
        $('.masterTooltip').hover(function () {
            var title = $(this).attr('title');
            $(this).data('tipText', title).removeAttr('title');
            $('<p class="wpcd-copy-tooltip"></p>')
                .text(title)
                .appendTo('body')
                .fadeIn('slow');
        }, function () {
            $(this).attr('title', $(this).data('tipText'));
            $('.wpcd-copy-tooltip').remove();
        }).mousemove(function (e) {
            var mousex = e.pageX + 20;
            var mousey = e.pageY + 10;
            $('.wpcd-copy-tooltip')
                .css({ top: mousey, left: mousex })
        });
    });

    /* <fs_premium_only> */

    jQuery(".wpcd_coupon_popup_layer, .wpcd_coupon_popup_close").click(function () {
        jQuery(".wpcd_coupon_popup_wr").fadeOut();
    });

    /**
     * function wpcd_archive_section_small
     * add class (wpcd_archive_section_small) in small width
     * remove this class in large width
     * @returns {void}
     */
    function wpcd_archive_section_small() {
        var sw = jQuery(".wpcd_archive_section").width();
        if (sw < 1000) {
            jQuery(".wpcd_archive_section").addClass("wpcd_archive_section_small");
        } else {
            jQuery(".wpcd_archive_section").removeClass("wpcd_archive_section_small");
        }
    }

    wpcd_archive_section_small();
    //when window resize call wpcd_archive_section_small.
    $(window).resize(function () {
        wpcd_archive_section_small();
    });

    /* </fs_premium_only> */

    /* <fs_premium_only> */
    /**
     * show the coupon with popup
     */

    //to get the url parm
    $.urlParam = function (name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results == null) {
            return null;
        } else {
            return decodeURI(results[1]) || 0;
        }
    }
    var wpcd_id = $.urlParam('wpcd_coupon');

    var code_section = $('.wpcd-coupon-id-' + wpcd_id + '.coupon-code-wpcd.coupon-detail.wpcd-coupon-button-type a');
    code_section.children('.get-code-wpcd').hide();
    code_section.each(function () {
        var cnt = $(this).contents();
        var div = $(this).replaceWith($('<div class="active coupon-code-wpcd"></div>').append(cnt));
    });

    /* </fs_premium_only> */

});

jQuery(document).ready(function ($) {

    $(window).resize(updateCouponSixClass);

    function updateCouponSixClass() {
        $.each($('.wpcd-coupon-six'), function () {
            if ($(this).width() > 600)
                $(this).removeClass('wpcd-coupon-six-mobile');
            else
                $(this).addClass('wpcd-coupon-six-mobile');
        });
    }

    updateCouponSixClass();
});

jQuery(document).ready(function ($) {

    $(window).resize(updateCouponFiveClass);

    function updateCouponFiveClass() {
        $.each($('.wpcd-template-five'), function () {
            if ($(this).width() > 600)
                $(this).removeClass('wpcd-template-five-mobile');
            else
                $(this).addClass('wpcd-template-five-mobile');
        });
    }

    updateCouponFiveClass();
});

function wpcdCopyToClipboard(element) {
    var $temp = jQuery("<input>");
    jQuery("body").append($temp);
    $temp.val(jQuery(jQuery(element)[0]).text()).select();
    document.execCommand("copy");
    $temp.remove();
}

function wpcdOpenCouponAffLink(CoupenId) {
    var a = jQuery("#coupon-button-" + CoupenId);
    var oldLink = a.attr('href');


    if (window.location.href.indexOf('wpcd_coupon') > -1) {// check if there's wpcd_coupon in the url
        var wpcd_id = jQuery.urlParam('wpcd_coupon');
        oldLink = window.location.href.replace("wpcd_coupon=" + wpcd_id, "wpcd_coupon=" + CoupenId);

    }
    else if (window.location.href.indexOf('?') > -1 && window.location.href.indexOf('?wpcd_coupon') === -1) {// check if there's paramater in the url   
        oldLink = window.location.href + oldLink.replace("?", "&");
    }
    a.attr('href', oldLink);

    //the affiliate link
    var theLink = a.attr("data-aff-url");
    window.open(a.attr('href'), '_blank');
    window.location = theLink;
    return false;
}

