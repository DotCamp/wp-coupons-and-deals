// Shows or hides fields according to user inputs.
jQuery(document).ready(function ($) {

    //variables
    var templates = {
        ONE: 'Template One',
        TWO: 'Template Two',
        THREE: 'Template Three',
        FOUR: 'Template Four',
        FIVE: 'Template Five',
        SIX: 'Template Six',
        SEVEN: 'Template Seven',
        EIGHT: 'Template Eight',
    };
    var couponTypes = {
        COUPON: 'Coupon',
        DEAL: 'Deal',
        IMAGE: 'Image'
    };
    var button_text = $('#buttontext');
    var all_button_text = $('[id$=buttontext]');
    var deal_text = $('#dealtext');
    var show_expiration = $('#show-expiration');
    var expiration = $('#expiredate');
    var time_expiration = $('#expiretime');
    var never_expire = $('#neverexpire-checkbox'); // the wrraper of the checkbox
    var never_expire_check = $('#never-expire-check');//the checkbox itself
    var coupon_template = $('#coupon-template');
    var hide_coupon = $('#hide-coupon');
    var coupon_hidden = $('.wpcd-coupon-hidden');
    var coupon_not_hidden = $('.wpcd-coupon-not-hidden');
    var hide_coupon_parent = hide_coupon.closest('tr');
    var fields_temp4 = $('[id^=temp4]');
    var allexpiration = $('[id$=expiredate]');
    var featuredImage = $('#_thumbnail_id');
    var templateFiveThemeField = $('.template-five-theme-field');
    var templateFiveTheme = $('#template-five-theme');
    var templateSixThemeField = $('.template-six-theme-field');
    var templateSixTheme = $('#template-six-theme');

    //initializations
    initCouponTemplate();

    initExpirationSelectField();

    coupon_deal_change();

    initHideCouponField();

    //events
    $('[name="show-expiration"]').on('change', onExpirationSelectFieldChange);

    coupon_template.on('change', onCouponTemplateFieldChange);

    //on coupon type change
    $('[name="coupon-type"]').on('change', coupon_deal_change);


    hide_coupon.on('change', onHideCouponFieldChange);

    //on neverexpire checkbox change
    $(never_expire_check).on('change', onNeverExpireCheckboxChange);

    //on featured image set
    wp.media.featuredImage.frame().on('select', function () {
        var frame = wp.media.featuredImage.frame();
        var attachment = frame.state().get('selection').first().toJSON();
        $('.wpcd-template-five-pro-img')
            .children('img')
            .attr('src', attachment.url);
        $('.wpcd-coupon-six-img-and-btn')
            .find('img')
            .attr('src', attachment.url);
        //on featured image remove
        setTimeout(function () {
            removeFeaturedImage();
        }, 1000);
    });

    removeFeaturedImage();

    // Start of Import
    jQuery("#wpcd_import_form").submit(function () {
        jQuery(".wpcd_import_form_loader").fadeIn();
    });
    
    jQuery(".wpcd-import-btn").on("click", function(e) {
        e.preventDefault();
        
        
        var regex = /^([a-zA-Z0-9()\s_\\.\-:])+(.csv)$/;
        if (regex.test($("#wpcd_import_file").val().toLowerCase())) {
            if (typeof (FileReader) != "undefined") {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var rows = e.target.result.split("\n");
                    var import_fields_data      = [];
                    var j                       = 0;
                    var i                       = 0;
                    var cells                   = 0;
                    var rowcount                = rows.length-1;
                    var wpcp_coupons_data = {
                        category                 : '',
                        vendor                  : '',
                        title                   : '',
                        coupon_code             : '',
                        link                    : '',
                        discount_text           : '',
                        description             : '',
                        hide_coupon             : '',
                        default_coupon_template : '',
                        coupon_count            : 0,
                        row_count               : rowcount-1, // minus the csv header
                    }
                    // Collect options value to determine index.
                    var select_options_value = [];
                    jQuery('.wpcd_import_field_select option').each(function(index, option) {
                        if (index <= 10){ // Ten option values since we are using class ".wpcd_import" this will iterate to all select options.
                            select_options_value.push(option.value);
                        }else {
                            return false;
                        } 
                    });
                    // Get selected options insert to array and get index.
                    jQuery('.wpcd_import_field_select option:selected').each(function(index, option) {
                        if (option.value == "" || option.value == null) {
                            import_fields_data[select_options_value[index]] = index;
                            
                        }else {
                            import_fields_data[option.value] = select_options_value.indexOf(option.value);
                        }
                        
                    });
                    wpcp_coupons_data['category']                = cells[import_fields_data['coupon_category']];
                    wpcp_coupons_data['vendor']                  = cells[import_fields_data['coupon_vendor']];
                    wpcp_coupons_data['title']                   = cells[import_fields_data['coupon_title']];
                    wpcp_coupons_data['coupon_code']             = cells[import_fields_data['coupon_details_coupon-code-text']];
                    wpcp_coupons_data['link']                    = cells[import_fields_data['coupon_details_link']];
                    wpcp_coupons_data['discount_text']           = cells[import_fields_data['coupon_details_discount-text']];
                    wpcp_coupons_data['description']             = cells[import_fields_data['coupon_details_description']];
                    wpcp_coupons_data['expiry_date']             = cells[import_fields_data['coupon_details_expire-date']];
                    wpcp_coupons_data['hide_coupon']             = cells[import_fields_data['coupon_details_hide-coupon']];
                    wpcp_coupons_data['default_coupon_template'] = cells[import_fields_data['coupon_details_coupon-template']];
                    // preparing the select ID array
                    for (i = 0; i < rows.length; i++) {
                        // Filter header
                        // Cells variable is where the column data can be found.
                        cells = rows[i].split(",");

                        if (cells.length > 1) {
                            // Column values
                            if (i == 0) {// Headers
                                for (j = 0; j < cells.length; j++) {
                                    wpcd_temp4 = '#wpcd_import_select_' + cells[j].trim().toLowerCase().replace(/ /g,"_");
                                }
                            }
                            else {
                                
                                wpcp_coupons_data['category']                = cells[import_fields_data['coupon_category']];
                                wpcp_coupons_data['vendor']                  = cells[import_fields_data['coupon_vendor']];
                                wpcp_coupons_data['title']                   = cells[import_fields_data['coupon_title']];
                                wpcp_coupons_data['coupon_code']             = cells[import_fields_data['coupon_details_coupon-code-text']];
                                wpcp_coupons_data['link']                    = cells[import_fields_data['coupon_details_link']];
                                wpcp_coupons_data['discount_text']           = cells[import_fields_data['coupon_details_discount-text']];
                                wpcp_coupons_data['description']             = cells[import_fields_data['coupon_details_description']];
                                wpcp_coupons_data['expiry_date']             = cells[import_fields_data['coupon_details_expire-date']];
                                wpcp_coupons_data['hide_coupon']             = cells[import_fields_data['coupon_details_hide-coupon']];
                                wpcp_coupons_data['default_coupon_template'] = cells[import_fields_data['coupon_details_coupon-template']];
                                wpcp_coupons_data['coupon_count']            = i; 
                    
                                // Import Loader
                                var status = 'no';
                                jQuery(".wpcd_import_field_select").each(function () {
                                    var import_key = jQuery(this).val();
                                    if (import_key == 'coupon_title') {
                                        status = 'yes';
                                    }
                                });
                                if (status == 'yes') {
                                    jQuery(".wpcd_import_form_final_loader").fadeIn();
                                    wpcd_ajax_import('wpcd_process_import', JSON.stringify(wpcp_coupons_data));
                                } 
                                 // End of Import Loader
                            }
                        }
                    }
                } // Row Loop
                reader.readAsText($("#wpcd_import_file")[0].files[0]);
            } else {
                alert("This browser does not support HTML5.");
            }
        } else {
            alert("Please upload a valid CSV file.");
        }
         
    }); // End of final submit click
    
 
    $("#wpcd_import_next_submit").on("click", function (e) {
        e.preventDefault();

        var regex = /^([a-zA-Z0-9()\s_\\.\-:])+(.csv)$/;
        
        // jQuery('.wpcd_choose_fields_wr').show();
        var countCol = jQuery(".wpcd_import_field span strong"); // Storing selector to prevent call redundancy
        var array_temp = ""; // Storing object data
       
        if (regex.test($("#wpcd_import_file").val().toLowerCase())) {
            if (typeof (FileReader) != "undefined") {
                var reader = new FileReader();
                reader.onload = function (e) {
                    
                    var table = $("<table class=\"widefat wpcd_import_preview\" cellspacing=\"0\"></table>");
                    var rows = e.target.result.split("\n");
                    var rows2 = e.target.result.split("\n"); // same with rows
                    var row   = "";
                    var cells = "";
                    var cell = "";
                    var j = 0;
                    var i = 0;
                    // Row loop
                    for (i = 0; i < rows.length; i++) {
                        row = $("<tr />");
                        cells = rows[i].split(","); 
                        if (cells != "") { // Check if there are blanks  
                           
                            countCol.text(i); //Removes index 0 
                            //If Header
                            if ( i == 0 ) {
                                row = $("<thead/>");
                                cells = rows[i].split(",");  
                            }
                            // Column loop
                            for (j = 0; j < cells.length; j++) {

                                cell = $("<td />");
                                cells[j] = cells[j].trim();
                                cell.html(cells[j]);
                                row.append(cell);
                            }
                            table.append(row);
                            
                        } // End of Blank filter check
                    }
                    $("#wpcd-table-csv").html('');
                    $("#wpcd-table-csv").append(table);
                      
                    // Select option data
                    var wpcd_import_field_inner_wr = jQuery(".wpcd_import_field_inner_wr"); // storing selector
                    var rows_length = rows2.length; // to prevent calling length forever
                    jQuery("#wpfooter").detach(); // removes the WP footer at the bottom 
                    var column2 = [];
                    
                    var col = null;
                    i = 0;
                    row = null;
                    var wpcd_temp = "";
                    var wpcd_temp2 = "";
                    var wpcd_count = 0;
                    for (i = 0; i < rows_length; i++) {
                        row = $("<tr />");
                        col = rows2[i].split(","); 
                        column2.push( [col] );
                        col_length = col.length;
                        // If Titles on first row
                        wpcd_temp = "";
                        wpcd_temp2 = "";
                        if ( i == 0 ) {
                            wpcd_count = col_length-1;
                            do {
                                wpcd_temp2 = col[wpcd_count].toLowerCase().trim().split(' ').join('_');
                                wpcd_temp = "";
                                wpcd_temp += "<div class=\"wpcd_import_field\"><label>" + col[wpcd_count].trim() + "</label>";
                                wpcd_temp +='<select class="wpcd_import_field_select" name="wpcd_import_select_' + wpcd_temp2 + '" id="wpcd_import_select_' + wpcd_temp2 + '" ' + 'onChange="return wpcd_checkDuplicateField(\'' + wpcd_temp2 + '\')">';
                                wpcd_temp += "<option value=\"\">Select</option>";
                                wpcd_temp += "<option value=\"coupon_title\">Coupon Title</option>";
                                wpcd_temp += "<option value=\"coupon_details_description\">Coupon Description</option>";
                                wpcd_temp += "<option value=\"coupon_category\">Coupon Category</option>";
                                wpcd_temp += "<option value=\"coupon_vendor\">Coupon Vendor</option>";
                                wpcd_temp += "<option value=\"coupon_details_coupon-code-text\">Coupon Code</option>";
                                wpcd_temp += "<option value=\"coupon_details_link\">Coupon Link</option>";
                                wpcd_temp += "<option value=\"coupon_details_discount-text\">Discount Amount/Text</option>";
                                wpcd_temp += "<option value=\"coupon_details_expire-date\">Expiration Date</option>";
                                wpcd_temp += "<option value=\"coupon_details_hide-coupon\">Hide Coupon</option>";
                                wpcd_temp += "<option value=\"coupon_details_coupon-template\">Coupon Template</option>";
                                wpcd_temp += "</select>";
                                wpcd_temp += "</div>";
                                
                                jQuery(wpcd_temp).prependTo(wpcd_import_field_inner_wr);
                                wpcd_count--;
                                
                            } while (wpcd_count >= 0);    
                        }
                    }// End of Select data
                    
                }
                reader.readAsText($("#wpcd_import_file")[0].files[0]);
                jQuery(".wpcd-import-wrapper").show(); // Second form shows only if file is valid
                jQuery("#wpcd_import_form").hide(); // Hides the first Import Form
            } else {
                alert("This browser does not support HTML5.");
            }
        } else {
            alert("Please upload a valid CSV file.");
            // jQuery('.wpcd-import-wrapper').hide();
            jQuery("#wpcd_import_form_wr").show();
        }
        
    });

    // End of Import


    $(document).on('change', 'input[name="template-five-theme"]', function () {
        updateTemplateFiveTheme($(this).val());
    });

    $(document).on('change', 'input[name="template-six-theme"]', function () {
        updateTemplateSixTheme($(this).val());
    });

    //functions 
    function coupon_deal_change() {
        var ctype = $('[name="coupon-type"]').val();

        $('#coupon-type').closest('tr').nextAll().removeClass('hide');
        $('.coupon-image-field').addClass('hide');
        $('.only-coupon-code').removeClass('hide');

        if (ctype === couponTypes.COUPON) {

            if (coupon_template.val() === templates.FOUR)
                all_button_text.show();
            else
                button_text.show();

            deal_text.hide();
            hide_coupon_parent.show();

        } else if (ctype === couponTypes.DEAL) {

            all_button_text.hide();
            deal_text.show();
            hide_coupon_parent.hide();
            hide_coupon.val('No');
            coupon_not_hidden.show();
            coupon_hidden.hide();

        } else if (ctype === couponTypes.IMAGE) {
            $('.only-coupon-code').addClass('hide');
            $('#coupon-type').closest('tr').nextAll().addClass('hide');
            $('.coupon-image-field').removeClass('hide');
            $('#text').removeClass('hide');

        }
    }

    function initCouponTemplate() {
        var currentTemplate = coupon_template.val();

        if (
            currentTemplate === templates.TWO ||
            currentTemplate === templates.SIX
        ) {
            time_expiration.show();
            expiration.show();
            show_expiration.hide();
            never_expire.show();
        } else {
            time_expiration.hide();
            never_expire.hide();
        }

        if (currentTemplate === templates.FOUR) {
            fields_temp4.show();
        } else {
            fields_temp4.hide();
        }

        if (currentTemplate === templates.FIVE) {
            templateFiveThemeField.show();
        } else {
            templateFiveThemeField.hide();
        }

        if (currentTemplate === templates.SIX) {
            templateSixThemeField.show();
        } else {
            templateSixThemeField.hide();
        }

        coupon_deal_change();
    }

    function initExpirationSelectField() {
        /*if ($('#show-expiration').val() === 'Show') {
            expiration.show("slow");
            if (coupon_template.val() === templates.FOUR)
                $('[id$=expiredate]').show('slow');
        } else {
            allexpiration.hide();
        }*/
        updateExpirationSelectField($('#show-expiration').val());
    }

    function initHideCouponField() {
        if (hide_coupon.val() === 'Yes') {
            coupon_hidden.show();
            coupon_not_hidden.hide();
        } else {
            coupon_hidden.hide();
            coupon_not_hidden.show();
        }

        if (never_expire_check.prop('checked')) {
            $('b.expires-on').toggle();
            $('b.never-expire').toggle();
        }
    }
    function onExpirationSelectFieldChange() {
        updateExpirationSelectField($(this).val());
    }

    function updateExpirationSelectField(val) {
        if (val === 'Show') {
            expiration.show("slow");
            $('.with-expiration1').removeClass('hide-expire-preview');
            $('.without-expiration1').removeClass('hide-expire-preview');
            if (coupon_template.val() === templates.FOUR) {
                $('[id$=expiredate]').show('slow');
                $('.with-expiration-4-2').removeClass('hide-expire-preview');
                $('.without-expiration-4-2').removeClass('hide-expire-preview');
                $('.with-expiration-4-3').removeClass('hide-expire-preview');
                $('.without-expiration-4-3').removeClass('hide-expire-preview');
            }
        } else {
            $('.with-expiration1').addClass('hide-expire-preview');
            $('.without-expiration1').addClass('hide-expire-preview');
            $('.with-expiration-4-2').addClass('hide-expire-preview');
            $('.without-expiration-4-2').addClass('hide-expire-preview');
            $('.with-expiration-4-3').addClass('hide-expire-preview');
            $('.without-expiration-4-3').addClass('hide-expire-preview');
            allexpiration.hide();
        }
    }

    function onCouponTemplateFieldChange() {
        var currentTemplate = $(this).val();

        if (
            currentTemplate === templates.TWO ||
            currentTemplate === templates.SIX
        ) {
            time_expiration.show("slow");
            expiration.show("slow");
            show_expiration.hide();
            never_expire.show();
        } else {
            time_expiration.hide();
            show_expiration.show();
            never_expire.hide();
        }

        if (currentTemplate === templates.FOUR) {
            fields_temp4.show();
        } else {
            fields_temp4.hide();
        }

        if (currentTemplate === templates.FIVE) {
            templateFiveThemeField.show();
        } else {
            templateFiveThemeField.hide();
        }

        if (currentTemplate === templates.SIX) {
            templateSixThemeField.show();
        } else {
            templateSixThemeField.hide();
        }

        coupon_deal_change();
    }

    function onHideCouponFieldChange() {
        if ($(this).val() === 'Yes') {
            coupon_hidden.show();
            coupon_not_hidden.hide();
        } else {
            coupon_hidden.hide();
            coupon_not_hidden.show();
        }
    }

    function onNeverExpireCheckboxChange() {
        var checked = $(this).prop('checked');
        $('b.expires-on').toggle();
        $('b.never-expire').toggle();

    }

    function updateTemplateFiveTheme(color) {
        $('.wpcd-template-five')
            .css('border-color', color);

        $('.wpcd-template-five-exp')
            .css('background-color', color);

        $('.wpcd-template-five-btn')
            .css('border-color', color);

        $('.wpcd-template-five-btn p')
            .css('color', color);
        $('.wpcd-template-five .get-code-wpcd')
            .css('background-color', color);
        $('.wpcd-template-five .get-code-wpcd > div')
            .css('border-left-color', color);

    }

    function updateTemplateSixTheme(color) {
        var couponSix = $('.wpcd-coupon-six');

        couponSix
            .css('border-color', color);

        couponSix
            .find('.wpcd-ribbon')
            .css('background-color', color);

        couponSix
            .find('.coupon-code-button')
            .css('border-color', color)
            .css('color', color);

        couponSix
            .find('.wpcd-coupon-six-texts .exp')
            .css('border-color', color);

        couponSix
            .find('.get-code-wpcd')
            .css('background-color', color);

        couponSix
            .find('.get-code-wpcd > div')
            .css('border-left-color', color);

        couponSix
            .find('.wpcd-ribbon-before')
            .css('border-left-color', color);

        couponSix
            .find('.wpcd-ribbon-after')
            .css('border-right-color', color);

        couponSix
            .find('.wpcd-coupon-hidden .coupon-button')
            .css('border-color', color);

    }

    function removeFeaturedImage() {
        $('#remove-post-thumbnail').on('click', function () {
            var dummySrc = $('.wpcd-template-five-pro-img')
                .children('img')
                .data('src');
            $('.wpcd-template-five-pro-img')
                .children('img')
                .attr('src', dummySrc);

            dummySrc = $('.wpcd-coupon-six-img-and-btn')
                .find('img')
                .data('src');
            $('.wpcd-coupon-six-img-and-btn')
                .find('img')
                .attr('src', dummySrc);
        });
    }

});

