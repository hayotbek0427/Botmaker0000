<?php
define('API_KEY','1325747520:AAEiIdqSAfTRleMzMpMGXSgeOJyKSpCuOs8');
$admin = '913047674';
$host_folder = 'hayotbek.herokuapp.com/Botmaker/';
$kanli = "WordPress_uzb";
$bio = file_get_contents("https://uzkod.ru/getBio/bio.php?user=$username");
function makereq($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
function apiRequest($method, $parameters)
    {if (!is_string($method))
    {error_log("Method name must be a string\n");
    return false;}
    if (!$parameters) {
    $parameters = array();}
  else if (!is_array($parameters))
  {error_log("Parameters must be an array\n");
    return false;}
  foreach ($parameters as $key => &$val)
  {if (!is_numeric($val) && !is_string($val))
  {$val = json_encode($val);}
  }
  $url = "https://api.telegram.org/bot".API_KEY."/".$method.'?'.http_build_query($parameters);
  $handle = curl_init($url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);
  return exec_curl_request($handle);
    }
$update = json_decode(file_get_contents('php://input'));
var_dump($update);
$chat_id = $update->message->chat->id;
$mossage_id = $update->message->message_id;
$from_id = $update->message->from->id;
$msg_id = $update->message->message_id;
$name = $update->message->from->first_name;
$username = $update->message->from->username;
$textmessage = isset($update->message->text)?$update->message->text:'';
$usm = file_get_contents("data/users.txt");
$step = file_get_contents("data/".$from_id."/step.txt");
$members = file_get_contents('data/users.txt');
$ban = file_get_contents('banlist.txt');
$uvip = file_get_contents('data/vips.txt');
$chanell = 'Wordpress_uzb';
$botname = 'SuperBOT_MAKER_BOT';
$cid = $message->chat->id;
function SendMessage($ChatId, $TextMsg)
{
makereq('sendMessage',[
'chat_id'=>$ChatId,
'text'=>$TextMsg,
'parse_mode'=>"MarkDown"
]);
}
function SendSticker($ChatId, $sticker_ID)
{
makereq('sendSticker',[
'chat_id'=>$ChatId,
'sticker'=>$sticker_ID
]);
}
function Forward($KojaShe,$AzKoja,$KodomMSG)
{
makereq('ForwardMessage',[
'chat_id'=>$KojaShe,
'from_chat_id'=>$AzKoja,
'message_id'=>$KodomMSG
]);
}
function save($filename,$TXTdata)
{
$myfile = fopen($filename, "w") or die("Unable to open file!");
fwrite($myfile, "$TXTdata");
fclose($myfile);
}
if (strpos($ban , "$from_id") !== false  ) {
SendMessage($chat_id,"Kechirasiz, \n ushbu serverga kirishingiz bloklandi");
	}
elseif(isset($update->callback_query))
{$callbackMessage = '';var_dump(makereq('answerCallbackQuery',['callback_query_id'=>$update->callback_query->id,'text'=>$callbackMessage]));
$chat_id = $update->callback_query->message->chat->id;
$message_id = $update->callback_query->message->message_id;
$data = $update->callback_query->data;
if (strpos($data, "del") !== false )
{$botun = str_replace("del ","",$data);
unlink("bots/".$botun."/index.php");
save("data/$chat_id/bots.txt","");
save("data/$chat_id/tedad.txt","0");
var_dump(makereq('editMessageText',
['chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"Sizning robotingiz muvaffaqiyatli o'chirildi!",
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"🔀Kanalimiz",'url'=>"https://telegram.me/Wordpress_uzb"]]]
                            ])
]                )
        );
}
else{var_dump(makereq('editMessageText',
['chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"Xato",
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"🔀Kanalimiz",'url'=>"https://telegram.me/Wordpress_uzb"]]]
                            ])
]                    )
             );
   }
}
$join = file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=@$kanali&user_id=".$from_id);
if($message && (strpos($join,'"status":"left"') or strpos($join,'"Bad Request: USER_ID_INVALID"') or strpos($join,'"status":"kicked"'))!== false){
bot('sendMessage', [
'chat_id'=>$chat_id,
'text'=>"👋 Salom bot xush kelibsiz

🌟 Botdan foydalanish uchun kanalimizga a'zo boling

📡Kanalimiz
@$kanali👈
👆👆👆
Bot yaratuvchsii: @excellend_boy
📌 A'zo bolib /start ni bosin " ,
   
]);return false;}

