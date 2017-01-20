<?php require_once("var_token.inc.php");?>
<?php require_once("fn_profile.inc.php");?>
<?php
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
			//get Name
			$userId=$event['source']['userId'];	
			$arrProfile=fn_profile($userId);
			$name=$arrProfile['displayName'];
			//$arrProfile["userId"];
			//$pictureUrl=$arrProfile['pictureUrl'];
			//$pictureUrlsmall=$arrProfile['pictureUrl']."/small";
			
			// Build message to reply back
			//$messages1 = ['type' => 'text','text' => $text];	
			//$messages3=['type' => 'image','originalContentUrl' => $pictureUrl , 'previewImageUrl'=> $pictureUrlsmall ];
			//$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>1 ];
			//$messages3 = ['type' => 'template','altText' => 'ohno','template'=> ['type'=>'confirm','text'=>'Are you sure?','actions'=>[['type'=>'message','label'=>'yes','text'=>'yes_q1'],['type'=>'message','label'=>'no','text'=>'no_q1']]]];
			//$txt="Hello สบายดีนะ ".$name;
			$messages1 =['type' => 'text','text' => $text." ".$name." \r\n".$txt];
			//$messages=fn_response($text);
			
			$messages2=['type' => 'template','altText' => 'Menu','template'=> ['type'=>'buttons','thumbnailImageUrl'=>'https://ormlinebot.herokuapp.com/ormpay/ormPay-logo.PNG','title'=>'เมนู','text'=>'เลือกรายการจ่าย?','actions'=>[['type'=>'postback','label'=>'จ่าย:ค่าไฟ','data'=>'action=pay&vender=elec'],['type'=>'postback','label'=>'จ่าย:ค่าน้ำ','data'=>'action=pay&vender=water'],['type'=>'postback','label'=>'จ่าย:ค่าโทรศัพท์','data'=>'action=pay&vender=AIS'],['type'=>'postback','label'=>'จ่าย:ค่าบิัตรเครดิต','data'=>'action=pay&vender=creditcard']]]];
			

			
				
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			//$data = ['replyToken' => $replyToken,'messages' => [$messages1,$messages2,$messages3]];
			$data = ['replyToken' => $replyToken,'messages' => [$messages1,$messages2]];
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
