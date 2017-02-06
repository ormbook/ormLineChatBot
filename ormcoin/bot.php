<?php
function fn_profile($userId){
  global $access_token;
	$access_token = $_SERVER['CHANNEL_ACCESS_TOKEN_ormcoin'];
//$url = 'https://api.line.me/v1/profile';
$url="https://api.line.me/v2/bot/profile/".$userId;
$headers = array('Authorization: Bearer ' . $access_token);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);
  $arrProfile=json_decode($result,true);
  return $arrProfile;
  //return $result;
  
  /*
  $arrProfile=fn_profile($userId);
  $arrProfile["displayName"];
  $arrProfile["userId"];
  $arrProfile["pictureUrl"];
  $arrProfile["statusMessage"];
  */
  
}

$access_token = $_SERVER['CHANNEL_ACCESS_TOKEN_ormcoin'];
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
			$userId=$event['source']['userId'];	
			$arrProfile=fn_profile($userId);
			
			// Build message to reply back
			switch($text){
				case "quiz" : case "Quiz":
				$messages1 = ['type' => 'text','text' => "ดาวอังคารมีดาวบริวาร 2 ดวง คือ โฟบอส กับ ดีมอส ? \r\n * "];			
			//$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>1 ];
				$messages3['type']='sticker';
				$messages3['packageId']=1;
				$messages3['stickerId']=4;
			//$messages3 = ['type' => 'template','altText' => 'ohno','template'=> ['type'=>'confirm','text'=>'Are you sure?','actions'=>['type'=>'message','label'=>'yes','text'=>'yes']]];
				$action['type']='message';
				$action['label']='ใช่';
				$action['text']='Yes';
				$action2['type']='message';
				$action2['label']='ไม่ใช่แน่ๆ';
				$action2['text']='No';
				$m['type']='confirm';
				$m['text']='ขอตอบว่า?';
				$m['actions']=array($action,$action2);
				$messages2['type'] = 'template';
				$messages2['altText'] ='check in mobile';
				$messages2['template']=$m;
				break;
					
				case "Yes" : 
				$messages1 = ['type' => 'text','text' => "ใช่ เป็นคำตอบที่....ที่..."];			
			//$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>1 ];
				$messages3['type']='sticker';
				$messages3['packageId']=1;
				$messages3['stickerId']=2;
				
				$messages2 = ['type' => 'text','text' => "ถูกต้องนะครับ "];
				break;

				case "No" : 
				$messages1 = ['type' => 'text','text' => "ตอบมาว่า ไม่ใช่ เป็นคำตอบที่....ที่..."];			
			//$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>1 ];
				$messages3['type']='sticker';
				$messages3['packageId']=1;
				$messages3['stickerId']=3;
				
				$messages2 = ['type' => 'text','text' => "ผิดนะครับ!! "];
				break;

				case "Bal" :  
				$messages1 = ['type' => 'text','text' => "ormCoin : 123,456"];			
				$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>1 ];
				$messages3['type']='sticker';
				$messages3['packageId']=1;
				$messages3['stickerId']=12;
								
				break;
				
				case "Me" :  
	
				$messages1['type']='image';
				$messages1['originalContentUrl']=$arrProfile[pictureUrl];
				$messages1['previewImageUrl']='https://upload.wikimedia.org/wikipedia/commons/thumb/3/32/Creative-Tail-Objects-mirror.svg/200px-Creative-Tail-Objects-mirror.svg.png';
				$messages2 = ['type' => 'text','text' => 'Hello:'.$arrProfile[displayName]];
				$messages3 = ['type' => 'text','text' => ''.$arrProfile[statusMessage]];
				break;
					
				default :
				$rndint1=rand(1, 20);
				$rndint2=rand(1, 20);
				$rndint3=rand(1, 20);	
				$messages1 = ['type' => 'text','text' => 'XP:'.json_encode($event).json_encode($arrProfile)];
				$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>$rndint2 ];
				$messages3 = ['type' => 'sticker','packageId' => 1,'stickerId'=>$rndint3 ];
				break;

					

			}
			

			

			
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