elseif ($textmessage == '🔙Orqaga')
{save("data/$from_id/step.txt","none");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"@$botname orqali o'zingizni shaxsiy botingizni oson va bepul yaratishingiz mumkin!😊

Sizga xech qanday xosting va xar xil kodlar kerak bo'lmaydi!
Siz uchun barchasini biz o'zimiz yaratib beramiz!😇
Ishonmaysizmi ?🙄
Xoziroq sinab ko'ring va o'zingiz guvohi bo'ling!🤓

🔊 @Wordpress_uzb - Bizning Kanal",
'parse_mode'=>'Html',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🎯Bot yaratish"],['text'=>"🎗Mening botim"],['text'=>"📋Yordam"]],
[['text'=>"🗑Botni ochirish"],['text'=>"🔰Vip bot"],['text'=>"📊Statistika"]],
[['text'=>" 📢Kanalimiz"],['text'=>"📝Savollar"],['text'=>"📖Qollanma"]],
],
'resize_keyboard'=>false
                            ])
                               ]
        )
    );
}
elseif ($textmessage == '📋Yordam')
{
SendMessage($chat_id,"Yangi botni yaratish uchun Bot yaratish🤖 tugmasini bosing.

Botni olib tashlash uchun botni o'chirish ❌ tugmasini bosing.

Botlar sonini ko'rish uchun Mening botlarim🚀 tugmalarini bosing.

Toliq malumot uchun Qollanmani🤖 bosing");
}
elseif ($textmessage == '/back')
{save("data/$from_id/step.txt","none");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"@$botname orqali o'zingizni shaxsiy botingizni oson va bepul yaratishingiz mumkin!😊

Sizga xech qanday xosting va xar xil kodlar kerak bo'lmaydi!
Siz uchun barchasini biz o'zimiz yaratib beramiz!😇
Ishonmaysizmi ?🙄
Xoziroq sinab ko'ring va o'zingiz guvohi bo'ling!🤓

🔊 @Wordpress_uzb - Bizning Kanal",
'parse_mode'=>'Html',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🎯Bot yaratish"],['text'=>"🎗Mening botim"],['text'=>"📋Yordam"]],
[['text'=>"🗑Botni ochirish"],['text'=>"🔰Vip bot"],['text'=>"📊Statistika"]],
[['text'=>" 📢Kanalimiz"],['text'=>"📝Savollar"],['text'=>"📖Qollanma"]],
],
'resize_keyboard'=>false
                            ])
                               ]
        )
    );
}
elseif ($textmessage == '🔰Vip bot')
{
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"️🔸 VIP BOT - bu sizga eng sara va eng tez ishlaydigan botlarni yaratish imkonini beradi!

Buning uchun sizga referal manzil beriladi va siz 10 ta do'stingizni botimizga taklif etishingiz va u do'stingiz botimizga a'zo bo'lishi kerak! Referal manzilni pastdagi tugma orqali olishingiz mumkin.👇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
            'keyboard'=>[
              [
                ['text'=>"Referal manzil🔄"]
              ],
              
              [
                ['text'=>"🔙Orqaga"]
              ]
           ]
        ])
     ]));
 }
 elseif ($textmessage == 'Referal manzil🔄')
{
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"️Xech qanday qiyinchiliksiz va BEPUL o'z botingizni yarating!
Bot yaratish uchun quyidagi ko'rsatilgan manzilni bosing!👇

👉 [https://telegram.me/$botname?start=$from_id]",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
            'keyboard'=>[
              
              [
                ['text'=>"🔙Orqaga"]
              ]
           ]
        ])
     ]));
 }
 
 elseif ($textmessage == '📢Kanalimiz')
{
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"️Yangiliklardan xabardor bo'lish uchun bizning Rasmiy kanalimizga obuna bo'ling.😊

Rasmiy kanalimizga quyidagi 👇 tugmani bosib obuna bo'lishingiz mumkin!",

'reply_markup'=>json_encode([
            'inline_keyboard'=>[
              [['text'=>"🔀Kanalimiz",'url'=>"https://telegram.me/Wordpress_uzb"]],
              
           
              ]
           
        ])
     ]));
 }
 
 elseif ($textmessage == '📖Qollanma')
{
SendMessage($chat_id,"🔮 Bot yaratish qo'llanmasi!

1. Telegram dasturingizdan @BotFather deb qidiring va START tugmasini bosing!

2. @BotFather ga /newbot buyrug'ini yozing.

3. Yaratmoqchi bo'lgan botingiz NOMINI yozing.

4. Botingiz BOTNAMEsini yozing (botname oxiri  _bot_  yoki _robot_ bilan tugashi kerak).

5. Agar amallarni to'g'ri bajargan bo'lsangiz sizga @BotFather botingiz APIsini yuboradi uni saqlab qo'ying!

6. Bot yaratayotganingizda botimiz API so'raganida @BotFather yuborgan APIni yuborasiz.");
}

elseif ($textmessage == '📊Statistika' && $from_id == $admin){
$number = count(scandir("bots"))-1;
$uvis = file_get_contents('data/vips.txt');
	$usercount = 1;
	$fp = fopen( "data/users.txt", 'r');
	while( !feof( $fp)) {
    		fgets( $fp);
    		$usercount ++;
	}
$avis = -1;
	$fp = fopen( "data/vips.txt", 'r');
	while( !feof( $fp)) {
    		fgets( $fp);
    		$avis ++;
	}
	fclose( $fp);
	SendMessage($chat_id,"Robot bilan bir vaqtning o'zida aniq statistika ⏰
--------------------------------
◆ Robot a'zolarining soni: $usercount

Botlarni soni: $number

🏆 Maxsus a'zolarning soni: $avis
--------------------------------
Xususiyatlari: $uvis");
	}
elseif ($textmessage == '📝Savollar')
{
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"️️DIQQAT!

Bizga savol berishda quyidagilarga amal qiling!
🔹Botga aloqasi bo'lmagan savol bermang!
🔸Savol berishdan oldin Qoidalar bilan tanishib chiqing!
🔹Savolingizni aniq va tushunarli yozing.


Qo'llab-quvvatlash uchun quyidagi tugmani bosing.⬇️ ",
'reply_markup'=>json_encode([
            'inline_keyboard'=>[
              [['text'=>"❓Savol berish❓",'url'=>"https://telegram.me/excellend_boy"]],
              
           
              ]
           
        ])
     ]));
 }
