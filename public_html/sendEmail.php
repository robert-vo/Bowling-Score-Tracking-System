<?php
function sendEmailTo($email, $firstName, $lastName) {
    $url = 'https://api.sendgrid.com/';
    $user = 'azure_14ef7c1218f26530d7a8a25a9f15aae4@azure.com';
    $pass = 'cosc3380';
    $message = "$firstName $lastName has requested to join your team!";

    $params = array(
        'api_user' => $user,
        'api_key' => $pass,
        'to' => $email,
        'subject' => 'Bowling Score Tracking System',
        'html' => $message,
        'from' => 'noreply@bowling-score-tracking-system.com'
    );
    $request = $url.'api/mail.send.json';
    $session = curl_init($request);
    curl_setopt ($session, CURLOPT_POST, true);
    curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
    curl_setopt($session, CURLOPT_HEADER, false);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($session);
    if (curl_errno($session)) { echo 'Curl error: ' . curl_error($session); }
    curl_close($session);
    print_r($response);

}
?>