<?php
header('Access-Control-Allow-Origin: *');
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

if (isset($_POST['name']))    {$name = trim($_POST['name']);} else {$name = '';}
if (isset($_POST['phone']))   {$phone = trim($_POST['phone']);} else {$phone = '';}
if (isset($_POST['mail']))    {$mail = trim($_POST['mail']);} else {$mail = '';}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($name || $phone || $mail ) {

    $title = 'Заявка с сайта http://proexport.tr';
    $subject = $title;
    $emailTo = "info@proexport.tr";
    //$emailTo = "gakman@irobs.ru";
        
    $body  = '
        <html>
            <head>
                <title>'.$title.'</title>
            </head>
            <body>
                <p>Имя:     '.$name.'</p>
                <br>
                <p>Телефон: '.$phone.'</p>
                <br>
                <p>Почта:   '.$mail.'</p>
            </body>
        </html>
    ';
                
    $headers= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: system@proexport.tr <proexport.tr>\r\n"; 
    
    $NewMail = new PHPMailer(true);
    $NewMail->CharSet = 'UTF-8';
        
    // Настройки SMTP
    $NewMail->isSMTP();
    $NewMail->SMTPAuth = true;
    $NewMail->SMTPDebug = 0;
    //smtp.yandex.ru            
    $NewMail->Host = 'ssl://smtp.jino.ru';
    $NewMail->Port = 465;
    $NewMail->Username = 'system@proexport.tr';
    $NewMail->Password = 'secret';
                
    // От кого
    $NewMail->setFrom('system@proexport.tr', 'proexport.tr');		
                
    // Кому
    $NewMail->addAddress($emailTo, '');
                
    // Тема письма
    $NewMail->Subject = $subject;
                
    // Тело письма
    $NewMail->msgHTML($body);
                
    $NewMail->send();

    echo 'json_encode($_POST)';

}

?>