elseif ($step == 'create bot11')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️Noto'g'ri ❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/APKsearch.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("[*ADMIN*]",$from_id,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/APKsearch.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("[*ADMIN*]",$from_id,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz muvaffaqiyatli qurildi✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>[
[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot10')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️Noto'g'ri ❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/IQTest.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("[*ADMIN*]",$from_id,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/IQTest.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("[*ADMIN*]",$from_id,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz muvaffaqiyatli qurildi✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot9')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️Noto'g'ri❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/UzFileName.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("[*ADMIN*]",$from_id,$source);
$source = str_replace("[*BOTNAME*]","@$un",$source);
$source = str_replace("[**ADMINISMI**]",$name,$source);
$source = str_replace("[**ADMINUSER**]","@$username",$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/UzFileName.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("[*ADMIN*]",$from_id,$source);
$source = str_replace("[*BOTNAME*]","@$un",$source);
$source = str_replace("[**ADMINISMI**]",$name,$source);
$source = str_replace("[**ADMINUSER**]","@$username",$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz muvaffaqiyatli qurildi✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot8')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️Noto'g'ri❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/SuperNick.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("[*BOTNAME*]","@$un",$source);
$source = str_replace("[**ADMIN**]",$from_id,$source);
$source = str_replace("[**ADMINISMI**]",$name,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/SuperNick.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("[*BOTNAME*]","@$un",$source);
$source = str_replace("[**ADMIN**]",$from_id,$source);
$source = str_replace("[**ADMINISMI**]",$name,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz muvaffaqiyatli qurildi✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot7')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️Noto'g'ri❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/pustoy.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("**ADMIN**",$username,$source);
$source = str_replace("[*BOTNAME*]","$un",$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/pustoy.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("**ADMIN**",$username,$source);
$source = str_replace("[*BOTNAME*]","$un",$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz muvaffaqiyatli qurildi✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot12')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️Noto'g'ri❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/AdvokatFull.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("**ADMIN**",$username,$source);
$source = str_replace("[*BOTNAME*]","@$un",$source);
save("bots/$un/index.php",$source);
save("bots/$un/step.txt","none");
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
save("bots/$un/step.txt","none");
$source = file_get_contents("bot/AdvokatFull.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("**ADMIN**",$username,$source);
$source = str_replace("[*BOTNAME*]","@$un",$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz muvaffaqiyatli qurildi✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot13')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️Noto'g'ri❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/Quron.php");
$source = str_replace("**TOKEN**",$token,$source);
$source = str_replace("**ADMIN**",$from_id,$source);
$source = str_replace("[*BOTNAME*]","@$un",$source);
$source = str_replace("[**ADMINUSER**]","@$username",$source);
save("bots/$un/index.php",$source);
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/Quron.php");
$source = str_replace("**TOKEN**",$token,$source);
$source = str_replace("**ADMIN**",$from_id,$source);
$source = str_replace("[*BOTNAME*]","@$un",$source);
$source = str_replace("[**ADMINUSER**]","@$username",$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz muvaffaqiyatli qurildi✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot14')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️Noto'g'ri❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/index14.php");
$source = str_replace("**TOKEN**",$token,$source);
$source = str_replace("**KANAL**",$name,$source);

save("bots/$un/index.php",$source);
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/index14.php");
$source = str_replace("**TOKEN**",$token,$source);
$source = str_replace("**KANAL**",$name,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz muvaffaqiyatli qurildi✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif (strpos($textmessage , "/delvip" ) !== false ) {
if ($from_id == $admin) {
$text = str_replace("/delvip","",$textmessage);
      $newlist = str_replace($text,"",$vip);
      save("data/vips.txt",$newlist);
SendMessage($admin,"🔹 Foydalanuvchi $text maxsus a'zolar ro'yxatidan muvaffaqiyatli olib tashlandi.");
SendMessage($logch,"$text foydalanuvchisi maxsus a'zolar ro'yxatidan chiqarildi.");
}
else {
SendMessage($chat_id,"⛔️ Siz administrator emassiz.");
}
}
elseif ($textmessage == '/creator')
{
SendMessage($chat_id,"⛔️ Ushbu bot @excellend_boy ishlab chiqilgan");
}
elseif ($textmessage == '/Creator')
{
SendMessage($chat_id,"⛔️ Ushbu bot @excellend_boy ishlab chiqilgan");
}
elseif ($textmessage == '/update')
{
SendMessage($chat_id,"Bot yangilandi");
}
elseif ($textmessage == '/update')
{
SendMessage($chat_id,"Bot yangilandi");
}
elseif ($step == 'create bot23')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️Noto'g'ri❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/Tarjimon.php");
$source = str_replace("**TOKEN**",$token,$source);
$source = str_replace("**ADMIN**",$from_id,$source);
save("bots/$un/index.php",$source);
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/Tarjimon.php");
$source = str_replace("**TOKEN**",$token,$source);
$source = str_replace("**ADMIN**",$from_id,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz muvaffaqiyatli qurildi✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot25')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️Noto'g'ri❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/SpamBot.php");
$source = str_replace("[**TOKEN**]",$token,$source);
$source = str_replace("[**ADMIN**]",$from_id,$source);
save("bots/$un/index.php",$source);
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/SpamBot.php");
$source = str_replace("[**TOKEN**]",$token,$source);
$source = str_replace("[**ADMIN**]",$from_id,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz muvaffaqiyatli qurildi✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot15')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️Noto'g'ri❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/LogoMaker.php");
$source = str_replace("**TOKEN**",$token,$source);
$source = str_replace("[**ADMINUSER**]","@$username",$source);
$source = str_replace("**ADMIN**",$from_id,$source);
save("bots/$un/index.php",$source);
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇\n\n@Botfather ga kirib /setline ni yoqing",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/LogoMaker.php");
$source = str_replace("**TOKEN**",$token,$source);
$source = str_replace("**TOKEN**",$token,$source);
$source = str_replace("[**ADMINUSER**]","@$username",$source);
$source = str_replace("**ADMIN**",$from_id,$source);
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz muvaffaqiyatli qurildi✅\@Botfather ga kirib /setline ni yoqing",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot18')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️Noto'g'ri❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/HideText.php");
$source = str_replace("**TOKEN**",$token,$source);
save("bots/$un/index.php",$source);
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/HideText.php");
$source = str_replace("**TOKEN**",$token,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz muvaffaqiyatli qurildi✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot16') {
$token = $textmessage ;

      $userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));
      //==================
      function objectToArrays( $object ) {
        if( !is_object( $object ) && !is_array( $object ) )
        {
        return $object;
        }
        if( is_object( $object ) )
        {
        $object = get_object_vars( $object );
        }
      return array_map( "objectToArrays", $object );
      }

  $resultb = objectToArrays($userbot);
  $un = $resultb["result"]["username"];
  $ok = $resultb["ok"];
    if($ok != 1) {
      //Token Not True
      SendMessage($chat_id,"Noto'g'ri Token");
    }
    else
    {
    SendMessage($chat_id,"Yaratimoqda...");
    file_put_contents("bots/$un/vip.txt","vip");
    file_put_contents("bots/$un/ad_vip.txt","hfyodlhxtod5545jg");
        file_put_contents("bots/$un/step.txt","none");
    file_put_contents("bots/$un/users.txt","");
    file_put_contents("bots/$un/token.txt","$text");
        file_put_contents("bots/$un/start.txt","Robotga xush kelibsiz! ❤️
Agar siz do'stlaringiz bilan guruh yoki bolalarni o'ynashni istasangiz, o'ynashni boshlang va o'ynashni boshlang.
Natijalar o'yin yakunlanganda e'lon qilinadi ");
    if (file_exists("bots/$un/index.php")) {
    $source = file_get_contents("bot/index16.php");
    $source = str_replace("**TOKEN**",$token,$source);
    $source = str_replace("**ADMIN**",$from_id,$source);
    save("bots/$un/index.php",$source);  
    file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");

var_dump(makereq('sendMessage',[
          'chat_id'=>$update->message->chat->id,
          'text'=>"♻️🚀 Sizning bot muvaffaqiyatli yangilandi!",
    'parse_mode'=>'MarkDown',
          'reply_markup'=>json_encode([
              'inline_keyboard'=>[
                [
                   ['text'=>'Botingiz','url'=>"https://telegram.me/$un"]
                ]
                
              ],
              'resize_keyboard'=>true
           ])
        ]));
    }
    else {
    save("data/$from_id/tedad.txt","1");
    save("data/$from_id/step.txt","none");
    save("data/$from_id/bots.txt","$un");
    mkdir("bots/$un");
    file_put_contents("bots/$un/vip.txt","vip");
    file_put_contents("bots/$un/ad_vip.txt","hfyodlhxtod5545jg");
        file_put_contents("bots/$un/step.txt","none");
    file_put_contents("bots/$un/users.txt","");
    file_put_contents("bots/$un/token.txt","$text");
        file_put_contents("bots/$un/start.txt","Robotga xush kelibsiz! ❤️
Agar siz do'stlaringiz bilan guruh yoki bolalarni o'ynashni istasangiz, o'ynashni boshlang va o'ynashni boshlang.
Natijalar o'yin yakunlanganda e'lon qilinadi ");
    $source = file_get_contents("bot/index16.php");
    $source = str_replace("**TOKEN**",$token,$source);
    $source = str_replace("**ADMIN**",$from_id,$source);
    save("bots/$un/index.php",$source);  
    file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");

var_dump(makereq('sendMessage',[
          'chat_id'=>$update->message->chat->id,
          'text'=>"♻️🚀 Sizning bot muvaffaqiyatli yangilandi!",    
                'parse_mode'=>'MarkDown',
          'reply_markup'=>json_encode([
              'inline_keyboard'=>[
                [
                   ['text'=>'Botingiz','url'=>"https://telegram.me/$un"]
                ]
                
              ],
              'resize_keyboard'=>true
           ])
        ]));
}
}
}
elseif ($step == 'create bot19')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️Noto'g'ri❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/index19.php");
$source = str_replace("**TOKEN**",$token,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/index19.php");
$source = str_replace("**TOKEN**",$token,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz muvaffaqiyatli qurildi✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot20')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️Noto'g'ri❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/index20.php");
$source = str_replace("**TOKEN**",$token,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/index20.php");
$source = str_replace("**TOKEN**",$token,$source);
$source = str_replace("**ADMIN**",$from_id,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz muvaffaqiyatli qurildi✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot21')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️Noto'g'ri❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/UserInfo.php");
$source = str_replace("**TOKEN**",$token,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/UserInfo.php");
$source = str_replace("**TOKEN**",$token,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz muvaffaqiyatli qurildi✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot17')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️Noto'g'ri❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/Konvertor.php");
$source = str_replace("**TOKEN**",$token,$source);
$source = str_replace("[**ADMINISMI**]",$name,$source);
$source = str_replace("[**ADMINUSER**]","@$username",$source);
save("bots/$un/index.php",$source);
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/Konvertor.php");
$source = str_replace("**TOKEN**",$token,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz muvaffaqiyatli qurildi✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot5')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️Noto'g'ri❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/UzChanBot.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("[*BOTNAME*]","@$un",$source);
$source = str_replace("[**ADMIN**]",$from_id,$source);
$source = str_replace("[**ADMINISMI**]",$name,$source);


save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/UzChanBot.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("[*BOTNAME*]","@$un",$source);
$source = str_replace("[**ADMIN**]",$from_id,$source);
$source = str_replace("[**ADMINISMI**]",$name,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot4')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];

if($ok != 1)
{SendMessage($chat_id,"❗️Noto'g'ri❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/X_O.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/X_O.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz muvaffaqiyatli qurildi✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot3')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];

if($ok != 1)
{SendMessage($chat_id,"❗️Noto'g'ri❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/kanalgakir.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("**KANAL**",$name,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi! Endi Ismingizni Avvalgi Holatga Qaytarsangiz Bo'ladi.

*@$un Botingiz to'g'ri ishlashi uchun $name kanalingizga Admin bo'lishi shart!*
👇Botni Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/kanalgakir.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("**KANAL**",$name,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz muvaffaqiyatli qurildi✅
Endi Ismingizni Avvalgi Holatga Qaytarsangiz Bo'ladi.

❗️ *@$un Botingiz to'g'ri ishlashi uchun $name kanalingizga Admin bo'lishi shart!*",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot2')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];

if($ok != 1)
{SendMessage($chat_id,"❗️Noto'g'ri❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩Yaratilmoqda🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/Advokat.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("[*BOTNAME*]","@$un",$source);
$source = str_replace("[**ADMIN**]",$from_id,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Botingiz Serverga Muvaffaqiyatli Ulandi
👇Tekshirib Ko'rishingiz Mumkun👇
➖➖➖➖➖➖➖➖➖➖➖➖
Botingiz Useri: @$un
➖➖➖➖➖➖➖➖➖➖➖➖

Bemalol /start ni bosib ishlatishingiz mumkun😇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙Orqaga"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/Advokat.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("[*BOTNAME*]","@$un",$source);
$source = str_replace("[**ADMIN**]",$from_id,$source);
$source = str_replace("[**ADMINISMI**]",$name,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz muvaffaqiyatli qurildi✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot') {
$token = $textmessage ;

      $userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));
      //==================
      function objectToArrays( $object ) {
        if( !is_object( $object ) && !is_array( $object ) )
        {
        return $object;
        }
        if( is_object( $object ) )
        {
        $object = get_object_vars( $object );
        }
      return array_map( "objectToArrays", $object );
      }

  $resultb = objectToArrays($userbot);
  $un = $resultb["result"]["username"];
  $ok = $resultb["ok"];
    if($ok != 1) {
      //Token Not True
      SendMessage($chat_id,"Notogri token");
    }
    else
    {
    SendMessage($chat_id,"Yaratilmoqda...");
    if (file_exists("bots/$un/index.php")) {
    $source = file_get_contents("bot/index.php");
    $source = str_replace("**TOKEN**",$token,$source);
    $source = str_replace("**ADMIN**",$from_id,$source);
    $source = str_replace("[**ADMINISMI**]",$name,$source);
    $info = file_get_contents("https://api.telegram.org/botTOKEN/getme");
$username = json_decode($info);
$botuser = $username->result->username;
    save("bots/$un/index.php",$source);  
    file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");

var_dump(makereq('sendMessage',[
          'chat_id'=>$update->message->chat->id,
          'text'=>"♻️🚀 Sizning bot muvaffaqiyatli yangilandi!",
    'parse_mode'=>'MarkDown',
          'reply_markup'=>json_encode([
              'inline_keyboard'=>[
                [
                   ['text'=>'Botingiz','url'=>"https://telegram.me/$un"]
                ]
                
              ],
              'resize_keyboard'=>true
           ])
        ]));
    }
    else {
    save("data/$from_id/tedad.txt","1");
    save("data/$from_id/step.txt","none");
    save("data/$from_id/bots.txt","$un");
    
    mkdir("bots/$un");
    mkdir("bots/$un/data");
    mkdir("bots/$un/data/btn");
    mkdir("bots/$un/data/words");
    mkdir("bots/$un/data/profile");
    mkdir("bots/$un/data/setting");
    
    save("bots/$un/data/blocklist.txt","");
    save("bots/$un/data/last_word.txt","");
    save("bots/$un/data/pmsend_txt.txt","📮Message Sent!");
    save("bots/$un/data/start_txt.txt","Hello Wellcome To My Robot 😉👌
Send Me Your Message 🌹");
    save("bots/$un/data/forward_id.txt","");
    save("bots/$un/data/users.txt","$from_id\n");
    mkdir("bots/$un/data/$from_id");
    save("bots/$un/data/$from_id/type.txt","admin");
    save("bots/$un/data/$from_id/step.txt","none");
    
    save("bots/$un/data/btn/btn1_name","");
    save("bots/$un/data/btn/btn2_name","");
    save("bots/$un/data/btn/btn3_name","");
    save("bots/$un/data/btn/btn4_name","");
    
    save("bots/$un/data/btn/btn1_post","");
    save("bots/$un/data/btn/btn2_post","");
    save("bots/$un/data/btn/btn3_post","");
    save("bots/$un/data/btn/btn4_post","");
  
    save("bots/$un/data/setting/sticker.txt","✅");
    save("bots/$un/data/setting/video.txt","✅");
    save("bots/$un/data/setting/voice.txt","✅");
    save("bots/$un/data/setting/file.txt","✅");
    save("bots/$un/data/setting/photo.txt","✅");
    save("bots/$un/data/setting/music.txt","✅");
    save("bots/$un/data/setting/forward.txt","✅");
    save("bots/$un/data/setting/joingp.txt","✅");
    

    $source = file_get_contents("bot/index.php");
    $source = str_replace("**TOKEN**",$token,$source);
    $source = str_replace("**ADMIN**",$from_id,$source);
    save("bots/$un/index.php",$source);  
    file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");

var_dump(makereq('sendMessage',[
          'chat_id'=>$update->message->chat->id,
          'text'=>"🚀 Sizning bot muvaffaqiyatli o'rnatildi!",    
                'parse_mode'=>'MarkDown',
          'reply_markup'=>json_encode([
              'inline_keyboard'=>[
                [
                   ['text'=>'Botingiz','url'=>"https://telegram.me/$un"]
                ]
                
              ],
              'resize_keyboard'=>true
           ])
        ]));
}
}
}
elseif($textmessage == '🎗Mening botim')
{$botname = file_get_contents("data/$from_id/bots.txt");
if ($botname == "")
{SendMessage($chat_id,"Siz hali bot yaratmadingiz");
return;
}
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Sizning botingiz👇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"👉 @".$botname,'url'=>"https://telegram.me/".$botname]]]
                            ])
                                ]
        )
    );
}
elseif(strpos($textmessage , "/start") !== false)
{
if (!file_exists("data/$from_id/step.txt"))
{mkdir("data/$from_id");
save("data/$from_id/step.txt","none");
save("data/$from_id/tedad.txt","0");
save("data/$from_id/bots.txt","");
$myfile2 = fopen("data/users.txt", "a") or die("Unable to open file!"); 
fwrite($myfile2, "$from_id\n");
fclose($myfile2);
}
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"🤟 Assalom Alaykum!

🤖 @SuperBOT_MAKER_BOT orqali o'zingizni shaxsiy botingizni oson va bepul yaratishingiz mumkin!
🗄 Sizga xech qanday xosting va xar xil kodlar kerak bo'lmaydi!
✅ Barchasi Foydalanishga Tayyor!
🔊 @Wordpress_uzb - Bizning Kanal

👇 Menyulardan Kirini Tanlang",
'parse_mode'=>'Html',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🎯Bot yaratish"],['text'=>"🎗Mening botim"],['text'=>"📋Yordam"]],
[['text'=>"🗑Botni ochirish"],['text'=>"🔰Vip bot"],['text'=>"📊Statistika"]],
[['text'=>" 📢Kanalimiz"],['text'=>"📝Savollar"],['text'=>"📖Qollanma"]],
],
'resize_keyboard'=>false
                            ])
                               ]
        )
    );
}
elseif ($textmessage == '🗑Botni ochirish') {
if (file_exists("data/$from_id/step.txt"))
{}
$botname = file_get_contents("data/$from_id/bots.txt");
if ($botname == "")
{SendMessage($chat_id,"❗️Siz bot yaratmagansiz❗️");}
else
{
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"🤖Botingiz ustiga bosing🤖",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"👉 @".$botname,'callback_data'=>"del ".$botname]]]
                            ])
                               ]
        )
    );

}
}
elseif ($textmessage == '/panel')
if ($from_id == $admin)
{
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"👋Salom 
Robotingiz administrator paneliga xush kelibsiz",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
              [
                ['text'=>"Xammaga xabar yuborish📬"],['text'=>"📊Statistika"]
              ],
              [
                ['text'=>"Unban✅"],['text'=>"Ban⛔️"]
              ],
              [
                ['text'=>"Xamma uchun🚀"]
              ],
              [
                ['text'=>"🔙Orqaga"]
              ]
            ]
        ])
    ]));
 }
