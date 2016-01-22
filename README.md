# Plivo Send SMS API

## How to send SMS
This repo contains sms.php file, you simply need to include that file and use below code fo example.
```
$sms = new sms($authID, $authToken, $phoneNumber);
$sms->send('number', 'message'); // Example $sms-send('+919876543234', 'Hey, how are you?');
```

