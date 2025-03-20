<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Sasindu Jayampathi">
    <title>WebXPay | Redirecting</title>
  </head>
  <body>     	  
       <form action="<?php echo e($url); ?>" id="webxpayform" method="POST" style="display: none;">
			First name: <input type="text" name="first_name" value="<?php echo e($user->name); ?>"><br>
			Last name: <input type="text" name="last_name" value="<?php echo e($user->name); ?>"><br>
			Email: <input type="text" name="email" value="<?php echo e($user->email); ?>"><br>
			Contact Number: <input type="text" name="contact_number" value="<?php echo e($user->phone); ?>"><br>
			Address Line 1: <input type="text" name="address_line_one" value="Colombo"><br>
			Address Line 2: <input type="text" name="address_line_two" value="Colombo"><br>
			City: <input type="text" name="city" value="Colombo"><br>
			State: <input type="text" name="state" value="Western"><br>
			Zip/Postal Code: <input type="text" name="postal_code" value="10300"><br>
			Country: <input type="text" name="country" value="Sri Lanka"><br>
			currency: <input type="text" name="process_currency" value="LKR"><br>
			CMS : <input type="text" name="cms" value="PHP">
			custom: <input type="text" name="custom_fields" value="<?php echo e($custom_fields); ?>">
			Mechanism: <input type="text" name="enc_method" value="JCs3J+6oSz4V0LgE0zi/Bg==">
			<br/>		   
			<!-- POST parameters -->
			<input type="hidden" name="secret_key" value="<?php echo e($secret_key); ?>" >  
			<input type="hidden" name="payment" value="<?php echo e($payment); ?>" >                         
			
        </form>      
  </body>
</html>
<script>
    document.getElementById("webxpayform").submit();
</script><?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\extras\plugins\webxpay\resources\views/payment.blade.php ENDPATH**/ ?>