else
{
SendMessage($chat_id,"Siz admin emassiz😂");
}
elseif (strpos($textmessage , "/ban") !== false && $chat_id == $admin)
{
$bban = str_replace('/ban','',$textmessage);
if ($bban != '')
{
$myfile2 = fopen("banlist.txt", "a") or die("Unable to open file!"); 
fwrite($myfile2, "$bban\n");
fclose($myfile2);
SendMessage($chat_id,"`$bban bloklandi`");
SendMessage($chanell,"`$bban foydalanuvchisi robot serveridan bloklandi`");
}
}
elseif (strpos($textmessage , "/unban") !== false && $chat_id == $admin)
{
$unbban = str_replace('/unban','',$textmessage);
if ($unbban != '')
{
$newlist = str_replace($unbban,"","banlist.txt");
save("banlist.txt",$newlist);
SendMessage($chat_id,"`$unbban foydalanuvchisi blokdan olindi`");
SendMessage($chanell,"`$unbban foydalanuvchisi robot serveridan blokdan olindi`");
}
}
elseif ($textmessage == 'Xammaga xabar yuborish📬')
if ($from_id == $admin)
{
save("data/$from_id/step.txt","sendtoall");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Xabaringizni yozing",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
SendMessage($chat_id,"Siz administrator emassiz.");
}
elseif ($step == 'sendtoall')
{
SendMessage($chat_id,"Xabar yuborilmoqda ... ⏰");
save("data/$from_id/step.txt","none");
$fp = fopen( "data/users.txt", 'r');
while( !feof( $fp)) {
$ckar = fgets( $fp);
SendMessage($ckar,$textmessage);
}
SendMessage($chat_id,"Xabaringiz muvaffaqiyatli tarzda barcha foydalanuvchilarga yuborildi👍");
}
elseif ($textmessage == 'Xamma uchun🚀')
if ($from_id == $admin)
{
save("data/$from_id/step.txt","fortoall");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Xabaringizni yozing",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
SendMessage($chat_id,"Siz admin emassiz");
}
elseif ($step == 'fortoall')
{
save("data/$from_id/step.txt","none");
		 SendMessage($chat_id,"Yuborilmoqda...");
$forp = fopen( "data/users.txt", 'r');
while( !feof( $forp)) {
$fakar = fgets( $forp);
Forward($fakar, $chat_id,$mossage_id);
		 }
		 makereq('sendMessage',[
		 'chat_id'=>$chat_id,
		 'text'=>"🚀Xabaringiz barcha foydalanuvchilarga yuborildi✅",
		 ]);
	 }
