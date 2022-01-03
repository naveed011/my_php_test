Stripe.setPublishableKey('pk_test_tVemoj1bBSyWgrRE1YnRSM6i');

function stripePay(event) {
    event.preventDefault();
    if(validateForm() == true) {
        $('#payNow').attr('disabled', 'disabled');
        $('#payNow').val('Payment Processing....');
        Stripe.createToken({
            number:$('#cardNumber').val(),
            cvc:$('#cardCVC').val(),
            exp_month : $('#cardExpMonth').val(),
            exp_year : $('#cardExpYear').val()
        }, stripeResponseHandler);
        return false;
    }
}

function stripeResponseHandler(status, response) {
    console.log(response);
    return;
    if(response.error) {
        $('#payNow').attr('disabled', false);
        $('#message').html(response.error.message).show();
    } else {
        var stripeToken = response['id'];
        $('#paymentForm').append("<input type='hidden' name='stripeToken' value='" + stripeToken + "' />");

        $('#paymentForm').submit();
    }
}