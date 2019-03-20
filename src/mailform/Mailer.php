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

    public function sendAllMails(): void
    {
        $this->send();
        $this->sendInternal();
    }

    public function send(): void
    {
        $timestamp = date('Y-m-d H:i:s');
        $subjectLine = 'Mailform - Request received ' . $timestamp;

        $header = $this->createCommonHeaders();

        if ($this->isSendOut() && boolval(Mailer::getFromConfiguration("sendmails"))) {
            // TODO: replace by library to properly handle mail errors
            // https://github.com/PHPMailer/PHPMailer/wiki/Tutorial
            mail((string)$this->message->getEmail(), $subjectLine, $this->getRequestMailText(), $header);
        }
    }

    private function createCommonHeaders(): string
    {
        $serverName = "localhost";
        if (FormHelper::isSetAndNotEmpty('SERVER_NAME')) {
            $serverName = FormHelper::filterUserInput($_SERVER['SERVER_NAME']);
        }

        $header = 'MIME-Version: 1.0' . "\r\n";
        $header .= "Content-Type: text/html; charset=\"utf-8\"\r\n" . "Content-Transfer-Encoding: 8bit\r\n";
        $header .= 'From: Mailform <' . Mailer::getFromConfiguration("sender") . '>' . "\r\n";
        $header .= 'X-Mailer: Mailform-PHP/' . phpversion() . "\r\n";
        $header .= "Message-ID: <" . time() . rand(1, 1000) . "_" . date('YmdHis') . "@" . $serverName . ">" . "\r\n";
        return $header;
    }

    public function sendInternal(): void
    {
        $timestamp = date('Y-m-d H:i:s');
        $subjectLine = 'Mailform - Request received ' . $timestamp . ' - internal recipient';

        $header = $this->createCommonHeaders();
        $header .= 'Reply-to: ' . $this->message->getName() . ' <' . $this->message->getEmail() . '>' . "\r\n";

        if ($this->isSendOut() && boolval(Mailer::getFromConfiguration("sendmails"))) {
            // TODO: replace by library to properly handle mail errors
            // https://github.com/PHPMailer/PHPMailer/wiki/Tutorial
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

    public function getRequestMailText(): string
    {
        $template = file_get_contents(__DIR__ . '/' . Mailer::getFromConfiguration('requesttemplate'));
        $timestamp = date('Y-m-d H:i:s');
        $subjectLine = 'Mailform - We received your request at ' . $timestamp . " - thank you";

        $userAgent = "none";
        if (FormHelper::isSetAndNotEmpty('HTTP_USER_AGENT')) {
            $userAgent = FormHelper::filterUserInput($_SERVER['HTTP_USER_AGENT']);
        }

        $remoteAddress = "none";
        if (FormHelper::isSetAndNotEmpty('REMOTE_ADDR')) {
            $remoteAddress = FormHelper::filterUserInput($_SERVER['REMOTE_ADDR']);
        }

        $templateReplaced = str_replace("##SUBJECT", $subjectLine, $template);
        $templateReplaced = str_replace("##TIMESTAMP", $timestamp, $templateReplaced);
        $templateReplaced = str_replace("##NAME", $this->message->getName(), $templateReplaced);
        $templateReplaced = str_replace("##MESSAGE", $this->message->getContents(), $templateReplaced);
        $templateReplaced = str_replace("##IPADDR", $remoteAddress, $templateReplaced);
        $templateReplaced = str_replace("##AGENT", $userAgent, $templateReplaced);

        return $templateReplaced;
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
