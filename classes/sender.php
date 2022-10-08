<?php
//Класс для отправки сообщений в ТГ и на мыло

class Sender
{
    static function send_tg($msg)
    {
        $token = "Telegramm token here";
        #$chat_id = "1092195676"; // me
        $chat_id = "-541340962"; // group
        $txt = $msg . "%0A";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}");
        curl_exec($curl);
        curl_close($curl);
    }

    static function mailer($message, $subj)
    {
        $email = new Model_Email();
        $emailInfo = $email->getAllRows();
        $emailArray = [];
        foreach ($emailInfo as $value){
            $emailArray[] = $value['email'];
        }
        $strRecipients = implode(', ', $emailArray);

        $subject = $subj;
        $headers = array(
            'MIME-Version' => '1.0',
            'Content-type' => 'text/html; charset=utf-8',
            'From' => 'send@test.ru'
        );
        mail($strRecipients, $subject, $message, $headers);
    }
}