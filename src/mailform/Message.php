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
        return !$this->hasContentsErrors() && !$this->hasNameErrors() && !$this->hasMailErrors();
    }

    public function hasContentsErrors(): bool
    {
        return empty($this->getContents());
    }

    public function getContents()
    {
        return $this->contents;
    }

    public function hasNameErrors(): bool
    {
        return empty($this->getName());
    }

    public function getName()
    {
        return $this->name;
    }

    public function hasMailErrors(): bool
    {
        return empty($this->getEmail()) || !$this->getEmail()->isValid();
    }

    public function getEmail()
    {
        return $this->email;
    }

}