// For tabs , colorpicker and choosing of type of shortcode
jQuery(document).ready(function ($) {

    /**
     * Function tabs
     * used in tabs of setting page
     * @returns void
     */
    window.tabs = function () {
        //$('form').append($('.tabs .form-table'));
        $($('.wpcd_settings_section .nav-tab-wrapper .form-table').get().reverse()).each(function () {
            $(this).insertAfter('.nav-tab-wrapper');
        });
        var tabs = $('.wpcd_settings_section button.nav-tab'),
            active = $('.wpcd_settings_section .nav-tab.active'),
            index_active = tabs.index(active),
            tabs_contents = $('.wpcd_settings_section .nav-tab-wrapper').siblings('.form-table'),
            active_content = tabs_contents.eq(index_active);
        if (!tabs) {
            retutn;
        }

        /**
         * hide all tabs
         * except the active one
         */
        tabs_contents.each(function () {
            $(this).hide();
        });
        active_content.show();

        /**
         * change the tab content when click
         * by giving the button active class
         */
        tabs.each(function () {
            $(this).click(function (e) {
                // check if the active and the clicked button is not the same
                if ($(this)[0] !== active[0]) {
                    $(this).addClass('active');
                    active.removeClass('active');

                    //call the function to show the active content
                    window.tabs();
                }
            });
        });
    };
    window.tabs();

    /**
     * For color pickers
     */

    var wpcd_colorSelectors = $('.wpcd_colorSelectors');
    if ($.isFunction($(wpcd_colorSelectors[0]).ColorPicker))
        for ($i = 0; $i < wpcd_colorSelectors.length; $i++) {
            $(wpcd_colorSelectors[$i]).ColorPicker({
                onShow: function (colpkr) {
                    $(colpkr).fadeIn(500);
                    return false;
                },
                onHide: function (colpkr) {
                    $(colpkr).fadeOut(500);
                    return false;
                },
                onChange: function (hsb, hex, rgb) {
                    $this = $('#' + this.data('targetid'));

                    $this.children('div').css('backgroundColor', '#' + hex);
                    $this.children('input').val('#' + hex);
                    $this.children('input').trigger('change');
                }
            });
        }

    /**
     *  color Picker for import Page
     */
    var select_temp_import = $('select[name="wpcd_default_template"]');
    if (select_temp_import.length) {
        function is_temp_has_color() {
            var selected_theme = $('select[name="wpcd_default_template"]').val();

            // Template Five and Six has color picker
            if (selected_theme == 'Template Five' ||
                selected_theme == 'Template Six') {
                $('#wpcd_import_color_parent').show();
            } else {
                $('#wpcd_import_color_parent').hide();
            }
        }
        is_temp_has_color();

        select_temp_import.change(function () {
            is_temp_has_color();
        });
    }
    /**
     * for widget category filter
     */
    window.widget;

    function categoryFilterWidget() {
        var category_filter_select_widget = $('.coupon_category_filter_select_widget');

        category_filter_select_widget.each(function () {
            //you are in widget page
            window.widget = 1;

            //hide all coupons
            $(this).parent().next().children('datalist').children('option[category-title]').prop('disabled', true);

            //show the coupony of the selected category
            $(this).parent().next().children('datalist').children('option[category-title="' + $(this).val() + '"]').prop('disabled', false);

            $(this).change(function () {
                $(this).parent().next().children('input').val('');
                //hide all coupons
                $(this).parent().next().children('datalist').children('option[category-title]').prop('disabled', true);

                //show the coupony of the selected category
                $(this).parent().next().children('datalist').children('option[category-title="' + $(this).val() + '"]').prop('disabled', false);
            });
        });
    }

    categoryFilterWidget();
    //a trigger when adding a new widget
    $('body').bind('wpcd_add_widget', function () {
        categoryFilterWidget();
    });


    //Feature of choosing Archive , category or Single shortcode
    window.coupons_shortcode_type = $('#coupons_shortcode_type');

    //for archive
    window.coupons_style_select = $('#coupons_style_select');
    window.coupons_template_select = $('#coupons_template_select');
    window.coupons_count = $('#wpcd_coupon_count');

    //for category
    window.coupons_style_category_select = $('#coupons_style_category_select');
    window.coupons_template_category_select = $('#coupons_template_category_select');

    //for vendor
    window.coupons_style_vendor_select = $('#coupons_style_vendor_select');
    window.coupons_template_vendor_select = $('#coupons_template_vendor_select');

    function WpcdCouponChoosingInsert() {
        function displayNoneforAll() {
            $('.shortcode_inserter_select').not('.wpcd_types_select').hide();
        }

        displayNoneforAll();
        if (coupons_shortcode_type.val() === 'archive') {
            $('.shortcode_inserter_select.wpcd_style_select, .shortcode_inserter_select.wpcd_coupon_count').show();

            //check if horizontal style chosen
            if ($('#coupons_style_select').val() === 'horizontal')
                $('.shortcode_inserter_select.wpcd_template_select').show();
            else
                $('.shortcode_inserter_select.wpcd_template_select').hide();


            $('#coupons_style_select').change(function () {
                WpcdCouponChoosingInsert();
            });

        } else if (coupons_shortcode_type.val() === 'category') {
            $('.shortcode_inserter_select.wpcd_categories_select, .shortcode_inserter_select.wpcd_coupon_count').show();
            $('.shortcode_inserter_select.wpcd_style_category_select').show();
            //check if horizontal style chosen
            if ($('#coupons_style_category_select').val() === 'horizontal')
                $('.shortcode_inserter_select.wpcd_template_category_select').show();
            else
                $('.shortcode_inserter_select.wpcd_template_category_select').hide();

            $('#coupons_style_category_select').change(function () {
                WpcdCouponChoosingInsert();
            });

        } else if (coupons_shortcode_type.val() === 'vendor') {
            $('.shortcode_inserter_select.wpcd_vendors_select, .shortcode_inserter_select.wpcd_coupon_count').show();
            $('.shortcode_inserter_select.wpcd_style_vendor_select').show();
            //check if horizontal style chosen
            if ($('#coupons_style_vendor_select').val() === 'horizontal')
                $('.shortcode_inserter_select.wpcd_template_vendor_select').show();
            else
                $('.shortcode_inserter_select.wpcd_template_vendor_select').hide();

            $('#coupons_style_vendor_select').change(function () {
                WpcdCouponChoosingInsert();
            });

        } else if (coupons_shortcode_type.val() === 'single') {
            if (window.widget === 1)
                return;
            $('.shortcode_inserter_select.wpcd_coupons_select').show();
            $('.shortcode_inserter_select.wpcd_type_select').show();
            //filter Category select
            $('.shortcode_inserter_select.wpcd_category_filter_select').show();

            //The datalist element
            var coupon_select = $('#coupon_list');

            //hide all option that have category
            coupon_select.children('option[category-title]').prop('disabled', true);

            //show the coupony of the selected category
            $('option[category-title="' + $('#select_category_filter').val() + '"]').prop('disabled', false);
            $('#select_category_filter').change(function () {
                $('#coupon_select').val("");
                WpcdCouponChoosingInsert();
            });

        } else { // free version
            $('.shortcode_inserter_select.wpcd_coupons_select').show();
            $('.shortcode_inserter_select.wpcd_type_select').show();
        }

    }

    WpcdCouponChoosingInsert();
    coupons_shortcode_type.change(function () {
        WpcdCouponChoosingInsert();

        //resize the window
        thickbox_resize();
    });

});


