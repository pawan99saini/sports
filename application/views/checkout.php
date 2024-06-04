<section class="baanner-inner">
    <div class="container">
        <h1>Checkout</h1>
    </div>
</section>

<section class="order-req bg-dark">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<form method="POST" action="<?= base_url(); ?>home/checkout_process" class="checkout" onsubmit="return false;">
					<h2>Billing Information</h2>

					<div class="messageBox"></div>
					<div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fname">First name</label>
                                <input type="text" class="form-control" name="fname" >
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fname">Last name</label>
                                <input type="text" class="form-control" name="lname" >
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="email" class="form-control" name="email" >
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="fname">Phone</label>
                                <input type="text" class="form-control" name="phone" >
                            </div>
                        </div>
                     </div>

                     <input type="hidden" class="form-control" name="pkg_id" value="<?= $pkg_code; ?>" >
				</form>
			</div>

			<div class="col-md-4">
				<div class="cart-box cart-combo">
	                <div class="heading-sub">
	                    <h2><i class="fa fa-shopping-basket"></i> Your Bucket</h2>
	                </div>
	                
	                <div class="cart-total">
	                    <h4>Total Cost
	                        <span class="cost">$<label><?= number_format($package_price, 2); ?></label></span>
	                    </h4>
	                </div>

	                <div class="item-basket-box">
	                	<div>
						    <p class="item-detail-cart"><?= $package_name; ?></p>
						    <p class="item-price-cart">$<label><?= number_format($package_price, 2); ?> x 1</p>
					    </div>
	                </div>

	                <div class="form-group">
	                	<button type="button" class="btn btn-curved processCheckout">Proceed To Checkout</button>
	                	<div class="loader-sub" id="login-load">
                            <div class="lds-ellipsis">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
	            </div>
			</div>
		</div>
	</div>	
</section>

<?php 
    $data = array(
      //'merchant_email' => 'sb-e9zsa6972097@business.example.com',
      'merchant_email' => 'dsoesports@gmail.com',
      'currency_code'  => 'USD',
      'paypal_mode'  => false,
    );
    define( 'SSL_URL', 'https://www.paypal.com/cgi-bin/webscr' );
    define( 'SSL_SAND_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr' );
    
    $action = '';
    $action = ($data['paypal_mode']) ? SSL_SAND_URL : SSL_URL;
    $form = '';
    $form .= '<form class="checkout_paypal" action="' . $action . '" method="post">';
    $form .= '<input type="hidden" name="cmd" value="_xclick">';
    $form .= '<input type="hidden" name="business" value="' . $data['merchant_email'] . '" />';
    $form .= '<input type="hidden" name="notify_url" value="" />';
    $form .= '<input type="hidden" class="cancel_return" name="cancel_return" value="" />';
    $form .= '<input type="hidden" class="return" name="return" value="" />';
    $form .= '<input type="hidden" name="no_shipping" value="1" />';
    $form .= '<input type="hidden" name="currency_code" value="' . $data['currency_code'] . '" />';
    $form .= '<input type="hidden" name="item_name" value="'.$package_name.'" />';
    $form .= '<input type="hidden" name="item_number" value="basic_326">';
    $form .= '<input type="hidden" id="amount" name="amount" value="'.number_format($package_price, 2).'" />';
    $form .= '</form>';
    echo $form;
?>