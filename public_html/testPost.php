<form action="searchForBalls.php" method="post">
    What color balls are you looking for? Enter here:  <input type="text" name="color" /><br />
    <input type="submit" name="submit" value="Submit me!" />
</form>

<?php

$url = 'https://api.sendgrid.com/';
$user = 'azure_14ef7c1218f26530d7a8a25a9f15aae4@azure.com';
$pass = 'cosc3380';

echo $url;
echo $user;
echo $pass;

$params = array(
    'api_user' => $user,
    'api_key' => $pass,
    'to' => 'rvo@uh.edu',
    'subject' => 'testing from azure',
    'html' => 'testing from azure',
    'text' => 'testing from azure',
    'from' => 'noreply@smtp.sendgrid.net'
);

$request = $url.'api/mail.send.json';

// Generate curl request
$session = curl_init($request);

// Tell curl to use HTTP POST
curl_setopt ($session, CURLOPT_POST, true);

// Tell curl that this is the body of the POST
curl_setopt ($session, CURLOPT_POSTFIELDS, $params);

// Tell curl not to return headers, but do return the response
curl_setopt($session, CURLOPT_HEADER, false);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);

// obtain response
$response = curl_exec($session);

if (curl_errno($session)) { echo 'Curl error: ' . curl_error($session); }

curl_close($session);

// print everything out
print_r($response);