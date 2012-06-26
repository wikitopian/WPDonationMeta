<html>
	<head>
		<title>
			Donate now with PayPal...
		</title>
	</head>
	<body>
		<h2>Your Support is Appreciated</h2>
		<br />
		<form id="wpdm_donate" name="wpdm_donate" action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cancel_return" value="<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>?wpdm_paypal_success=true" />
            <input type="hidden" name="cmd" value="_donations">
            <input type="hidden" name="business" value="<?php echo get_option('admin_email'); ?>">
            <input type="hidden" name="lc" value="US">
            <input type="hidden" name="item_name" value="<?php echo get_option('blogname'); ?> Donation">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="no_note" value="0">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="return" value="<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>?wpdm_paypal_cancel=true" />
            <input type="hidden" name="rm" value="2" />
            <fieldset>
            <legend>Please Enter Your Information Below</legend>
            <label for="wpdm_name_full">Name:</label>
            <input id="wpdm_name_full" name="wpdm_name_full"
                type="text" placeholder="Your Name"
                required maxlength="100">

            <label for="wpdm_address">Address:</label>
            <input id="wpdm_address" name="wpdm_address"
                type="text" placeholder="Full Mailing Address"
                required maxlength="100">

            <label for="wpdm_city">City:</label>
            <input id="wpdm_city" name="wpdm_city"
                type="text" placeholder="City"
                required maxlength="100">

            <label for="wpdm_state">State:</label>
            <input id="wpdm_state" name="wpdm_state"
                type="text" placeholder="State"
                required maxlength="100">

            <label for="wpdm_zip">Zip Code:</label>
            <input id="wpdm_zip" name="wpdm_zip"
                type="text" placeholder="5 Digit Zip"
                required maxlength="100">

            <label for="wpdm_occupation">Occupation:</label>
            <input id="wpdm_occupation" name="wpdm_occupation"
                type="text" placeholder="Your Occupation"
                required maxlength="100">

            <label for="wpdm_telephone">Telephone:</label>
            <input id="wpdm_telephone" name="wpdm_telephone"
                type="text" placeholder="10 Digit Phone Number"
                required maxlength="100">

            <label for="amount">Desired Contribution ($2,300 limit):</label>
            <input id="amount" name="amount"
                type="text" placeholder="Contribution Amount"
                required maxlength="100">

            </fieldset>
			<input type="button" name="wpdm_submit" value="Continue to PayPal..." />
		</form>
	</body>
</html>