/* <fs_premium_only> */

//Inserts coupon shortcode.
function WpcdCouponInsert() {
    if (coupons_shortcode_type.val() === 'single') {
        var $coupon_select = jQuery('option[value="' + jQuery('#coupon_select').val() + '"]');
        var coupon_shortcode_type = jQuery("#coupon_shortcode_type");
        var coupon_id = $coupon_select.attr('coupon-id');

        if (coupon_shortcode_type.val() === 'coupon') {
            window.send_to_editor("[wpcd_coupon id=" + coupon_id + "]");
        } else if (coupon_shortcode_type.val() === 'code') {
            var $coupon_select = window.send_to_editor("[wpcd_code id=" + coupon_id + "]");
        }
    } else if (coupons_shortcode_type.val() === 'archive') {
        var counts = window.coupons_count.val();
        if (coupons_style_select.val() === 'vertical')
            window.send_to_editor("[wpcd_coupons count=" + counts + "]");
        else {
            var temp = coupons_template_select.val();
            window.send_to_editor("[wpcd_coupons count=" + counts + " temp=" + temp + "]");
        }

    } else if (coupons_shortcode_type.val() === 'category') {
        var counts = window.coupons_count.val();
        var $category_select = jQuery('#coupon_typelist').children('option[value="' + jQuery('#coupon_type').val() + '"]');
        var category_id = $category_select.attr('category_id');
        if (coupons_style_category_select.val() === 'vertical')
            window.send_to_editor("[wpcd_coupons_loop count=" + counts + " cat=" + category_id + "]");
        else {
            var temp = coupons_template_category_select.val();
            window.send_to_editor("[wpcd_coupons_loop count=" + counts + " cat='" + category_id + "' temp='" + temp + "']");
        }
    } else if (coupons_shortcode_type.val() === 'vendor') {
        var counts = window.coupons_count.val();
        var $vendor_select = jQuery('#coupon_typelist_vendor').children('option[value="' + jQuery('#coupon_type_vendor').val() + '"]');
        var vendor_id = $vendor_select.attr('vendor_id');
        if (coupons_style_vendor_select.val() === 'vertical')
            window.send_to_editor("[wpcd_coupons_loop count=" + counts + " vend=" + vendor_id + "]");
        else {
            var temp = coupons_template_vendor_select.val();
            window.send_to_editor("[wpcd_coupons_loop count=" + counts + " vend='" + vendor_id + "' temp='" + temp + "']");
        }
    }


}

