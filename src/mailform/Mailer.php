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
            return trim(''.$GLOBALS['mailform'][$key]);
        }
    }

    public function send()
    {
        $timestamp = date('Y-m-d H:i:s');
        $subjectLine = 'Mailform - Request received'. $timestamp;
        $mailMessage = "<html><head><title>" . $subjectLine . "</title></head>
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
               <td>" . $_SERVER['REMOTE_ADDR'] . "</td>
               </tr>
               <tr>
               <td><b>Caller-Agent:</b></td>
               <td>" . $_SERVER['HTTP_USER_AGENT'] . "</td>
               </tr>
              </table>
            </body>
            </html>";

        $header = 'MIME-Version: 1.0' . "\r\n";
        $header .= "Content-Type: text/html; charset=\"utf-8\"\r\n" . "Content-Transfer-Encoding: 8bit\r\n";
        $header .= 'From: Mailform <'.Mailer::getFromConfiguration("sender").'>' . "\r\n";
        $header .= 'X-Mailer: Mailform-PHP/' . phpversion() . "\r\n";
        $header .= "Message-ID: <" . time() . rand(1, 1000) . "_" . date('YmdHis') . "@" . $_SERVER['SERVER_NAME'] . ">" . "\r\n";

        if ($this->isSendOut() && boolval(Mailer::getFromConfiguration("sendmails"))) {
            mail((string)$this->message->getEmail(), $subjectLine, $mailMessage, $header);
            mail(Mailer::getFromConfiguration("recipient"), $subjectLine, $mailMessage, $header);

        } else {
            echo "<p>Not sending any mails.</p>";
        }
    }

    public function isSendOut()
    {
        return $this->sendOut;
    }

}
