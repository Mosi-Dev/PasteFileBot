<?php
    define('TOKEN', 'token');
    $channel = '@username';
    $update = json_decode(file_get_contents('php://input'));
    $chat_id = $update->message->chat->id;
    $msg_id = $update->message->message_id;
    $msg_text = $update->message->text;
    $user_id = $update->message->from->id;
    $name = $update->message->from->first_name;
    $reply = $update->message->reply_to_message;
    $reply_msg_id = $update->message->reply_to_message->message_id;
    $photo = $update->message->reply_to_message->photo;
    $audio = $update->message->reply_to_message->audio;
    $document = $update->message->reply_to_message->document;
    $video = $update->message->reply_to_message->video;
    $voice = $update->message->reply_to_message->voice;
    $sticker = $update->message->reply_to_message->sticker;
    $ch = str_replace('@', '', $channel);
    if ($photo != null) {$file_id = $photo[count($photo)-1]->file_id;}
    elseif ($audio != null) {$file_id = $audio->file_id;}
    elseif ($document != null) {$file_id = $document->file_id;}
    elseif ($video != null) {$file_id = $video->file_id;}
    elseif ($voice != null) {$file_id = $voice->file_id;}
    elseif ($sticker != null) {$file_id = $sticker->file_id;}
    define('API_TELEGRAM', 'https://api.telegram.org/bot'.TOKEN.'/');
    function bot($method,$fields)
    {$url = API_TELEGRAM.$method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $answer = curl_exec($ch);
    curl_close($ch);}
    function sendAction($chat_id,$action) {$fields = array('chat_id'=>$chat_id,'action'=>$action); bot('sendAction',$fields);}
    function sendMessage($chat_id,$message,$message_id) {$fields = array('chat_id'=>$chat_id,'text'=>$message,'reply_to_message_id'=>$message_id,'parse_mode'=>'Markdown'); bot('sendMessage',$fields);}


    if ($photo != null && $reply != null)
    {$photo_id = json_decode(urldecode(file_get_contents(API_TELEGRAM.'sendPhoto?chat_id='.$channel.'&photo='.$file_id)))->result->message_id;
    sendMessage($chat_id,'[‌](https://tlgrm.me/'.$ch.'/'.$photo_id.')'.$msg_text);}
    elseif ($audio != null && $reply != null)
        {$audio_id = json_decode(urldecode(file_get_contents(API_TELEGRAM.'sendAudio?chat_id='.$channel.'&audio='.$file_id)))->result->message_id;
    sendMessage($chat_id,'[‌](https://tlgrm.me/'.$ch.'/'.$audio_id.')'.$msg_text);}
    elseif ($document != null && $reply != null)
        {$document_id = json_decode(urldecode(file_get_contents(API_TELEGRAM.'sendDocument?chat_id='.$channel.'&document='.$file_id)))->result->message_id;
    sendMessage($chat_id,'[‌](https://tlgrm.me/'.$ch.'/'.$document_id.')'.$msg_text);}
    elseif ($video != null && $reply != null)
        {$video_id = json_decode(urldecode(file_get_contents(API_TELEGRAM.'sendVideo?chat_id='.$channel.'&video='.$file_id)))->result->message_id;
    sendMessage($chat_id,'[‌](https://tlgrm.me/'.$ch.'/'.$video_id.')'.$msg_text);}
    elseif ($voice != null && $reply != null)
        {$voice_id = json_decode(urldecode(file_get_contents(API_TELEGRAM.'sendVoice?chat_id='.$channel.'&voice='.$file_id)))->result->message_id;
    sendMessage($chat_id,'[‌](https://tlgrm.me/'.$ch.'/'.$voice_id.')'.$msg_text);}
    elseif ($sticker != null && $reply != null)
        {$sticker_id = json_decode(urldecode(file_get_contents(API_TELEGRAM.'sendSticker?chat_id='.$channel.'&sticker='.$file_id)))->result->message_id;
    sendMessage($chat_id,'[‌](https://tlgrm.me/'.$ch.'/'.$sticker_id.')'.$msg_text);}

?>
