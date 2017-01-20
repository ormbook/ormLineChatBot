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
//messsage : text
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
//Post back
{
  "replyToken": "nHuyWiB7yP5Zw52FIkcQobQuGDXCTA",
  "type": "postback",
  "timestamp": 1462629479859,
  "source": {
    "type": "user",
    "userId": "U206d25c2ea6bd87c17655609a1c37cb8"
  },
  "postback": {
    "data": "action=buyItem&itemId=123123&color=red"
  }
}
https://devdocs.line.me/en/#webhook-event-object
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
			
			switch($text){
				case "pay": case "Pay": case "PAY": 
				case "menu": case "Menu": case "MENU":
				$messages1 =['type' => 'text','text' => $text." ".$name." \r\n".$txt];	
				$messages2=['type' => 'template','altText' => 'Menu','template'=> ['type'=>'buttons','thumbnailImageUrl'=>'https://ormlinebot.herokuapp.com/ormpay/ormPay-logo.PNG','title'=>'เมนู','text'=>'เลือกรายการจ่าย?','actions'=>[['type'=>'postback','label'=>'จ่าย:ค่าไฟ','data'=>'action=pay&vendor=elec'],['type'=>'postback','label'=>'จ่าย:ค่าน้ำ','data'=>'action=pay&vendor=water'],['type'=>'postback','label'=>'จ่าย:ค่าโทรศัพท์','data'=>'action=pay&vendor=AIS'],['type'=>'postback','label'=>'จ่าย:ค่าบัตรเครดิต','data'=>'action=pay&vendor=creditcard']]]];
				break;

				case "help": case "Help": case "HELP":  
				$messages1 =['type' => 'text','text' => " สวัสดี ".$name." \r\n สั่งงานเราได้นะ \r\n pay : จ่ายบิล \r\n bal : เช็คยอดในบัญชี \r\n อื่นๆ รอเราอัพเดทให้นะ";	
				$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>4 ];
				break;
					
				default :
				$messages1 =['type' => 'text','text' => "Hi ".$name." \r\n เรียกเมนู พิมพ์คำว่า Menu ได้นะ \r\n ถ้าคิดอะไรไม่ออก พิมพ์ help ดูสิ"];		
				$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>3 ];
				break;
			
			// Build message to reply back
			//$messages1 = ['type' => 'text','text' => $text];	
			//$messages3=['type' => 'image','originalContentUrl' => $pictureUrl , 'previewImageUrl'=> $pictureUrlsmall ];
			//$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>1 ];
			//$messages3 = ['type' => 'template','altText' => 'ohno','template'=> ['type'=>'confirm','text'=>'Are you sure?','actions'=>[['type'=>'message','label'=>'yes','text'=>'yes_q1'],['type'=>'message','label'=>'no','text'=>'no_q1']]]];
			//$txt="Hello สบายดีนะ ".$name;
			
			//$messages=fn_response($text);			
			
			}//end switch
		}else if ($event['type'] == 'postback' ) {
			$replyToken = $event['replyToken'];
			$postbackdata=parse_str($event['postback']['data']);//&action=pay&vender=elec
			if($action=="pay"){
			switch($vendor){
				case "elec":
				$messages1 =['type' => 'text','text' =>" จะจ่ายค่าไฟเหรอ สบายๆ มาเลย \r\n"];
				$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>5 ];
				break;

				case "water":
				$messages1 =['type' => 'text','text' =>"  จะจ่ายน้ำ ชิวๆ จ่ายได้เลย \r\n"];
				$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>6 ];
				break;
					
				default:
				$messages1 =['type' => 'text','text' => $postbackdata."  \r\n"];
				$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>7 ];
				break;
			}//end switch
			}//end if
		}//end if
				
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			//$data = ['replyToken' => $replyToken,'messages' => [$messages1,$messages2,$messages3]];
			$data = ['replyToken' => $replyToken,'messages' => [$messages1,$messages2]];

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
		
	}//foreach
}//end if
echo "OK";
?>
