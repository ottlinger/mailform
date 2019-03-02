<?php
declare(strict_types=1);

use Mailform\Email;
use Mailform\Message;
use PHPUnit\Framework\TestCase;

final class MessageTest extends TestCase
{
    public function testCannotBeCreatedFromInvalidEmailAddress(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Email::fromString('invalid');
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'user@example.com',
            Email::fromString('user@example.com')
        );
    }

    public function testObjectCreationAndGetters()
    {
        $message = new Message("MyName", "MyContents", "foo@bar.com");
        $this->assertEquals("MyName", $message->getName());
    }
}
