<form action="<?php echo URL; ?>hello/verification" method="post" onsubmit="return confirm('Do you really want to submit the form?');">
	<center><input class="" name="otp" id="name" placeholder="Enter OTP"><br><br>
	<button type="submit" class="btn-info" value="submit" name="save">Submit</button>
	<button type="submit" class="btn-info" value="submit" name="resend">Resend</button></center>
</form>