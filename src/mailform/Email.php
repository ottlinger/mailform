<?php

declare(strict_types=1);

namespace mailform;

final class Email
{
    private $_email;

    private function __construct(string $email)
    {
        $this->_email = FormHelper::filterUserInput($email);
    }

    public static function fromString(string $email): self
    {
        return new self($email);
    }

    public function __toString(): string
    {
        return $this->_email;
    }

    public function isValid(): bool
    {
        if (!filter_var($this->_email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }
}