elseif ($textmessage == 'Ban⛔️')
if ($chat_id == $admin) {
SendMessage($chat_id,"Foydalanuvchini bloklash uchun quyidagi amallarni bajaring
/ban USERID 
USERID o'rniga, foydalanuvchi raqamiga kod qo'shing");
}
else
{ SendMessage($chat_id,"Siz admin emassiz"); }
elseif ($textmessage == 'Unban✅')
if ($chat_id == $admin) {
SendMessage($chat_id,"Foydalanuvchini blokdan olish uchun quyidagi amallarni bajaring
/unban USERID 
USERID o'rniga, foydalanuvchi raqamiga kod qo'shing");
}
else
{ SendMessage($chat_id,"Siz admin emassiz"); }
elseif (strpos($textmessage , "/setvip" ) !== false ) {
if ($from_id == $admin) {
$text = str_replace("/setvip","",$textmessage);
$myfile2 = fopen("data/vips.txt", 'a') or die("Unable to open file!");  
fwrite($myfile2, "$text\n");
fclose($myfile2);
SendMessage($chat_id,"Hisobni yangilash muvaffaqiyatli yakunlandi
Foydalanuvchining $text maxsus a'zolar ro'yxatiga qo'shilgan😃");
}
}
elseif ($textmessage == '🎯Bot yaratish')
{
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"️Yaratmoqchi bo'lgan bolimni tanlang:⬇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
            'keyboard'=>[
              [
                ['text'=>"Maxsus bolim🏆"]
              ],
              [
                ['text'=>"Bepul bolim🎯"]
              ],
              [
                ['text'=>"🔙Orqaga"]
              ]
           ]
        ])
     ]));
 }
