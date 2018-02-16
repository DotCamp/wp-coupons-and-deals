// all coupons archive nav active
jQuery(document).ready(function($){
    $.each($('#wpcd_cat_ul > li'), function() {
        if ($(this).children('a').attr('href') === window.location.href) {
            $(this).children('a').addClass('active');
        }
    });
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
    /*var newUrl = "?page=" + $(this).val() + "&" + $.param(params);
     var newUrl = location.href.replace("page="+currentPageNum, "page="+newPageNum);*/
});

jQuery(document).ready(function ($) {
    $(document).ready(function () {
        $('.masterTooltip').hover(function () {
            var title = $(this).attr('title');
            $(this).data('tipText', title).removeAttr('title');
            $('<p class="tooltip"></p>')
                .text(title)
                .appendTo('body')
                .fadeIn('slow');
        }, function () {
            $(this).attr('title', $(this).data('tipText'));
            $('.tooltip').remove();
        }).mousemove(function (e) {
            var mousex = e.pageX + 20;
            var mousey = e.pageY + 10;
            $('.tooltip')
                .css({top: mousey, left: mousex})
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
   
