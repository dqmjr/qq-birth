<?php
$file = 'birthday.txt';
$lines = file($file);

$tomorrow = (new DateTime())->modify('+1 day')->format('d.m');
$birthdayNames = [];
$response = "";

$chatId = "-1002291886697";
$botToken = "8162662641:AAHv2s5cvTz3tGJrEtyKrwrbdxKd3wLFFSE";
$url = "https://api.telegram.org/bot$botToken/sendMessage";

foreach ($lines as $line) {
    list($date, $name, $number) = explode(',', $line);
    $birthday = DateTime::createFromFormat('d.m.Y', $date)->format('d.m');

    if ($birthday === $tomorrow) {
        $birthdayNames[] = $name;
        $message = "Ертең $name туған күні. Номері: $number";

        $data = [
            'chat_id' => $chatId,
            'text' => $message
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        curl_close($ch);
    }
}

if (empty($birthdayNames)) {
    $message = "Завтра тишина";

    $data = [
        'chat_id' => $chatId,
        'text' => $message
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
}

echo $response;
?>