/* </fs_premium_only> */

//Inserts coupon shortcode.
function WpcdCouponInsertFree() {
    var $coupon_select = jQuery('option[value="' + jQuery('#coupon_select').val() + '"]');
    var coupon_shortcode_type = jQuery("#coupon_shortcode_type");
    var coupon_id = $coupon_select.attr('coupon-id');
    if (coupon_shortcode_type.val() === 'coupon') {
        window.send_to_editor("[wpcd_coupon id=" + coupon_id + "]");
    } else if (coupon_shortcode_type.val() === 'code') {
        window.send_to_editor("[wpcd_code id=" + coupon_id + "]");
    }

}

//Update Counter on date Change
function update_two_counter_date(data) {
    jQuery('[id^=clock_two_').show();
    var coup_date = data;
    if (coup_date.indexOf("-") >= 0) {
        var dateAr = coup_date.split('-');
        coup_date = dateAr[1] + '/' + dateAr[0] + '/' + dateAr[2];
    }
    selectedDate = coup_date + ' ' + jQuery("#expire-time").val();
    $clock.countdown(selectedDate.toString());
}

function update_six_counter_date(data) {
    jQuery('[id^=clock_six_').show();
    var coup_date = data;
    if (coup_date.indexOf("-") >= 0) {
        var dateAr = coup_date.split('-');
        coup_date = dateAr[1] + '/' + dateAr[0] + '/' + dateAr[2];
    }
    selectedDate = coup_date + ' ' + jQuery("#expire-time").val();
    $clock2.countdown(selectedDate.toString());
}

