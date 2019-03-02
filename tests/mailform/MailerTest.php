<?php
declare(strict_types=1);

use mailform\Mailer;
use mailform\Message;
use PHPUnit\Framework\TestCase;

final class MailerTest extends TestCase
{
    public function testCreationWithExplicitSendOut()
    {
        $message = new Message("MyName   ", " ÄMyContents", "foo@bar.com ");
        $mailer = new Mailer($message, true);
        $this->assertTrue($mailer->isSendOut());
    }
}
