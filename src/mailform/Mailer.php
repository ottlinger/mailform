<?php

declare(strict_types=1);

namespace Mailform;

final class Mailer
{
    private $_message;
    private $_sendOut;

    public function __construct(Message $message, $sendOut = false)
    {
        $this->_message = $message;
        $this->_sendOut = $sendOut;
    }

    public function sendAllMails(): bool
    {
        return $this->sendInternal($this->send());
    }

    public function send(): bool
    {
        $timestamp = date('Y-m-d H:i:s');
        $subjectLine = 'Mailform - Request received '.$timestamp;

        $header = $this->_createCommonHeaders();

        if ($this->isSendOut() && boolval(Mailer::getFromConfiguration('sendmails'))) {
            return mail((string) $this->_message->getEmail(), $subjectLine, $this->getRequestMailText(), $header);
        }

        return true;
    }

    private function _createCommonHeaders(): string
    {
        $serverName = 'localhost';
        if (FormHelper::isSetAndNotEmpty('SERVER_NAME')) {
            $serverName = FormHelper::filterUserInput($_SERVER['SERVER_NAME']);
        }

        $header = 'MIME-Version: 1.0'."\r\n";
        $header .= "Content-Type: text/html; charset=\"utf-8\"\r\n"."Content-Transfer-Encoding: 8bit\r\n";
        $header .= 'From: Mailform <'.Mailer::getFromConfiguration('sender').'>'."\r\n";
        $header .= 'X-Mailer: Mailform-PHP/'.phpversion()."\r\n";
        $header .= 'Message-ID: <'.time().rand(1, 1000).'_'.date('YmdHis').'@'.$serverName.'>'."\r\n";

        return $header;
    }

    public function sendInternal($externalResult): bool
    {
        $timestamp = date('Y-m-d H:i:s');
        $subjectLine = 'Mailform - Request received '.$timestamp.' - internal recipient';

        if ($externalResult) {
            $subjectLine .= ' / mail could not be sent to requester, check mail address';
        }

        $header = $this->_createCommonHeaders();
        $header .= 'Reply-to: '.$this->_message->getName().' <'.$this->_message->getEmail().'>'."\r\n";

        if ($this->isSendOut() && boolval(Mailer::getFromConfiguration('sendmails'))) {
            return mail(Mailer::getFromConfiguration('recipient'), $subjectLine, $this->getMailText(), $header);
        }

        return true;
    }

    public static function getFromConfiguration($key): string
    {
        if ($GLOBALS['mailform'] && isset($GLOBALS['mailform'][$key])) {
            return trim(''.$GLOBALS['mailform'][$key]);
        }

        return '';
    }

    public function isSendOut(): bool
    {
        return $this->_sendOut;
    }

    public function getRequestMailText(): string
    {
        $template = file_get_contents(__DIR__.'/'.Mailer::getFromConfiguration('requesttemplate'));
        $timestamp = date('Y-m-d H:i:s');
        $subjectLine = 'Mailform - We received your request at '.$timestamp.' - thank you';

        $userAgent = 'none';
        if (FormHelper::isSetAndNotEmpty('HTTP_USER_AGENT')) {
            $userAgent = FormHelper::filterUserInput($_SERVER['HTTP_USER_AGENT']);
        }

        $remoteAddress = 'none';
        if (FormHelper::isSetAndNotEmpty('REMOTE_ADDR')) {
            $remoteAddress = FormHelper::filterUserInput($_SERVER['REMOTE_ADDR']);
        }

        $templateReplaced = str_replace('##SUBJECT', $subjectLine, $template);
        $templateReplaced = str_replace('##TIMESTAMP', $timestamp, $templateReplaced);
        $templateReplaced = str_replace('##NAME', $this->_message->getName(), $templateReplaced);
        $templateReplaced = str_replace('##MESSAGE', $this->_message->getContents(), $templateReplaced);
        $templateReplaced = str_replace('##IPADDR', $remoteAddress, $templateReplaced);
        $templateReplaced = str_replace('##AGENT', $userAgent, $templateReplaced);
        $templateReplaced = str_replace('##MAIL', $this->_message->getEmail(), $templateReplaced);

        return $templateReplaced;
    }

    public function getMailText(): string
    {
        $timestamp = date('Y-m-d H:i:s');
        $subjectLine = 'Mailform - Request received '.$timestamp;

        $userAgent = 'none';
        if (FormHelper::isSetAndNotEmpty('HTTP_USER_AGENT')) {
            $userAgent = FormHelper::filterUserInput($_SERVER['HTTP_USER_AGENT']);
        }

        $remoteAddress = 'none';
        if (FormHelper::isSetAndNotEmpty('REMOTE_ADDR')) {
            $remoteAddress = FormHelper::filterUserInput($_SERVER['REMOTE_ADDR']);
        }

        return "<html lang='en'><head><title>".$subjectLine.'</title></head>
            <body><h1>'.$subjectLine.'</h1>
              <table>
               <tr>
               <td><b>Time:</b></td>
               <td>'.$timestamp.'</td>
               </tr>
               <tr>
               <td><b>Name:</b></td>
               <td>'.$this->_message->getName().'</td>
               </tr>
               <tr>
               <td><b>Message:</b></td>
               <td>'.$this->_message->getContents().'</td>
               </tr>
               <tr>
               <td><b>Caller-IP:</b></td>
               <td>'.$remoteAddress.'</td>
               </tr>
               <tr>
               <td><b>Caller-Agent:</b></td>
               <td>'.$userAgent.'</td>
               </tr>
               <tr>
               <td><b>E-Mail:</b></td>
               <td>'.$this->_message->getEmail().'</td>
               </tr>
              </table>
            </body>
            </html>';
    }
}