//Adding the tooltip to show when hovered.
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
});

//Resizes the coupon inserter popup.
function thickbox_resize() {
    jQuery(function ($) {
        var $thickbox = $("#TB_window");
        if ($thickbox.find(".wpcd_shortcode_insert").length > 0) {
            var coupon_inserter_height = $('.wpcd_shortcode_insert').outerHeight() + $('.wpcd_shortcode_insert-bt').outerHeight() + $('#TB_title').outerHeight();
            var $ajax_content = $("#TB_ajaxContent");
            $thickbox.height((coupon_inserter_height - 20));
            $ajax_content.height((coupon_inserter_height));
            $ajax_content.css({ 'width': '100%', 'padding': '0' });
        }
    });
}

jQuery(function ($) {
    $('#wpcd_add_shortcode').on('click', function () {
        setTimeout(function () {
            thickbox_resize();
        }, 10);
    });
    $(window).on('resize load', function () {
        thickbox_resize();
    });
});

//Default preview metabox.
jQuery(document).ready(function ($) {

    $(function () {

        //change title dynamically
        $('#title').keyup(function () {
            var title = $(this).val();
            $('.wpcd-coupon-title').text(title);
            $('.wpcd-coupon-one-title').text(title);
            $('.wpcd-coupon-three-title').text(title);
            $('.wpcd-coupon-four-title').text(title);
            $('.wpcd-coupon-five-title').text(title);
            $('.wpcd-coupon-six-title').text(title);
            $('.admin_wpcd_seven_new_title a').text(title);
        });

        //change description dynamically (this works only with text editor)
        $('#description').keyup(function () {
            var description = $(this).val();
            $('.wpcd-coupon-description').html(description);
        });

        //if the user used one of the button instead of writing the code
        $('#description').change(function () {
            var description = $(this).val();
            $('.wpcd-coupon-description').html(description);

        });

        $('#discount-text').keyup(function () {
            var discount_text = $(this).val();
            $('.wpcd-coupon-discount-text').text(discount_text);
            $('.wpcd-coupon-one-discount-text').text(discount_text);
            $('.wpcd-coupon-two-discount-text').text(discount_text);
            $('.wpcd-four-discount-text').eq(0).text(discount_text);
            $('.wpcd-coupon-five-discount-text').text(discount_text);
            $('.wpcd-coupon-six-discount-text').text(discount_text);
            $('.admin_wpcd_seven_percentOff p').text(discount_text);
        });

        $('#second-discount-text').keyup(function () {
            var discount_text = $(this).val();
            $('.wpcd-four-discount-text').eq(1).text(discount_text);
        });

        $('#third-discount-text').keyup(function () {
            var discount_text = $(this).val();
            $('.wpcd-four-discount-text').eq(2).text(discount_text);
        });

        $('#coupon-code-text').keyup(function () {
            var coupon_code_text = $(this).val();
            $.each($('.wpcd-coupon-preview'), function () {
                $(this).find('.coupon-code-button:eq(0)').text(coupon_code_text)
            });
        });

        $('#second-coupon-code-text').keyup(function () {
            var coupon_code_text = $(this).val();
            $('.wpcd-coupon-four')
                .find('.coupon-code-button:eq(1)')
                .text(coupon_code_text)
        });

        $('#third-coupon-code-text').keyup(function () {
            var coupon_code_text = $(this).val();
            $('.wpcd-coupon-four')
                .find('.coupon-code-button:eq(2)')
                .text(coupon_code_text)
        });

        $('#deal-button-text').keyup(function () {
            var deal_code_text = $(this).val();
            $('.deal-code-button').text(deal_code_text);
            $('.wpcd-coupon-one-btn').text(deal_code_text);
        });

        // template seven coupon code button 
        $('#coupon-code-text').keyup(function () {
            var wpcd_seven_btn = $(this).val();
            $('#wpcd-coupon-code-seven').attr('title', wpcd_seven_btn);
        });

        var coupon_code_div = $('.wpcd-coupon-code');
        var deal_code_div = $('.wpcd-deal-code');
        var coupon_one_coupon = $('.wpcd-coupon-one-coupon');
        var coupon_one_deal = $('.wpcd-coupon-one-deal');
        var coupon_two_coupon = $('.wpcd-coupon-two-coupon-code');
        var coupon_two_deal = $('.wpcd-coupon-two-deal');
        var coupon_three_coupon = $('.wpcd-coupon-three-coupon-code');
        var coupon_three_deal = $('.wpcd-coupon-three-deal');
        var coupon_code_div = $('.wpcd-coupon-code');

        if ($('#coupon-type').val() === 'Coupon') {
            coupon_code_div.show();
            coupon_one_coupon.show();
            coupon_two_coupon.show();
            coupon_three_coupon.show();
            deal_code_div.hide();
            coupon_one_deal.hide();
            coupon_two_deal.hide();
            coupon_three_deal.hide();
        } else {
            coupon_code_div.hide();
            coupon_one_coupon.hide();
            coupon_two_coupon.hide();
            coupon_three_coupon.hide();
            deal_code_div.show();
            coupon_one_deal.show();
            coupon_two_deal.show();
            coupon_three_deal.show();
        }

        $('[name="coupon-type"]').on('change', function () {
            if ($(this).val() === 'Coupon') {
                $('.coupon-type').text('Coupon');
                coupon_code_div.show("slow");
                coupon_one_coupon.show();
                deal_code_div.hide("slow");
                coupon_one_deal.hide();
            } else {
                $('.coupon-type').text('Deal');
                coupon_code_div.hide("slow");
                coupon_one_coupon.hide();
                deal_code_div.show("slow");
                coupon_one_deal.show();
            }
        });

    });

});

