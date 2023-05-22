/**
 * epicjungle.js
 *
 * Handles behaviour of the theme
 */
 ( function( $, window ) {
    'use strict';

    if( typeof $.blockUI !== "undefined" ) {
        $.blockUI.defaults.message                      = null;
        $.blockUI.defaults.overlayCSS.background        = '#fff url(' + epicjungle_options.ajax_loader_url + ') no-repeat center';
        $.blockUI.defaults.overlayCSS.backgroundSize    = '16px 16px';
        $.blockUI.defaults.overlayCSS.opacity           = 0.6;
    }

    $( 'body' ).on( 'adding_to_cart', function( e, $btn, data){
        $btn.closest( '.product' ).block();
    });

    $( 'body' ).on( 'added_to_cart', function(){
        $( '.product' ).unblock();
    });

    $(document).ready(function(){
        $(".apply_coupon").click(function(){
            $("form.checkout_coupon").hide();
        });
        
        $(".epicjungleshowcoupon").click(function(){
            $("form.checkout_coupon").show();
        });
    });

    /*===================================================================================*/
    /*  Deal Countdown timer
    /*===================================================================================*/

    $( '.deal-countdown-timer' ).each( function() {
        var deal_countdown_text = epicjungle_options.deal_countdown_text;
        // set the date we're counting down to
        var deal_time_diff = $(this).children('.deal-time-diff').text();
        var countdown_output = $(this).children('.deal-countdown');
        var target_date = ( new Date().getTime() ) + ( deal_time_diff * 1000 );

        // variables for time units
        var days, hours, minutes, seconds;

        // update the tag with id "countdown" every 1 second
        setInterval( function () {

            // find the amount of "seconds" between now and target
            var current_date = new Date().getTime();
            var seconds_left = (target_date - current_date) / 1000;

            // do some time calculations
            days = parseInt(seconds_left / 86400);
            seconds_left = seconds_left % 86400;

            hours = parseInt(seconds_left / 3600);
            seconds_left = seconds_left % 3600;

            minutes = parseInt(seconds_left / 60);
            seconds = parseInt(seconds_left % 60);

            // format countdown string + set tag value
            countdown_output.html( '<span data-value="' + days + '" class="days cs-countdown-days mr-grid-gutter"><span class="value cs-countdown-value">' + days +  '</span><span class="cs-countdown-label opacity-70 font-size-sm">' + deal_countdown_text.days_text + '</span></span><span class="hours cs-countdown-hours mr-grid-gutter"><span class="value cs-countdown-value">' + hours + '</span><span class="cs-countdown-label opacity-70 font-size-sm">' + deal_countdown_text.hours_text + '</span></span><span class="minutes cs-countdown-minutes mr-grid-gutter"><span class="value cs-countdown-value">'
            + minutes + '</span><span class="cs-countdown-label opacity-70 font-size-sm">' + deal_countdown_text.mins_text + '</span></span><span class="seconds cs-countdown-seconds"><span class="value cs-countdown-value">' + seconds + '</span><span class="cs-countdown-label opacity-70 font-size-sm">' + deal_countdown_text.secs_text + '</span></span>' );

        }, 1000 );
    });

    window.onload = function () {
        var preloader = document.querySelector('.cs-page-loading');
        if ( preloader !== null ) {
            preloader.classList.remove('active');
            setTimeout(function () {
                preloader.remove();
            }, 2000);
        }
    };


} )( jQuery, window );


/**
 * Auto update cart after change quantity
 * 
 * @since 1.0.0
 */
var timeout;
jQuery( function( $ ){
		$('.woocommerce').on('change', 'input.qty', function(){
	if ( timeout !== undefined ){
			clearTimeout( timeout );
}
	timeout = setTimeout(function(){
		$("[name='update_cart']").trigger("click");
	}, 300 );
	});
} );

/**
 * Buy now button single product
 * 
 * @since 1.3.0
 */
 jQuery(function($){
    $("#epicjungle_buy_now").click(function() {

        $("#preloader-buy-now-button").removeClass("d-none");
        $("#span-buy-now-button").addClass("d-none");
        $("#icon-buy-now-button").addClass("d-none");
    });
});


