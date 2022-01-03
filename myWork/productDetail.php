<?php

include_once 'mysql-adapter.php';

$object = new MySqlAdapter();
$con = $object->get_connection();

$url = $_SERVER['REQUEST_URI'];
$id = array_slice(explode('/', $url), -1)[0];


?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <!-- Bootstrap CSS -->

</head>
<body>


<?php


$id = ( isset($id ) && !empty($id ) ) ? $id : 0;
if($id > 0) {

$detail = R::load('products', $id);
?>
    <div class="container">
    <div class="card">
        <div class="container-fliud">
            <div class="wrapper row">
                <div class="preview col-md-6">

                    <div class="preview-pic tab-content">
                        <div class="tab-pane active" id="pic-1"><img src="<?= $detail->image ?>" /></div>
                    </div>

                </div>
                <div class="details col-md-6">
                    <h3 class="product-title"><?= $detail->title; ?></h3>

                    <p class="product-description"><?= $detail->description; ?></p>
                    <h4 class="price">current price: <span>$ <?= $detail->price; ?></span></h4>

                    <div class="action">
                        <!-- Trigger the modal with a button -->
                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Buy Now</button>



                        <!-- Modal -->
                        <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="col-xs-12 col-md-4">
                                    <div class="panel panel-default" style="width: 500%;">
                                        <div class="panel-body">
                                            <form action="/myWork/order.php" method="post" name="cardpayment" id="payment-form">

                                                <input type="hidden" name="stripeToken" id="stripeToken">
                                                <input type="hidden" name="order_id" value="<?= $detail->id ?>">
                                                <input type="hidden" name="price" value="<?= $detail->price ?>">

                                                <div class="form-group">
                                                    <label class="form-label" for="name">Card Holder Name</label>
                                                    <input name="holdername" id="name" class="form-input" type="text"  required />
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label" for="email">Email</label>
                                                    <input name="email" id="email" class="form-input" type="email" required />
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label" for="card">Card Number</label>
                                                    <input name="cardnumber" id="card" class="form-input" type="text" maxlength="16" data-stripe="number" required />
                                                </div>
                                                <div class="form-group2">
                                                    <label class="form-label" for="password">Expiry Month / Year & CVV</label>
                                                    <select name="month" id="month" class="form-input2" data-stripe="exp_month">
                                                        <option value="01">01</option>
                                                        <option value="02">02</option>
                                                        <option value="03">03</option>
                                                        <option value="04">04</option>
                                                        <option value="05">05</option>
                                                        <option value="06">06</option>
                                                        <option value="07">07</option>
                                                        <option value="08">08</option>
                                                        <option value="09">09</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                    </select>
                                                    <select name="year" id="year" class="form-input2" data-stripe="exp_year">
                                                        <option value="19">2019</option>
                                                        <option value="20">2020</option>
                                                        <option value="21">2021</option>
                                                        <option value="22">2022</option>
                                                        <option value="23">2023</option>
                                                        <option value="24">2024</option>
                                                        <option value="25">2025</option>
                                                        <option value="26">2026</option>
                                                        <option value="27">2027</option>
                                                        <option value="28">2028</option>
                                                        <option value="29">2029</option>
                                                        <option value="30">2030</option>
                                                    </select>
                                                    <input name="cvv" id="cvv" class="form-input2" type="text" placeholder="CVV" data-stripe="cvc" required />
                                                </div>
                                                <div class="form-group">
                                                    <div class="payment-errors"></div>
                                                </div>
                                                <div class="button-style">
                                                    <button class="button login submit">Paynow </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
</body>
</html>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    Stripe.setPublishableKey('pk_test_tVemoj1bBSyWgrRE1YnRSM6i');
    $(function() {
        var $form = $('#payment-form');
        $form.submit(function(event) {
            // Disable the submit button to prevent repeated clicks:
            $form.find('.submit').prop('disabled', true);

            // Request a token from Stripe:
            Stripe.card.createToken($form, stripeResponseHandler);

            // Prevent the form from being submitted:
            return false;
        });
    });
    function stripeResponseHandler(status, response) {
        // Grab the form:
        var $form = $('#payment-form');

        if (response.error) { // Problem!
            // Show the errors on the form:
            $form.find('.payment-errors').text(response.error.message);
            $form.find('.submit').prop('disabled', false); // Re-enable submission
        }else { // Token was created!
            // Get the token ID:
            var token = response.id;
            // Insert the token ID into the form so it gets submitted to the server:
            $('#stripeToken').val(token);
            // Submit the form:

            $form.get(0).submit();
        }
    };
</script>

