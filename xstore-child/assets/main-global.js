navigator.UserBrowser = (function(){
    var ua= navigator.userAgent, tem,
        M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
    if(/trident/i.test(M[1])){
        tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
        return 'IE '+(tem[1] || '');
    }
    if(M[1]=== 'Chrome'){
        tem= ua.match(/\b(OPR|Edge)\/(\d+)/);
        if(tem!= null) return tem.slice(1).join(' ').replace('OPR', 'Opera');
    }
    M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
    if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
    return M.join(' ');
})();
var userBrowserAgent = navigator.UserBrowser;
// console.log(navigator.UserBrowser);

jQuery(document).ready(function($){
    $('html').addClass(userBrowserAgent);
    $('.header-logo').find('a').attr('href', 'https://empassion.com.au/home');

    var main_global = {

        init: function(){
            this.selectMapDesktop();
            this.selectMapMobile();
            this.proceedState();
            this.selectState();
            this.unsetActiveMap();
            this.restrictStatesSelect();
            this.selectCountry();
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
        restrictStatesSelect: function(){
            var billing_state_default = $('#billing_state').val();

            $('#place_order').live('click', function(e){
                var states_error = $('#order_review').find('.states-info').length;
                console.log(states_error);
                var billing_state_default = $('#billing_state').val();
                main_global.checkAddressStates(billing_state_default);

                if( states_error == 1 ){
                    $('#place_order').addClass('disabled');
                    $('#place_order').attr('disabled', true);
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
            });


            setTimeout(function(){
                main_global.checkAddressStates(billing_state_default);
            }, 3000);

            $('#billing_state').live('change',function(){
              var address_states = $(this).val();
                main_global.checkAddressStates(address_states);
                console.log(address_states);
            });
            var shipping_state_default = $('#shipping_state').val();
            console.log(shipping_state_default);
            if( shipping_state_default != '' ){
                setTimeout(function(){
                    main_global.checkAddressStates(shipping_state_default);
                }, 3000);
            }

            $('#shipping_state').live('change',function(){
                var address_states = $(this).val();
                main_global.checkAddressStates(address_states);

            });
        },
        checkAddressStates: function(states){
            $('.states-info').remove();

            var pid = $('.cart_item').map(function(){
                return $(this).data('pid');
            }).get().join();

            switch( states ){
                case 'QLD1':
                    console.log(pid);
                    $('#place_order').addClass('disabled');
                    $('#place_order').attr('disabled', true);
                    var states_error = '<ul class="woocommerce-info" role="info"><li><a href="https://qld.empassion.com.au/cart/?add-to-cart='+pid+'">Please click here to place an order in Queensland.</a><li></ul>';
                    //$('.shipping').addClass('error-tr');
                    //console.log('NO shipping');
                    $('<div class="states-info">'+states_error+'</div>').insertAfter('#payment');
                    console.log(states);
                    break;
                case 'NSW':
                    console.log(pid);
                    $('#place_order').addClass('disabled');
                    $('#place_order').attr('disabled', true);
                    var states_error = '<ul class="woocommerce-info" role="info"><li><a href="https://nsw.empassion.com.au/cart/?add-to-cart='+pid+'">Please click here to place an order in New South Wales.</a><li></ul>';
                    //$('.shipping').addClass('error-tr');
                    //console.log('NO shipping');
                    $('<div class="states-info">'+states_error+'</div>').insertAfter('#payment');
                    console.log(states);
                    break;
                case 'ACT':
                    console.log(pid);
                    $('#place_order').addClass('disabled');
                    $('#place_order').attr('disabled', true);
                    var states_error = '<ul class="woocommerce-info" role="info"><li><a href="https://nsw.empassion.com.au/cart/?add-to-cart='+pid+'">Please click here to place an order in Australian Capital Territory.</a><li></ul>';
                    //$('.shipping').addClass('error-tr');
                    //console.log('NO shipping');
                    $('<div class="states-info">'+states_error+'</div>').insertAfter('#payment');
                    console.log(states);
                    break;
                case 'WA1':

                    $('#place_order').addClass('disabled');
                    $('#place_order').attr('disabled', true);
                    var states_error = '<ul class="woocommerce-info" role="info"><li><a href="https://wa.empassion.com.au">Please click here to place an order in Western Australia.</a><li></ul>';
                    //$('.shipping').addClass('error-tr');
                    //console.log('NO shipping');
                    $('<div class="states-info">'+states_error+'</div>').insertAfter('#payment');
                    console.log(states);
                    break;
                case 'VIC':

                    $('#place_order').addClass('disabled');
                    $('#place_order').attr('disabled', true);
                    var states_error = '<ul class="woocommerce-info" role="info"><li><a href="https://vic.empassion.com.au/cart/?add-to-cart='+pid+'">Please click here to place an order in Victoria.</a><li></ul>';
                    //$('.shipping').addClass('error-tr');
                    //console.log('NO shipping');
                    $('<div class="states-info">'+states_error+'</div>').insertAfter('#payment');
                    console.log(states);
                    break;
                case 'TAS':

                    $('#place_order').addClass('disabled');
                    $('#place_order').attr('disabled', true);
                    var states_error = '<ul class="woocommerce-info" role="info"><li><a href="https://vic.empassion.com.au/cart/?add-to-cart='+pid+'">Please click here to place an order in Tasmania.</a><li></ul>';
                    //$('.shipping').addClass('error-tr');
                    //console.log('NO shipping');
                    $('<div class="states-info">'+states_error+'</div>').insertAfter('#payment');
                    console.log(states);
                    break;
                default:
                    $('#place_order').removeClass('disabled');
                    $('#place_order').attr('disabled', false);
                    console.log('default');
                    break;
            }
        },
        updateLinkState: function(state_id){

            state_id = state_id.toUpperCase();
            //$('.select-state').val('WA');
            $('#select-state-mobile').val( state_id );

            var state_link = $(this).attr('data-state-link');
            $('.proceed-mobile').attr('data-state-href', state_link);
        },

        selectMapDesktop: function(){
            $('.state').live('click', function(){
                $('.state').removeClass('active');
                $('#wa, #tas, #nt, #qld, #vic, #sa, #nsw, #act, #act_txt').removeClass('active');

                $(this).addClass('active');
                var state_id = $(this).attr('id');
                //console.log(state_id);

                //var parent = main_global;
                main_global.redirectStateMap(state_id);
                //parent.resetMapSelection(state_id);

            });
            $('#act_txt').live('click', function(){
                $('.state').removeClass('active');
                $('#wa, #tas, #nt, #qld, #vic, #sa, #nsw').removeClass('active');
                $('#act').addClass('active');

                //var parent = main_global;
                main_global.redirectStateMap('act');
            });
        },
        redirectStateMap: function(state_id){
            var state_link;
            switch(state_id){
                case 'qld':
                    state_link = 'empassion.com.au/home';
                    break;
                case 'wa':
                    state_link = 'empassion.com.au/home';
                    break;
                case 'nt':
                    state_link = 'empassion.com.au/home';
                    break;
                case 'nsw':
                    state_link = 'nsw.empassion.com.au';
                    break;
                case 'sa':
                    state_link = 'empassion.com.au/home';
                    break;
                case 'vic':
                    state_link = 'vic.empassion.com.au';
                    break;
                case 'tas':
                    state_link = 'vic.empassion.com.au';
                    break;
                case 'act':
                    state_link = 'nsw.empassion.com.au';
                    break;
                default:
                    state_link = 'empassion.com.au/home';
                    break;
            }
            $('.proceed-mobile').trigger('click');
            location.href = 'https://' + state_link;
        },
        tiggerStateDomainTxt: function(state_id){
            switch(state_id){
                case 'wa':
                    $('#slide-55-layer-33').trigger('click');
                    break;
                case 'qld':
                    $('#slide-55-layer-34').trigger('click');
                    break;
                case 'nt':
                    $('#slide-55-layer-37').trigger('click');
                    break;
                case 'sa':
                    $('#slide-55-layer-39').trigger('click');
                    break;
                case 'nsw':
                    $('#slide-55-layer-41').trigger('click');
                    break;
                case 'vic':
                    $('#slide-55-layer-43').trigger('click');
                    break;
                case 'act':
                    $('#slide-55-layer-45').trigger('click');
                    break;
                case 'tas':
                    $('#slide-55-layer-47').trigger('click');
                    break;
                default:
                    $('#slide-55-layer-36').trigger('click');
                break;
            }
        },
        resetMapSelection: function(state_id){

            var state_link;
            state_uppercase = state_id.toUpperCase();
            //$('.select-state').val('WA');
            $('#select-state-mobile').val( state_uppercase );

            switch(state_id){
                case 'qld':
                    state_link = 'empassion.com.au/home';
                    break;
                case 'wa':
                    state_link = 'empassion.com.au/home';
                    break;
                case 'nt':
                    state_link = 'empassion.com.au/home';
                    break;
                case 'nsw':
                    state_link = 'nsw.empassion.com.au';
                    break;
                case 'sa':
                    state_link = 'empassion.com.au/home';
                    break;
                case 'vic':
                    state_link = 'vic.empassion.com.au';
                    break;
                case 'tas':
                    state_link = 'vic.empassion.com.au';
                    break;
                case 'act':
                    state_link = 'nsw.empassion.com.au';
                    break;
                default:
                    state_link = 'empassion.com.au/home';
                    break;
            }
            $('.proceed-mobile').attr('data-state-href', state_link);

            $('#slide-55-layer-35').trigger('click');

            //var parent = main_global;
            main_global.tiggerStateDomainTxt(state_id);

            $('#slide-55-layer-26').trigger('click');
        },
        selectMapMobile: function(){
            $('#wa, #tas, #nt, #qld, #vic, #sa, #nsw, #act').live('touchstart', function(){
                $('.state').removeClass('active');
                $('#wa, #tas, #nt, #qld, #vic, #sa, #nsw, #act').removeClass('active');

                $(this).addClass('active');
                var state_id = $(this).attr('id');

                //var parent = main_global;
                main_global.redirectStateMap(state_id);

            });
            $('#act_txt').live('touchstart', function(){
                $('.state').removeClass('active');
                $('#wa, #tas, #nt, #qld, #vic, #sa, #nsw').removeClass('active');
                $('#act').addClass('active');

                //var parent = main_global;
                main_global.redirectStateMap('act');
            });
        },
        proceedState: function(){
            $('.proceed-mobile-unset').attr('data-state-href', '#');

            $('.proceed-mobile-unset').on('click', function(){
                var state_link = $(this).attr('data-state-href');
                //window.location.assign('https://'+state_link);
                location.href = 'https://'+state_link;
            });
            $('.proceed-mobile-unset').on( 'touchstart', function(){
                var state_link = $('#slide-55-layer-23').attr('data-state-href');
                //window.location.assign('https://'+state_link);
                location.href = 'https://'+state_link;
                //alert( state_link );
            });
        },
        unsetActiveMap: function(){
            $('#emp-logo-wrapper .tp-caption').live( 'click', function(){
                $('.state').removeClass('active');
                $('#wa, #tas, #nt, #qld, #vic, #sa, #nsw, #act').removeClass('active');
                $('#select-state-mobile').val('-1');
                //select your state text
                $('#slide-55-layer-36').trigger('click');
                $('#slide-55-layer-35').trigger('click');

            });
        },
        selectState: function(){
            $('.select-state').val('STATE');
            $('.select-state').find('button img').attr('src', '/wp-content/uploads/2018/07/state.png');
            $('.select-state').find('button .sel-desc').text('STATE');
            $('.select-state').find('button').attr('title', 'STATE');

            $('.select-state, #select-state-mobile').change(function(){
                $('.state').removeClass('active');
                $('#wa, #tas, #nt, #qld, #vic, #sa, #nsw, #act').removeClass('active');

                var state_val = $(this).val();
                state_val = state_val.toLowerCase();
                $('#' + state_val ).addClass('active');

                //var parent = main_global;
                main_global.redirectStateMap(state_val);

                //var selectState = $(this).find('option:selected');
                //var selectStateData = selectState.data('link');
                //$('#slide-55-layer-23').attr('data-state-href', selectStateData);

                //$('#slide-32-layer-26').trigger('click');

            });
            $('.select-state').change(function(){
                main_global.ajaxLoader('.select-state');
                $('.bootstrap-select.select-state').find('button').attr('disabled', true);
                $('.bootstrap-select.select-state').find('button').addClass('btn-disabled');
            });
        },

    }

    main_global.init();

});
