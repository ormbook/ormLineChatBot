<?php
$access_token = 'PN1T8nvVqM8SiDBpr6RX/GtlLoHYFQQ6P/dml+03M1ZMtB3Xw8g1aLJvOlXNAB4A0pUNrDMJhAcwfhEwiJdCHwzd0QCv/qwldt88hndvWQ+Gm3+yYo+bZKYxAaqdDjmeYWktBxk94LgiUfHEB7SGOgdB04t89/1O/w1cDnyilFU=';

//$channelAccessToken = 'oGDLUqeIcOWCDs9RfEWqWdIJbg1F6Kv0Y6Of42oqzNd1t5Hgog6R9Xb2/rnO1yrE6AvVZ7RQag8BwmHVaUJ5wg72R0r82fXAOIbkv0OZcIEHf9U87DsCi6HU5UGHbFsBNaywMlg9KzMW9aaVcMmD3wdB04t89/1O/w1cDnyilFU=';
//$channelSecret = '1b5542f38282c54fd557332cbb14e26c';



// Get POST body content
$content = file_get_contents('php://input');
//$content='{  "events": [    {      "replyToken": "nHuyWiB7yP5Zw52FIkcQobQuGDXCTA",      "type": "message",      "timestamp": 1462629479859,      "source": {        "type": "user",        "userId": "U206d25c2ea6bd87c17655609a1c37cb8"      },      "message": {        "id": "325708",        "type": "text",        "text": "Hello, world"      }    },    {      "replyToken": "nHuyWiB7yP5Zw52FIkcQobQuGDXCTA",      "type": "follow",      "timestamp": 1462629479859,      "source": {        "type": "user",        "userId": "U206d25c2ea6bd87c17655609a1c37cb8"      }    }  ]}';
// Parse JSON
$events = json_decode($content, true);

//print_r($events);
/*
{
  "events": [
    {
      "replyToken": "nHuyWiB7yP5Zw52FIkcQobQuGDXCTA",
      "type": "message",
      "timestamp": 1462629479859,
      "source": {
        "type": "user",
        "userId": "U206d25c2ea6bd87c17655609a1c37cb8"
      },
      "message": {
        "id": "325708",
        "type": "text",
        "text": "Hello, world"
      }
    },
    {
      "replyToken": "nHuyWiB7yP5Zw52FIkcQobQuGDXCTA",
      "type": "follow",
      "timestamp": 1462629479859,
      "source": {
        "type": "user",
        "userId": "U206d25c2ea6bd87c17655609a1c37cb8"
      }
    }
  ]
}
*/
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];


			// Build message to reply back
			$messages1 = ['type' => 'text','text' => $text];	
			//$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>1 ];
			$messages2['type']='sticker';
			$messages2['packageId']=1;
			$messages2['stickerId']=1;
			//$messages3 = ['type' => 'template','altText' => 'ohno','template'=> ['type'=>'confirm','text'=>'Are you sure?','actions'=>['type'=>'message','label'=>'yes','text'=>'yes']]];
$action['type']='message';
$action['label']='yes';
$action['text']='yes';

$action2['type']='message';
$action2['label']='no';
$action2['text']='no';


$m['type']='confirm';
$m['text']='Are you sure?';
$m['actions']=array($action,$action2);


$messages3['type'] = 'template';
$messages3['altText'] ='check in mobile';
$messages3['template']=$m;
			
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = ['replyToken' => $replyToken,'messages' => [$messages1,$messages2,$messages3]];

/*
{
  "replyToken": "nHuyWiB7yP5Zw52FIkcQobQuGDXCTA",
  "type": "message",
  "timestamp": 1462629479859,
  "source": {
    "type": "user",
    "userId": "U206d25c2ea6bd87c17655609a1c37cb8"
  },
  "message": {
    "id": "325708",
    "type": "text",
    "text": "Hello, world"
  }
}
*/

			$post = json_encode($data);
			//$post='{  "replyToken": "'.$replyToken.'","messages":{"type": "text","text": "Hello, world"}}';
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}//end if
	}//foreach
}//end if
echo "OK";
?>