elseif ($textmessage == '🔙orqaga')
{save("data/$from_id/step.txt","none");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"️Yaratmoqchi bo'lgan bolimni tanlang:⬇",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
            'keyboard'=>[
              [
                ['text'=>"Maxsus bolim🏆"]
              ],
              [
                ['text'=>"Bepul bolim🎯"]
              ],
              [
                ['text'=>"🔙Orqaga"]
              ]
           ]
        ])
     ]));
 }
elseif ($textmessage == 'Maxsus bolim🏆')
if (strpos($uvip , "$from_id") !== false  ) {
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"Bot turini tanlang",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
[['text'=>"🏆 Advokat"],['text'=>"📂 File Convertor"]],
[['text'=>"🤖Quron bot"],['text'=>"🔢Kalkulator"]],
[['text'=>"🌃Logo Maker"],['text'=>"🅾Grourd Bot"]],
[['text'=>"♻Konverter"],['text'=>"🔎Yashirin matn"]],
[['text'=>"🙈Anonim suxbat"],['text'=>"🌄Foto shop"]],
[['text'=>"🔙orqaga"]]
            ]
        ])
    ]));
 }
else
{
$textvip = "📛 Diqqat, Ushbu Bo'lim Pullik!
➖➖➖➖➖➖➖➖➖➖➖➖
✅ Bo'limdan Foydalanish Uchun
👨‍💻 @excellend_boy Bilan Bog'lanib,
💰 To'lov Qilish Kerak (Arzon)...";
SendMessage($chat_id,$textvip);
}
elseif ($textmessage == 'Bepul bolim🎯')
{
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"Bot turini tanlang",
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
              [
                ['text'=>"👨‍✈️ Sudya"],['text'=>"✍Nik yasovchi"]
              ],
	      [
                ['text'=>"↖️ UzChanBot"],['text'=>"🔢 SpamBot"]
              ],
              [
         ['text'=>"📡 Wordpress_uzb_BOT"],['text'=>"❌⭕Oyini"]
              ],
	      [
['text'=>"🧠 IQ Test"],['text'=>"✏️ UzFileName"]
],
[
['text'=>"Apk qidiruv🔍"],['text'=>"🌠 iLogoBot"]
],
[
['text'=>"📜Info user"],['text'=>"🇺🇿Tarjimon"]
],
[
	        ['text'=>"🔙orqaga"]
	      ]
            ]
        ])
    ]));
 }
