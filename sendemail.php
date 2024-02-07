<!-- <?php

// Define some constants
define( "RECIPIENT_NAME", "Suvadip Majhi" );
define( "RECIPIENT_EMAIL", "Suvadip012@gmail.com");

// Read the form values
$success = false;
$userName = isset( $_POST['username'] ) ? preg_replace( "/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['username'] ) : "";
$senderEmail = isset( $_POST['email'] ) ? preg_replace( "/[^\.\-\' a-zA-Z0-9]/", "", $_POST['email'] ) : "";
$senderPhone = isset( $_POST['phone'] ) ? preg_replace( "/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['phone'] ) : "";
$userSubject = isset( $_POST['subject'] ) ? preg_replace( "/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['subject'] ) : "";
$message = isset( $_POST['message'] ) ? preg_replace( "/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $_POST['message'] ) : "";

// If all values exist, send the email
if ( $userName && $senderEmail && $senderPhone && $userSubject && $message) {
  $recipient = RECIPIENT_NAME . " <" . RECIPIENT_EMAIL . ">";
  $headers = "From: " . $userName . "";
  $msgBody = " Name: ". $userName .  " Email: ". $senderEmail . " Phone: ". $senderPhone . " Subject: ". $userSubject . " Message: " . $message . "";
  $success = mail( $recipient, $headers, $msgBody );

  //Set Location After Successsfull Submission
  header('Location: contact.html?message=Successfull');
}

else{
	//Set Location After Unsuccesssfull Submission
  	header('Location: contact.html?message=Failed');	
}

?> -->


<?php

// Define some constants
define("RECIPIENT_NAME", "Suvadip Majhi");
define("RECIPIENT_EMAIL", "Suvadip012@gmail.com");

// Read the form values
$success = false;
$userName = isset($_POST['username']) ? filter_var($_POST['username'], FILTER_SANITIZE_STRING) : "";
$senderEmail = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : "";
$senderPhone = isset($_POST['phone']) ? filter_var($_POST['phone'], FILTER_SANITIZE_STRING) : "";
$userSubject = isset($_POST['subject']) ? filter_var($_POST['subject'], FILTER_SANITIZE_STRING) : "";
$message = isset($_POST['message']) ? filter_var($_POST['message'], FILTER_SANITIZE_STRING) : "";

// Validate email format
if (!filter_var($senderEmail, FILTER_VALIDATE_EMAIL)) {
    header('Location: contact.html?message=InvalidEmail');
    exit();
}

// If all values exist, send the email
if ($userName && $senderEmail && $senderPhone && $userSubject && $message) {
    $recipient = RECIPIENT_NAME . " <" . RECIPIENT_EMAIL . ">";
    $headers = "From: $userName <$senderEmail>\r\n";
    $headers .= "Reply-To: $userName <$senderEmail>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";
    $msgBody = "Name: $userName\nEmail: $senderEmail\nPhone: $senderPhone\nSubject: $userSubject\nMessage: $message";
    $success = mail($recipient, $userSubject, $msgBody, $headers);

    if ($success) {
        // Redirect to success page
        header('Location: contact.html?message=Success');
    } else {
        // Redirect to error page
        header('Location: contact.html?message=FailedToSend');
    }
} else {
    // Redirect to error page
    header('Location: contact.html?message=IncompleteForm');
}

?>