/**
 * Functions for avatar section
 * 
 * @since 1.3.0
 */
 jQuery(function($){

    /**
     * Preloader button send avatar
     */
    $("#inputSendAvatar").click(function() {

        $("#preloader-send-avatar").removeClass("d-none");
        $("#span-send-avatar").addClass("d-none");
    });

    /**
     * Disable send button if empty archive
     */
    $('#upload-file-avatar').change(function(e) {
        if($('#upload-file-avatar').val() == '') {
            $('#inputSendAvatar').attr('disabled', true );
        } 
        else {
          $('#inputSendAvatar').attr('disabled', false );
        }
    });
});


/**
 * Add to cart in AJAX
 * 
 * @since 1.3.0
 */
jQuery(function($){
    $('#epicjungle-add-to-cart').on('click', function(e){
    e.preventDefault();
    $thisbutton = $(this),
        $form = $thisbutton.closest('form.cart'),
        id = $thisbutton.val(),
        product_qty = $form.find('input[name=quantity]').val() || 1,
        product_id = $form.find('input[name=product_id]').val() || id,
        variation_id = $form.find('input[name=variation_id]').val() || 0;

    var data = {
        action: 'epicjungle_ajax_add_to_cart',
        product_id: product_id,
        product_sku: '',
        quantity: product_qty,
        variation_id: variation_id,
    };
    $.ajax({
        type: 'post',
        url: wc_add_to_cart_params.ajax_url,
        data: data,
        beforeSend: function (response) {
            $("#span-add-to-cart").addClass('d-none');
            $("#preloader-add-to-cart").removeClass('d-none');
            $('#epicjungle_buy_now').attr('disabled', true );
        },
        complete: function (response) {
            $("#epicjungle-add-to-cart").addClass('added').removeClass('d-none');
            $("#preloader-add-to-cart").addClass('d-none');
            $('#epicjungle_buy_now').attr('disabled', false );
            $("#shoppingCart").addClass('show');
        }, 
        success: function (response) {
            $("#span-add-to-cart").removeClass('d-none');
            $('#epicjungle_buy_now').attr('disabled', false );

            if (response.error & response.product_url) {
                window.location = response.product_url;
                return;
            } else { 
                $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
            }

            setTimeout( function() {
                $("#shoppingCart").removeClass('show');
            }, 5000);
        },
    });
});
});

/**
 * Input masks
 * 
 * @since 1.6.0
 */
jQuery(function($) {
	$("#wscp-calc_shipping_postcode_field").mask("99999-999");
    $("#wscp-postcode").mask("99999-999");
    $("#billing_postcode").mask("99999-999");
    $("#shipping_postcode").mask("99999-999");
    $("#billing_phone").mask("(99) 99999-9999");
});

/**
 * Auto complete data after enter postcode
 * 
 * @since 1.6.0
 */
 jQuery((function(n) {
    ({
        init: function() {
            var i = this;
            n(document.body).find("#billing_postcode").val() && !n(document.body).find("#billing_address_1").val() && this.autofill("billing"), n(document.body).find("#shipping_postcode").val() && !n(document.body).find("#shipping_address_1").val() && this.autofill("shipping"), n(document.body).find("#billing_postcode").on("keyup", (function(n) {
                return i.autofill("billing")
            })), n(document.body).find("#shipping_postcode").on("keyup", (function(n) {
                return i.autofill("shipping")
            }))
        },
        block: function() {
            n("form.checkout").block({
                message: null,
                overlayCSS: {
                    background: "#fff",
                    opacity: .6
                }
            })
        },
        unblock: function() {
            n("form.checkout").unblock()
        },
        autofill: function(i, o) {
            var l = this;
            o = o || !1;
            var t = n("#" + i + "_country").val();
            if (!n("#" + i + "_country").length || "BR" === t) {
                var e = n("#" + i + "_postcode"),
                    c = e.val().replace(/\D/g, "");
                c && 8 === c.length && (e.blur(), this.block(), n.ajax({
                    type: "GET",
                    url: "https://brasilapi.com.br/api/cep/v1/".concat(c),
                    dataType: "json",
                    contentType: "application/json",
                    success: function(n) {
                        if (n.state && (l.fillFields(i, n), o)) {
                            var t = "billing" === i ? "shipping" : "billing";
                            l.fillFields(t, n)
                        }
                    },
                    error: function(n) {
                        console.log(n)
                    },
                    complete: function() {
                        l.unblock()
                    }
                }))
            }
        },
        fillFields: function(i, o) {
            n("#" + i + "_address_1").val(o.street).change(), n("#" + i + "_neighborhood").length ? n("#" + i + "_neighborhood").val(o.neighborhood).change() : n("#" + i + "_address_2").val(o.neighborhood).change(), n("#" + i + "_city").val(o.city).change(), n("#" + i + "_state").val(o.state).trigger("change").change()
        }
    }).init()
}));


