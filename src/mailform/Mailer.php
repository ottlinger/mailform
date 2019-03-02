<?php
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

    public function isSendOut()
    {
        return $this->sendOut;
    }

}


