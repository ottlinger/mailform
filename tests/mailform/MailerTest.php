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

    public function testCreationWithImplicitNoSendOut()
    {
        $message = new Message("MyName   ", " ÄMyContents", "foo@bar.com ");
        $mailer = new Mailer($message);
        $this->assertFalse($mailer->isSendOut());
    }

    public function testMailTextCreationAndNotSending()
    {
        $message = new Message("MyName   ", " ÄMyContents", "foo@bar.com ");
        $mailer = new Mailer($message);
        $mailer->send();
        // https://github.com/sebastianbergmann/phpunit-documentation/issues/171
        // prevent warning about test without assertions
        $this->addToAssertionCount(1);
    }

    public function testMailTextGeneration()
    {
        $message = new Message("MyName   ", " ÄMyContents", "foo@bar.com ");
        $mailer = new Mailer($message);
        $mailtext = $mailer->getMailText();
        $this->assertStringContainsString("MyName", $mailtext);
        $this->assertStringContainsString("ÄMyContents", $mailtext);
        // fallback due to missing global variables
        $this->assertStringContainsString("none", $mailtext);
    }

    public function testMailTextGenerationWithVariablesSet()
    {
        $_SERVER['HTTP_USER_AGENT'] = " MySpecialAgent    ";
        $_SERVER['REMOTE_ADDR'] = " 127.0.0.1    ";

        $message = new Message("MyName   ", " ÄMyContents", "foo@bar.com ");
        $mailer = new Mailer($message);
        $mailtext = $mailer->getMailText();
        $this->assertStringContainsString("MyName", $mailtext);
        $this->assertStringContainsString("ÄMyContents", $mailtext);
        $this->assertStringContainsString("127.0.0.1", $mailtext);
        $this->assertStringContainsString("MySpecialAgent", $mailtext);
        $this->assertNotEmpty($mailtext);
    }

    public function testMailSendingWithGlobalVariablesSet()
    {
        $_SERVER['SERVER_NAME'] = "myhost-cibuild";

        $message = new Message("MyName   ", " ÄMyContents", "foo@bar.com ");
        $mailer = new Mailer($message);
        $mailer->send();
        // https://github.com/sebastianbergmann/phpunit-documentation/issues/171
        // prevent warning about test without assertions
        $this->addToAssertionCount(1);
    }

    public function testRandomConfigurationKeyReturnsEmptyString()
    {
        $this->assertEquals('', Mailer::getFromConfiguration("doesNotExistHopefullyInTests"));
    }

    public function testMailTextGenerationFromTemplatesWithVariablesSet()
    {
        $_SERVER['HTTP_USER_AGENT'] = " MySpecialAgent    ";
        $_SERVER['REMOTE_ADDR'] = " 127.0.0.1    ";

        $message = new Message("MyName   ", " MyContents", "foo@bar.com ");
        $mailer = new Mailer($message);
        $mailtext = $mailer->getRequestMailText();

        $this->assertStringContainsString("MyName", $mailtext);
        $this->assertStringContainsString("MyContents", $mailtext);
        $this->assertStringContainsString("127.0.0.1", $mailtext);
        $this->assertStringContainsString("MySpecialAgent", $mailtext);
        $this->assertNotEmpty($mailtext);
    }
}
