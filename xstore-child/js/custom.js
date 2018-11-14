var pattern = new RegExp('\\b[p]*(ost)*\\.*\\s*[o|0]*(ffice)*\\.*\\s*b[o|0]x\\b', 'i');
jQuery(function ($) {
    var isPOB = false,
        shipping_postcode = false,
        shipping_city = false,
        shipping_address_1 = false,
        shipping_address_2 = false,
        billing_address_1 = false,
        billing_postcode = false,
        billing_city = false,
        billing_address_2 = false;
    $('#shipping_method_0_wooship_0').attr('disabled', 'disabled');
    $('#billing_address_1, #billing_address_2, #billing_city, #billing_postcode').on('change', function () {
        shipping_postcode = checkPOX($('#shipping_postcode').val());
        shipping_city = checkPOX($('#shipping_city').val());
        shipping_address_1 = checkPOX($('#shipping_address_1').val());
        shipping_address_2 = checkPOX($('#shipping_address_2').val());
        billing_address_1 = checkPOX($('#billing_address_1').val());
        billing_address_2 = checkPOX($('#billing_address_2').val());
        billing_city = checkPOX($('#billing_city').val());
        billing_postcode = checkPOX($('#billing_postcode').val())

        if ((billing_address_1 || billing_address_2 || billing_city || billing_postcode) || (shipping_address_1 || shipping_address_2 || shipping_city || shipping_postcode)) {
            $('#shipping_method_0_wooship_0').attr('checked', 'checked').removeAttr('disabled').closest('li').show();
            $('#shipping_method_0_flat_rate3, #shipping_method_0_flat_rate4').closest('li').hide();
        } else {
            $('#shipping_method_0_wooship_0').attr('disabled', 'disabled').removeAttr('checked').closest('li').hide();
            $('#shipping_method_0_flat_rate3, #shipping_method_0_flat_rate4').closest('li').show();
            /*$('#shipping_method_0_flat_rate4').attr('checked','checked');*/
        }
    });

    $('form.checkout').ajaxComplete(function (event, xhr, settings) {
        var data = JSON.parse(xhr.responseText);
        if (data.fragments.is_pobox) {
            $('#shipping_method_0_wooship_0').attr('checked', 'checked').removeAttr('disabled').closest('li').show();
            $('#shipping_method_0_flat_rate3, #shipping_method_0_flat_rate4').closest('li').hide();
        } else {
            $('#shipping_method_0_wooship_0').attr('disabled', 'disabled').removeAttr('checked').closest('li').hide();
            $('#shipping_method_0_flat_rate3, #shipping_method_0_flat_rate4').closest('li').show();
            /*$('#shipping_method_0_flat_rate4').attr('checked','checked');*/
        }
    });

});

function checkPOX(address) {
    var varisPOB = false;
    var pattern = /\bP(ost|ostal)?([ \.]*(O|0)(ffice)?)?([ \.]*Box)?([ \.]*(ob))?\b/i;
    if (address) {
        varisPOB = pattern.test(address);
    }
    return varisPOB;

}