<?php
declare(strict_types=1);

namespace mailform;

final class Mailer
{
    private $message;
    private $sendOut;

    public function __construct(Message $message, $sendOut = false)
    {
        $this->message = $message;
        $this->sendOut = $sendOut;
    }

    public static function getFromConfiguration($key)
    {
        if ($GLOBALS['mailform'] && isset($GLOBALS['mailform'][$key])) {
            return trim('' . $GLOBALS['mailform'][$key]);
        }
    }

    public function getMailText()
    {
        $timestamp = date('Y-m-d H:i:s');
        $subjectLine = 'Mailform - Request received' . $timestamp;

        if (FormHelper::isSetAndNotEmpty('HTTP_USER_AGENT')) {
            $userAgent = FormHelper::filterUserInput($_SERVER['HTTP_USER_AGENT']);
        } else {
            $userAgent = "none";
        }

        if (FormHelper::isSetAndNotEmpty('REMOTE_ADDR')) {
            $remoteAddress = FormHelper::filterUserInput($_SERVER['REMOTE_ADDR']);
        } else {
            $remoteAddress = "none";
        }

        return "<html><head><title>" . $subjectLine . "</title></head>
            <body><h1>" . $subjectLine . "</h1>
              <table>
               <tr>
               <td><b>Time:</b></td>
               <td>" . $timestamp . "</td>
               </tr>
               <tr>
               <td><b>Name:</b></td>
               <td>" . $this->message->getName() . "</td>
               </tr>
               <tr>
               <td><b>Message:</b></td>
               <td>" . $this->message->getContents() . "</td>
               </tr>
               <tr>
               <td><b>Caller-IP:</b></td>
               <td>" . $remoteAddress . "</td>
               </tr>
               <tr>
               <td><b>Caller-Agent:</b></td>
               <td>" . $userAgent . "</td>
               </tr>
              </table>
            </body>
            </html>";
    }

    public function send()
    {
        $timestamp = date('Y-m-d H:i:s');
        $subjectLine = 'Mailform - Request received' . $timestamp;

        if (FormHelper::isSetAndNotEmpty('SERVER_NAME')) {
            $serverName = FormHelper::filterUserInput($_SERVER['SERVER_NAME']);
        } else {
            $serverName = "localhost";
        }

        $header = 'MIME-Version: 1.0' . "\r\n";
        $header .= "Content-Type: text/html; charset=\"utf-8\"\r\n" . "Content-Transfer-Encoding: 8bit\r\n";
        $header .= 'From: Mailform <' . Mailer::getFromConfiguration("sender") . '>' . "\r\n";
        $header .= 'X-Mailer: Mailform-PHP/' . phpversion() . "\r\n";
        $header .= "Message-ID: <" . time() . rand(1, 1000) . "_" . date('YmdHis') . "@" . $serverName . ">" . "\r\n";

        if ($this->isSendOut() && boolval(Mailer::getFromConfiguration("sendmails"))) {
            mail((string)$this->message->getEmail(), $subjectLine, $this->getMailText(), $header);
            mail(Mailer::getFromConfiguration("recipient"), $subjectLine, $this->getMailText(), $header);
        }
    }

    public function isSendOut()
    {
        return $this->sendOut;
    }

}
