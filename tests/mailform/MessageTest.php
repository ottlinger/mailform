<?php
declare(strict_types=1);

use mailform\Message;
use PHPUnit\Framework\TestCase;

final class MessageTest extends TestCase
{
    public function testObjectCreationAndGetters()
    {
        $message = new Message("MyName   ", " ÄMyContents", "foo@bar.com ");
        $this->assertEquals("MyName", $message->getName());
        $this->assertEquals("ÄMyContents", $message->getContents());
        $this->assertEquals("foo@bar.com", $message->getEmail());
        $this->assertTrue($message->isValid());
    }

    public function testObjectWithInvalidName()
    {
        $message = new Message("", " ÄMyContents", "foo@bar.com ");
        $this->assertFalse($message->isValid());
        $this->assertTrue($message->hasNameErrors());
    }

    public function testObjectWithInvalidContents()
    {
        $message = new Message("YourName", "", "foo@bar.com ");
        $this->assertFalse($message->isValid());
        $this->assertFalse($message->hasMailErrors());
    }

    public function testObjectWithInvalidMailAddress()
    {
        $message = new Message("YourName", "MyContents", "invalid");
        $this->assertFalse($message->isValid());
        $this->assertTrue($message->hasMailErrors());
    }
}
