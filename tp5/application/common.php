<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 通用化API接口数据输出
 * @param int $status 业务状态码
 * @param string $message 信息提示
 * @param [] $data  数据
 * @param int $httpCode http状态码
 * @return array
 */

//use phpmailer\phpmailer\PHPMailer;
//use phpmailer\phpmailer\Exception;

use \think\Loader;
Loader::import('phpmailer/phpmailer/src/PHPMailer',EXTEND_PATH);
Loader::import('phpmailer/phpmailer/src/Exceptions',EXTEND_PATH);
Loader::import('phpmailer/phpmailer/src/OAuth',EXTEND_PATH);
Loader::import('phpmailer/phpmailer/src/POP3',EXTEND_PATH);
Loader::import('phpmailer/phpmailer/src/SMTP',EXTEND_PATH);

function show($status, $message, $data=[], $httpCode=200) {

    $data = [
        'code' => $status,
        'message' => $message,
        'data' => $data,
    ];

    return json($data, $httpCode);
}


function email($to, $title, $content)
{
    $mail = new PHPMailer(true);
    try {
        //Server settings

        // 设置为0看不到输出信息
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->CharSet = 'utf-8';
        //发件人邮箱端口
        $mail->Host = 'smtp.163.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        // 发件人邮箱
        $mail->Username = 'm1373667351@163.com';                 // SMTP username
        // 邮箱授权码
        $mail->Password = 'qq5691372';                           // SMTP password
        //发送方式
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        //端口号
        $mail->Port = 465;                                    // TCP port to connect to

        //Recipients
        //发件人邮箱
        $mail->setFrom('m1373667351@163.com', '你好');
        // $to 收件人邮箱
        $mail->addAddress($to);     // Add a recipient

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $title;
        $mail->Body    = $content;

        return $mail->send();

    } catch (Exception $e) {
        exception($mail->ErrorInfo);
    }
}