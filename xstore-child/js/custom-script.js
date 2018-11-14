/**
 * Created by DynamicAction on 4/30/2018.
 */
var main_global;
jQuery(document).ready(function($){

    //remove non QLD states address at checkout
    // var states = ['ACT', 'NSW', 'VIC', 'SA', 'WA', 'TAS', 'NT'];
    // setTimeout(function(){
    //     $.each(states, function(key, value){
    //         $('#billing_state option[value="'+value+'"]').remove();
    //         $('#shipping_state option[value="'+value+'"]').remove();
    //     });
    // }, 2000);

    main_global = {

        init: function(){
            this.selectState();
            this.selectCountry();
            this.checkAddressStates();
            this.restrictStatesSelect();
        },
        restrictStatesSelect: function() {

            $('#place_order').live('click', function (e) {
                var states_error = $('#order_review').find('.states-info').length;
                var states_error_shipping = $('#billing_address_google_field').find('.states-info').length;
                var invalid_error_location = $('#billing_address_google_field').find('.shipping-error-location').length;
                console.log(states_error);
                if (states_error == 1 || states_error_shipping == 1 || invalid_error_location == 1) {
                    $('#place_order').addClass('disabled');
                    $('#place_order').attr('disabled', true);
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
            });
            var billing_state_default = $('#billing_state').val();
            var billing_selected_states = $('#billing_state option:selected').text();
            setTimeout(function(){
                main_global.checkAddressStates(billing_state_default, billing_selected_states);
            }, 3000);

            $('#billing_state').live('change',function(){
                var selected_states = $('#billing_state option:selected').text();
                var address_states = $(this).val();
                main_global.checkAddressStates(address_states, selected_states);
            });

        },
        checkAddressStates: function(states, selectedStates){
            $('.states-info').remove();

            switch( states ){
                case 'ACT':
                    $('#place_order').addClass('disabled');
                    $('#place_order').attr('disabled', true);
                    main_global.statesErrorMessage(selectedStates, 'empassion.com.au');

                    break;
                case 'VIC':
                    $('#place_order').addClass('disabled');
                    $('#place_order').attr('disabled', true);
                    main_global.statesErrorMessage(selectedStates, 'vic.empassion.com.au');

                    break;
                case 'TAS':
                    $('#place_order').addClass('disabled');
                    $('#place_order').attr('disabled', true);
                    main_global.statesErrorMessage(selectedStates, 'vic.empassion.com.au');

                    break;
                case 'SA':
                    $('#place_order').addClass('disabled');
                    $('#place_order').attr('disabled', true);
                    main_global.statesErrorMessage(selectedStates, 'empassion.com.au');

                    break;
                case 'NT':
                    $('#place_order').addClass('disabled');
                    $('#place_order').attr('disabled', true);
                    main_global.statesErrorMessage(selectedStates, 'empassion.com.au');

                    break;
                case 'NSW':
                    $('#place_order').addClass('disabled');
                    $('#place_order').attr('disabled', true);
                    main_global.statesErrorMessage(selectedStates, 'empassion.com.au');

                    break;
                case 'WA':
                    $('#place_order').addClass('disabled');
                    $('#place_order').attr('disabled', true);
                    main_global.statesErrorMessage(selectedStates, 'wa.empassion.com.au');

                    break;
                default:
                    $('#place_order').removeClass('disabled');
                    $('#place_order').attr('disabled', false);
                    console.log(states);
                    break;
            }
        },
        statesErrorMessage: function(states, link){

            var states_error = '<ul class="woocommerce-info" role="info"><li><a href="https://'+link+'">Please click here to place an order in '+states+'.</a><li></ul>';
            $('<div class="states-info">'+states_error+'</div>').insertAfter('#payment');
        },

        redirectStateMap: function(state_id, redirect){
            var state_link;
            switch(state_id){
                case 'qld':
                    state_link = 'https://qld.empassion.com.au';
                    break;
                case 'wa':
                    state_link = 'https://wa.empassion.com.au';
                    break;
                case 'nt':
                    state_link = 'https://empassion.com.au/home';
                    break;
                case 'nsw':
                    state_link = 'https://empassion.com.au/home';
                    break;
                case 'sa':
                    state_link = 'https://empassion.com.au/home';
                    break;
                case 'vic':
                    state_link = 'https://vic.empassion.com.au';
                    break;
                case 'tas':
                    state_link = 'https://vic.empassion.com.au';
                    break;
                case 'act':
                    state_link = 'https://empassion.com.au/home';
                    break;
                default:
                    state_link = 'https://empassion.com.au';
                    break;
            }
            //console.log(state_id);
            if( redirect === false ){
                return state_link;
            }
            else{
                location.href = state_link;
            }

        },

        ajaxLoader: function(ele){
            var loader = '<span class="vc_icon_element-icon fa fa-refresh load-redirection ajax-loading"></span>';
            $(ele).prepend(loader);
        },
        selectCountry: function(){
            $('.select-country').val('AU');
            $('.select-country').find('button img').attr('src', '/wp-content/uploads/2018/07/AU_Flag.png');
            $('.select-country').find('button .sel-desc').text('AU');
            $('.select-country').find('button').attr('title', 'AU');

            $('.select-country').change(function(){
                var country_val = $(this).val();
                main_global.ajaxLoader('.bootstrap-select.select-country');
                var country_link;
                $('.bootstrap-select.select-country').find('button').attr('disabled', true);
                $('.bootstrap-select.select-country').find('button').addClass('btn-disabled');
                switch(country_val){
                    case 'NZ':
                        location.href = 'https://empassion.co.nz';
                        break;
                    case 'USA':
                        location.href = 'https://empassionnatural.com';
                        break;
                    default:
                        break;
                }
                //console.log(country_val);

            });
        },
        selectState: function(){
            $('.select-state').val('QLD');
            $('.select-state').find('button img').attr('src', '/wp-content/uploads/2018/08/qld.png');
            $('.select-state').find('button .sel-desc').text('QLD');
            $('.select-state').find('button').attr('title', 'QLD');

            $('.select-state').change(function(){
                var state_val = $(this).val();
                state_val = state_val.toLowerCase();
                $('#' + state_val ).addClass('active');

                main_global.ajaxLoader('.select-state');
                $('.bootstrap-select.select-state').find('button').attr('disabled', true);
                $('.bootstrap-select.select-state').find('button').addClass('btn-disabled');

                //var parent = main_global;
                main_global.redirectStateMap(state_val);

            });
        },

    }

    main_global.init();

    $('#place_order').live('click', function(e){
        $('.shipping-error').remove();
        $('.shipping').removeClass('error-tr');
        var checked_shipping = $('.shipping_method:checked').length;
        //console.log(checked_shipping);

        if(checked_shipping === 0){
            e.preventDefault();
            e.stopPropagation();
            var shipping_error = '<ul class="woocommerce-error" role="alert"><li>Please select your shipping method.</li></ul>';
            $('.shipping').addClass('error-tr');
            //console.log('NO shipping');
            $('<div class="shipping-error">'+shipping_error+'</div>').insertAfter('#payment');

        }
    });

    var check_wholesale = $('.woocommerce-checkout').hasClass('wholesale_customer');
    if(check_wholesale == false){
        //console.log(check_wholesale);
        //$('.woocommerce-checkout').find('#billing_address_google_field').remove();
        //$('.woocommerce-checkout').find('#shipping_address_google_field').remove();
    }
    if(check_wholesale == true){

    }

    //conversio recommended widget
    setTimeout(function(){
        $( ".rf-recommendation-product" ).each(function() {
            $( '.related_prod_container' ).hide();
            var prod_url = $(this).find('.rf-title a').attr('href');
            var prod_id = $(this).find('.rf-title a').attr('data-rf-track');
            var btn = add_bth_html(prod_id, prod_url);
            $( this ).append( btn );
            console.log("test");
        });
    }, 3000);

    function add_bth_html(id, link){
        var add_btn_html = '<a href="'+link+'" data-rf-track="'+id+'" data-rf-track-source="widget" data-rf-widget-name="default" class="button product_type_simple">Read more</a>';
        return add_btn_html;
    }
});