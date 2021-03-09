<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

</head>
<body width="100%" bgcolor="#fcf3f0" style="margin: 0; mso-line-height-rule: exactly;">
    <center style="width: 100%; background: #fcf3f0;padding: 20px;">
<table align="center" border="1" cellpadding="0" cellspacing="0" width="600" style="border:none;background: #ffffff;padding: 21px;">
 <tr>
  <td style="border: none;border-bottom: 1px solid grey;">
  <h2 style="color: #6a6060;">Hello,&nbsp; {{ $name }}</h2>
  </td>
 </tr>
 <tr>
 <td>
 </td>		
 </tr>
 <tr>
 <td style="border: none;">
 <p style="font-size: 16px;color: #590f66;">Thank you for registering at bizcybercert.us</p>
 </td>		
 </tr>
 <tr>
  <td style="border: none;">
  <p style="font-size: 16px;color: #590f66;"> To complete your registration, 
  please click on the link below to confirm and activate your account. If you 
  decide to purchase a certification later, just log in and your can make the 
  purchase from your dashboard. </p><p style="font-size: 16px;"><a href="{{ $content }}" style="color: #FF5722;">{{ $content }}</a></p>
  </td>
 </tr>

</table>
</center>
</body>
</html>

