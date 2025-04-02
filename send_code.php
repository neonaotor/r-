<?php
if (isset($_POST['email'])) {
  $code = rand(100000, 999999);
  $to = $_POST['email'];
  $subject = "Your EL MUERTE Verification Code";
  $message = "Your code is: " . $code;
  $headers = "From: noreply@deineseite.de";

  mail($to, $subject, $message, $headers);
  echo "sent";
}
?>