/**
 * Check if variation is selected on product page
 * 
 * @since 1.7.0
 */
jQuery(function($) {
    $('#epicjungle_buy_now').attr('disabled', true );
    $('#epicjungle-add-to-cart').attr('disabled', true );

    $('input.variation_id').change(function(e) {
        if($('input.variation_id').val() != '') {
            $('#epicjungle_buy_now').attr('disabled', false );
            $('#epicjungle-add-to-cart').attr('disabled', false );
        }
        else {
          $('#epicjungle_buy_now').attr('disabled', true );
          $('#epicjungle-add-to-cart').attr('disabled', true );
        }
    });
});


/**
 * Free shipping with IP location
 * 
 * @since 1.0.0
 */
function convertDate(e) {
	var t, o = new Date(e);
	return [(t = o.getDate(), t < 10 ? "0" + t : t)].join("/")
}

function getMesExtenso(e) {
	var t = new Array(12);
	return t[0] = "janeiro", t[1] = "fevereiro", t[2] = "março", t[3] = "abril", t[4] = "maio", t[5] = "junho", t[6] = "julho", t[7] = "agosto", t[8] = "setembro", t[9] = "outubro", t[10] = "novembro", t[11] = "dezembro", t[e]
}
jQuery(document).ready(function(e) {
	var t = new Date,
		o = t.setDate(t.getDate() + 5),
		n = t.setDate(t.getDate() + 2),
		r = getMesExtenso(t.getMonth());
	if (convertDate(o) > convertDate(n)) var a = "<strong>" + convertDate(n) + "</strong> e <strong>" + convertDate(o) + " de " + r + "</strong>";
	else {
		if (null == (s = getMesExtenso(t.getMonth() + 1))) var s = getMesExtenso(t.getMonth() - 11);
		a = "<strong>" + convertDate(n) + " de " + r + "</strong> e <strong>" + convertDate(o) + " de " + s + "</strong>"
	}
	e.getJSON("https://wtfismyip.com/json", function(t) {
		var o = (t = t.YourFuckingLocation).replace(", Brazil", "");
		e(".custom-address").html("<font color='#09bf00'><b>Frete Grátis</b></font> para <strong><font color='#09bf00'>" + o + " e Região</font></strong>"), e(".shipping-estimated").html("Entrega estimada entre " + a + "."), e(".shipping-preview-loading").hide()
	})
});


/**
 * Replace select input review in page product
 * 
 * @since 1.7.0
 */
jQuery(function($) {
    $(".star-1").click(function() {
        $("#star-rating").val("1");
    });

    $(".star-2").click(function() {
        $("#star-rating").val("2");
    });

    $(".star-3").click(function() {
        $("#star-rating").val("3");
    });

    $(".star-3").click(function() {
        $("#star-rating").val("3");
    });

    $(".star-4").click(function() {
        $("#star-rating").val("4");
    });

    $(".star-5").click(function() {
        $("#star-rating").val("5");
    });
});


/**
 * Change quantity in product page and cart
 * 
 * @since 1.7.0
 */
jQuery(function($) {
    var counter = 0;
   
    $("#qtd-plus").click(function(){
        counter++;
        $("#quantity-input").val(counter);
    });
    
    $("#qtd-minus").click(function(){
        if($('#quantity-input').val() > '1') {
            counter--;
            $("#quantity-input").val(counter);
        }
        
    });

    // allow only numbers
    $("#quantity-input").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
});



/**
 * Change quantity in mini cart
 * 
 * @since 1.7.0
 */

