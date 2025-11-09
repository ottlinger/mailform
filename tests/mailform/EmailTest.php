<?php

declare(strict_types=1);

use mailform\Email;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    public function testCanBeCreatedFromValidEmailAddress(): void
    {
        $this->assertInstanceOf(
            Email::class,
            Email::fromString('user@example.com')
        );
    }

    public function testIllegalMailAddressIsMarkedAsInvalid(): void
    {
        $email = Email::fromString('invalid');
        $this->assertFalse($email->isValid());
    }

    public function testValidMailAddressIsMarkedAsValid(): void
    {
        $email = Email::fromString(' user@example.com');
        $this->assertTrue($email->isValid());
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'user@example.com',
            Email::fromString('user@example.com')
        );
    }
}