elseif ($textmessage == '🇺🇿Tarjimon')
{
$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot23");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
elseif ($textmessage == '📂 File Convertor')

if (strpos($uvip , "$from_id") !== false  ) {
$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
SendMessage($chat_id,"Siz hali maxsus foydalanuvchi emassiz☹️");
}
elseif ($textmessage == '🏆 Advokat')


if (strpos($uvip , "$from_id") !== false  ) {
$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot12");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
SendMessage($chat_id,"Siz hali maxsus foydalanuvchi emassiz☹️");
}
elseif ($textmessage == '🤖Quron bot')
if (strpos($uvip , "$from_id") !== false  ) {
$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin..");
return;
}
save("data/$from_id/step.txt","create bot13");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
SendMessage($chat_id,"Siz hali maxsus foydalanuvchi emassiz☹️");
}
elseif ($textmessage == '🔢Kalkulator')
if (strpos($uvip , "$from_id") !== false  ) {
$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot14");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
SendMessage($chat_id,"Siz hali maxsus foydalanuvchi emassiz☹️");
}
elseif ($textmessage == '🌃Logo Maker')
if (strpos($uvip , "$from_id") !== false  ) {
$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot15");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
SendMessage($chat_id,"Siz hali maxsus foydalanuvchi emassiz☹️");
}
elseif ($textmessage == '🅾Grourd Bot')
if (strpos($uvip , "$from_id") !== false  ) {
$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot16");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
SendMessage($chat_id,"Siz hali maxsus foydalanuvchi emassiz☹️");
}
elseif ($textmessage == '♻Konverter')