//Changing templates.
jQuery(document).ready(function ($) {
    var templates = {
        DEFAULT: 'Default',
        ONE: 'Template One',
        TWO: 'Template Two',
        THREE: 'Template Three',
        FOUR: 'Template Four',
        FIVE: 'Template Five',
        SIX: 'Template Six',
        SEVEN: 'Template Seven',
        EIGHT: 'Template Eight',

    };
    var couponTypes = {
        COUPON: 'Coupon',
        DEAL: 'Deal',
        IMAGE: 'Image'
    }
    var previewWrap = $('#coupon_preview');
    var couponPreview = previewWrap.find('.wpcd-coupon-preview');
    var couponDefault = $('.wpcd-coupon');
    var couponEight = $('.wpcd-coupon-eight');
    var couponOne = $('.wpcd-coupon-one');
    var couponTwo = $('.wpcd-coupon-two');
    var couponThree = $('.wpcd-coupon-three');
    var couponFour = $('.wpcd-coupon-four');
    var couponFive = $('.wpcd-coupon-five');
    var couponSix = $('.wpcd-coupon-six');
    var couponSeven = $('.wpcd-coupon-seven');
    var couponImage = $('.wpcd-coupon-image');
    var couponTemplate = $('#coupon-template');
    var couponType = $('[name="coupon-type"]');

    showTemplatePreview(couponType.val(), couponTemplate.val());

    couponType.on('change', function () {
        showTemplatePreview($(this).val(), couponTemplate.val());
    });

    couponTemplate.on('change', function () {
        showTemplatePreview(couponType.val(), $(this).val());
    });

    function showTemplatePreview(ctype, currentTemplate) {
        couponPreview.hide();
        if (ctype === couponTypes.IMAGE) {
            couponImage.show("slow");
        } else if (currentTemplate === templates.DEFAULT) {
            couponDefault.show('slow');
        }
        else if (currentTemplate === templates.ONE) {
            couponOne.show("slow");
        } else if (currentTemplate === templates.TWO) {
            couponTwo.show("slow");
        } else if (currentTemplate === templates.THREE) {
            couponThree.show("slow");
        } else if (currentTemplate === templates.FOUR) {
            couponFour.show("slow");
        } else if (currentTemplate === templates.FIVE) {
            couponFive.show("slow");
        } else if (currentTemplate === templates.SIX) {
            couponSix.show("slow");
        } else if (currentTemplate === templates.SEVEN) {
            couponSeven.show("slow");
        } else if (currentTemplate === templates.EIGHT) {
            couponEight.show('slow');
        }
    }

});

