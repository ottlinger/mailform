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

    public function send(): void
    {
        $timestamp = date('Y-m-d H:i:s');
        $subjectLine = 'Mailform - Request received' . $timestamp;

        $serverName = "localhost";
        if (FormHelper::isSetAndNotEmpty('SERVER_NAME')) {
            $serverName = FormHelper::filterUserInput($_SERVER['SERVER_NAME']);
        }

        $header = 'MIME-Version: 1.0' . "\r\n";
        $header .= "Content-Type: text/html; charset=\"utf-8\"\r\n" . "Content-Transfer-Encoding: 8bit\r\n";
        $header .= 'From: Mailform <' . Mailer::getFromConfiguration("sender") . '>' . "\r\n";
        $header .= 'X-Mailer: Mailform-PHP/' . phpversion() . "\r\n";
        $header .= "Message-ID: <" . time() . rand(1, 1000) . "_" . date('YmdHis') . "@" . $serverName . ">" . "\r\n";

        if ($this->isSendOut() && boolval(Mailer::getFromConfiguration("sendmails"))) {
            // TODO: replace by library to properly handle mail errors
            // https://github.com/PHPMailer/PHPMailer/wiki/Tutorial
            mail((string)$this->message->getEmail(), $subjectLine, $this->getMailText(), $header);
            mail(Mailer::getFromConfiguration("recipient"), $subjectLine, $this->getMailText(), $header);
        }
    }

    public static function getFromConfiguration($key): string
    {
        if ($GLOBALS['mailform'] && isset($GLOBALS['mailform'][$key])) {
            return trim('' . $GLOBALS['mailform'][$key]);
        }
        return '';
    }

    public function isSendOut(): bool
    {
        return $this->sendOut;
    }

    public function getMailText(): string
    {
        $timestamp = date('Y-m-d H:i:s');
        $subjectLine = 'Mailform - Request received ' . $timestamp;

        $userAgent = "none";
        if (FormHelper::isSetAndNotEmpty('HTTP_USER_AGENT')) {
            $userAgent = FormHelper::filterUserInput($_SERVER['HTTP_USER_AGENT']);
        }

        $remoteAddress = "none";
        if (FormHelper::isSetAndNotEmpty('REMOTE_ADDR')) {
            $remoteAddress = FormHelper::filterUserInput($_SERVER['REMOTE_ADDR']);
        }

        return "<html lang='en'><head><title>" . $subjectLine . "</title></head>
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

}
