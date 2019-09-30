<?php
/**
 * @package    iitpConnect.Site
 *
 * @copyright  Copyright (C) 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 defined('_EXEC') or die;

 $mail = new PHPMailer(true);                              // Passing `true` enables exceptions

 $mail->SMTPDebug = 2;                                 // Enable verbose debug output
 $mail->isSMTP();                                      // Set mailer to use SMTP
 $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
 $mail->SMTPAuth = true;                               // Enable SMTP authentication
 $mail->Username = 'iitpcabshare@gmail.com';            // SMTP username
 $mail->Password = 'iitpcabshare@anu1601cs';                  // SMTP password
 $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
 $mail->Port = 587;                                    // TCP port to connect to

 //Recipients
 $mail->setFrom('noreply@gmail.com', 'iitpConnect');
 $mail->addAddress('anuragvns1999@gmail.com', 'Anurag');                     // Add a recipient

 //Content
 $mail->isHTML(true);                                  // Set email format to HTML
 $mail->Subject = 'Reset link to your iitpConnect account.';
 $mail->Body    = 'asdasdad';

 $mail->AltBody = 'Thanks';

 if($mail->send())
 {
   return true;
 }