// upload coupon image
jQuery(function ($) {

    // Set all variables to be used in scope
    var frame,
        metaBox = $('#coupon-details.postbox'), // Your meta box id here
        addImgLink = metaBox.find('.upload-coupon-img'),
        delImgLink = metaBox.find('.delete-coupon-img'),
        imgContainer = metaBox.find('.coupon-img-container'),
        imgIdInput = metaBox.find('#coupon-image-input');

    // ADD IMAGE LINK
    addImgLink.on('click', function (event) {

        event.preventDefault();

        // If the media frame already exists, reopen it.
        if (frame) {
            frame.open();
            return;
        }

        // Create a new media frame
        frame = wp.media({
            title: 'Select or Upload Media Of Your Chosen Persuasion',
            button: {
                text: 'Use this media'
            },
            multiple: false  // Set to true to allow multiple files to be selected
        });


        // When an image is selected in the media frame...
        frame.on('select', function () {

            // Get media attachment details from the frame state
            var attachment = frame.state().get('selection').first().toJSON();

            // Send the attachment URL to our custom image input field.
            imgContainer.append('<img src="' + attachment.url + '" alt="" style="max-width:100%;"/>');
            //update coupon preview
            $('.wpcd-coupon-image img').attr('src', attachment.url);
            // Send the attachment id to our hidden input
            imgIdInput.val(attachment.id);

            // Hide the add image link
            addImgLink.addClass('hidden');

            // Unhide the remove image link
            delImgLink.removeClass('hidden');
        });

        // Finally, open the modal on click
        frame.open();
    });


    // DELETE IMAGE LINK
    delImgLink.on('click', function (event) {

        event.preventDefault();

        // Clear out the preview image
        imgContainer.html('');

        // Un-hide the add image link
        addImgLink.removeClass('hidden');

        // Hide the delete image link
        delImgLink.addClass('hidden');

        // Delete the image id from the hidden input
        imgIdInput.val('');

        $('.wpcd-coupon-image img').attr('src', '');

    });

});


