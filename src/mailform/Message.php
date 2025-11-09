<?php

declare(strict_types=1);

namespace mailform;

final class Message
{
    private $_name;
    private $_email;
    private $_contents;

    public function __construct($name, $contents, $email)
    {
        $this->_name = FormHelper::filterUserInput($name);
        $this->_contents = FormHelper::filterUserInput($contents);
        $this->_email = Email::fromString(FormHelper::filterUserInput($email));
    }

    public function isValid(): bool
    {
        return !$this->hasContentsErrors() && !$this->hasNameErrors() && !$this->hasMailErrors();
    }

    public function hasContentsErrors(): bool
    {
        return empty($this->getContents());
    }

    public function getContents(): string
    {
        return $this->_contents;
    }

    public function hasNameErrors(): bool
    {
        return empty($this->getName());
    }

    public function getName(): string
    {
        return $this->_name;
    }

    public function hasMailErrors(): bool
    {
        return empty($this->getEmail()) || !$this->getEmail()->isValid();
    }

    public function getEmail(): Email
    {
        return $this->_email;
    }
}