if (strpos($uvip , "$from_id") !== false  ) {
$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot17");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
SendMessage($chat_id,"Siz hali maxsus foydalanuvchi emassiz☹️");
}
elseif ($textmessage == '🔎Yashirin matn')
if (strpos($uvip , "$from_id") !== false  ) {
$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot18");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
SendMessage($chat_id,"Siz hali maxsus foydalanuvchi emassiz☹️");
}
elseif ($textmessage == '🙈Anonim suxbat') 




if (strpos($uvip , "$from_id") !== false  ) {
$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot19");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
SendMessage($chat_id,"Siz hali maxsus foydalanuvchi emassiz☹️");
}
elseif ($textmessage == '🌄Foto shop')
if (strpos($uvip , "$from_id") !== false  ) {
$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot20");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
SendMessage($chat_id,"Siz hali maxsus foydalanuvchi emassiz☹️");
}
elseif ($textmessage == '📜Info user')
{
$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot21");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
elseif ($textmessage == '👨‍✈️ Sudya')
{$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot2");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}



elseif ($textmessage == uzbek_tgrobot')
{$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot3");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"‼️ Diqqat! Bu Botni Yasash Uchun *Ismingiz O'rniga Kanalingiz Usernamesini @ bilan yozasiz, Masalan @Uversal (Ism o'rnida Kanal Useri bo'lishi shart, BO'LMASA BOT ISHLAMAYDI,* Bot ishga tushgach ismni yana avvalgi holiga qaytarib olaverasiz, botingiz esa ishlayveradi)
[RASMGA QARANG!](https://t.me/bot_masterlar/162)
*TUSHUNGAN BO'LSANGIZ BAJARIB SO'NG TOKENNI YUBORING*

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
elseif ($textmessage == '❌⭕Oyini')
{$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot4");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
elseif ($textmessage == '↖️ UzChanBot')
{$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot5");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
elseif ($textmessage == '✍Nik yasovchi')
{$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot8");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
elseif ($textmessage == '✏️ UzFileName')
{$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot9");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
elseif ($textmessage == '🧠 IQ Test')
{$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot10");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
elseif ($textmessage == 'Apk qidiruv🔍')
{$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot11");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
elseif ($textmessage == '🌠 iLogoBot')
{$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot7");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
elseif ($textmessage == '🔢 SpamBot')
{$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 100 && $from_id != '913047674')
{SendMessage($chat_id,"Har bir inson faqat bitta robot qurishi mumkin.");
return;
}
save("data/$from_id/step.txt","create bot25");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"Tanlangan botni yaratish uchun BotFather dan olingan BOT TOKENI ni yuboring!

BOT TOKEN taxminan quyidagicha bo'ladi - 302196750:AAGkFYpJkrbW2chgDL2F8afpYXQV4w02N5LU",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙Orqaga"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{SendMessage($chat_id,"❗️Bunday buyruq yoq😡");}
$txxt = file_get_contents('data/users.txt');
    $pmembersid= explode("\n",$txxt);
    if (!in_array($chat_id,$pmembersid)){
      $aaddd = file_get_contents('data/users.txt');
      $aaddd .= $chat_id."\n";
      file_put_contents('data/users.txt',$aaddd);
    }
?>