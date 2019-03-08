<?php
declare(strict_types=1);

namespace mailform;


final class Message
{
    private $name;
    private $email;
    private $contents;

    public function __construct($name, $contents, $email)
    {
        $this->name = FormHelper::filterUserInput($name);
        $this->contents = FormHelper::filterUserInput($contents);
        $this->email = Email::fromString(FormHelper::filterUserInput($email));
    }

    public function isValid()
    {
        return !empty($this->getContents()) && !empty($this->getEmail()) && !empty($this->getName()) && $this->email->isValid();
    }

    public function getContents()
    {
        return $this->contents;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getName()
    {
        return $this->name;
    }

}
