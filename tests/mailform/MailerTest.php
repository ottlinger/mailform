<?php
declare(strict_types=1);

use mailform\Email;
use mailform\Message;
use PHPUnit\Framework\TestCase;

final class MailerTest extends TestCase
{
    public function testObjectCreationAndGetters()
    {
        $message = new Message("MyName   ", " ÄMyContents", "foo@bar.com ");
        $this->assertEquals("MyName", $message->getName());
        $this->assertEquals("ÄMyContents", $message->getContents());
        $this->assertEquals("foo@bar.com", $message->getEmail());
        $this->assertTrue($message->isValid());
    }
}