//expire date changes
jQuery(function ($) {
    var couponPreview = $('.wpcd-coupon-preview');
    var coupon4preview = $('.wpcd-coupon-four');

    //update manually
    $('[id$=expire-date]').on('change', function () {
        var val = $(this).val();
        var withExpireBlock, withoutExpireBlock;

        if ($(this).attr('id').search('third') !== -1) {
            withExpireBlock = couponPreview.find('.with-expiration-4-3');
            withoutExpireBlock = couponPreview.find('.without-expiration-4-3');
        } else if ($(this).attr('id').search('second') !== -1) {
            withExpireBlock = couponPreview.find('.with-expiration-4-2');
            withoutExpireBlock = couponPreview.find('.without-expiration-4-2');
        } else {
            withExpireBlock = couponPreview.find('.with-expiration1');
            withoutExpireBlock = couponPreview.find('.without-expiration1');
        }

        if (val || val.trim().length > 0) {
            withExpireBlock.removeClass('hidden');
            withoutExpireBlock.addClass('hidden');
        } else {
            withExpireBlock.addClass('hidden');
            withoutExpireBlock.removeClass('hidden');
        }
    });

    //update through widget
    $('[id$=expire-date]').datepicker({
        dateFormat: $('[id$=expire-date]').data('expiredate-format'),
        showOtherMonths: true,
        onSelect: function (dateText) {

            $(this).trigger('change');
            var today = (new Date()).setHours(0, 0, 0, 0);
            var isExpired = Date.parse(dateText) < today;
            var expireBlock, expiredBlock;

            if ($(this).attr('id').search('third') !== -1) {

                coupon4preview.find('.expiration-date').eq(4).text(dateText);
                coupon4preview.find('.expiration-date').eq(5).text(dateText);
                expireBlock = couponPreview.find('.expire-text-block3');
                expiredBlock = couponPreview.find('.expired-text-block3');

            } else if ($(this).attr('id').search('second') !== -1) {

                coupon4preview.find('.expiration-date').eq(2).text(dateText);
                coupon4preview.find('.expiration-date').eq(3).text(dateText);
                expireBlock = couponPreview.find('.expire-text-block2');
                expiredBlock = couponPreview.find('.expired-text-block2');

            } else {

                $.each(couponPreview, function () {
                    $(this).find('.expiration-date:eq(0)').text(dateText)
                })
                $.each(couponPreview, function () {
                    $(this).find('.expiration-date:eq(1)').text(dateText)
                })
                expireBlock = couponPreview.find('.expire-text-block1');
                expiredBlock = couponPreview.find('.expired-text-block1');
            }

            if (isExpired) {
                expireBlock.addClass('hidden');
                expiredBlock.removeClass('hidden');
            } else {
                expireBlock.removeClass('hidden');
                expiredBlock.addClass('hidden');
            }

            update_two_counter_date(dateText);
            update_six_counter_date(dateText);
        }
    });
});

function wpcd_featured_img_func() {
    var imgSrc = jQuery("#set-post-thumbnail img").attr("src");
    var imgDef = jQuery(".wpcd-default-img").attr("default-img");
    if (typeof imgDef !== "undefined") {
        if (typeof imgSrc !== "undefined") {
            jQuery(".wpcd-get-fetured-img").attr("src", imgSrc);
        } else {
            jQuery(".wpcd-get-fetured-img").attr("src", imgDef);
        }
    }
}

function wpcd_checkDuplicateField(field_key) {
    var data = jQuery("#wpcd_import_select_" + field_key).val();
    jQuery(".wpcd_import_field_select").not(document.getElementById("wpcd_import_select_" + field_key)).each(function () {
        var newdata = jQuery(this).val();
        if (data == newdata) {
            jQuery(this).val("");
        }
    });
}

function wpcd_ajax_import(action, tosent){
    var data = {
        action: action,
        nonce_ajax : wpcd_ajax_script_import.nonce,
        post_var: tosent
    };
    // store search to prevent searching the element. 
    var wpcd_temp5 = JSON.parse(tosent);
    var wpcd_percent_element = jQuery('#wpcd-pbar-percent'); 
    var wpcd_percent_element_span = jQuery('#wpcd-pbar-percent span');
    var wpcd_row_count = jQuery('.wpcd_import_field_submit span strong').text();
    var wpcd_green = jQuery('.wrap .wpcd_green'); // Storing search element
    // (tosent!=null) ? (data.post_var = tosent) : (data.post_var = null);
    var jqxhr =  $.post(wpcd_ajax_script_import.ajaxurl, data, function(response, status) {
        jqxhr.success(function(){ 
            // Check if success to move the progressbar.
            if (status) { 
                // Calculate percent
                var percent = ((wpcd_temp5.coupon_count / wpcd_temp5.row_count) * 100).toFixed(2);
                // Remove the console log on production for checking only
                if (percent >= 5) {
                    wpcd_percent_element.removeClass('wpcd-zero-percent');
                    wpcd_percent_element.addClass('wpcd-twentyfive-percent');
                    wpcd_percent_element_span.text(percent+"%");
                    
                }
                if (percent >= 25) {
                    wpcd_percent_element.removeClass('wpcd-twentyfive-percent');
                    wpcd_percent_element.addClass('wpcd-fifty-percent');
                    wpcd_percent_element_span.text(percent+"%");
                }
                if (percent >= 50) {
                    wpcd_percent_element.removeClass('wpcd-fifty-percent');
                    wpcd_percent_element.addClass('wpcd-seventyfive-percent');
                    wpcd_percent_element_span.text(percent+"%");
                }
                if (percent >= 75) {
                    wpcd_percent_element.removeClass('wpcd-seventyfive-percent');
                    wpcd_percent_element.addClass('wpcd-onehundred-percent');
                    wpcd_percent_element_span.text(percent+"%");
                }
                if (percent == 100) {
                    jQuery(".wpcd_import_notes").show();
                    jQuery(".wpcd_import_form_final_loader").fadeOut();
                    jQuery('.wpcd-import-wrapper').hide();
                    jQuery('#wpcd_import_form').hide();
                    
                    // Showing the green div element after import success.
                    jQuery(wpcd_green).show(); 
                    // Replacing the info for the Coupons added. 
                    jQuery('.wrap .wpcd_green span').text(function () {
                        return jQuery(this).text().replace("0 Coupons added.", wpcd_row_count + " Coupons added.");
                    }); 
                }
            }
        });   
    });
}