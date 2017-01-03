<?php
$access_token = 'PN1T8nvVqM8SiDBpr6RX/GtlLoHYFQQ6P/dml+03M1ZMtB3Xw8g1aLJvOlXNAB4A0pUNrDMJhAcwfhEwiJdCHwzd0QCv/qwldt88hndvWQ+Gm3+yYo+bZKYxAaqdDjmeYWktBxk94LgiUfHEB7SGOgdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;