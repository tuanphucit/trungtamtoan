<?php
include "class.phpmailer.php";
include "class.smtp.php";

class TrungTamToanMail {
	public static function sendMail($fromAccount, $toAccount, $ccAccounts = NULL, $subject, $htmlcontent, $basiccontent = null) {

		$mail = new PHPMailer();
		$mail->IsSMTP(); // set mailer to use SMTP
		$mail->Host = "smtp.gmail.com"; // specify main and backup server
		$mail->Port = 465; // set the port to use
		$mail->SMTPAuth = true; // turn on SMTP authentication
		$mail->SMTPSecure = 'ssl';
		$mail->Username = "admin@trungtamtoan.com"; // your SMTP username or your gmail username
		$mail->Password = "admin2012"; // your SMTP password or your gmail password
		$from = "admin@trungtamtoan.com"; // Reply to this email
		$to = $toAccount; // Recipients email ID
		$name = $fromAccount; // Recipient's name
		$mail->From = $from;
		$mail->FromName = $fromAccount; // Name to indicate where the email came from when the recepient received
		$mail->AddAddress($to, $name);
		if($ccAccounts!=NULL){
			foreach($ccAccounts as $cc){
				$ccAddress = $cc;
				$mail->AddCC($ccAddress,$cc);	
			}
		}
		$mail->AddReplyTo($from, $fromAccount);
		$mail->WordWrap = 100; // set word wrap
		$mail->IsHTML(true); // send as HTML
		$mail->Subject = "[TrungTamToan.Com]".$subject;
		$mail->Body = $htmlcontent; //HTML Body
		$mail->AltBody = $basiccontent; //Text Body
		//$mail->SMTPDebug = 2;
		if (!$mail->Send()) {
			return false;
		} else {
			return true;
		}
	}
}
?>
