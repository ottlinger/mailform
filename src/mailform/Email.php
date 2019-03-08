<?php
declare(strict_types=1);

namespace mailform;

use phpDocumentor\Reflection\Types\Boolean;

final class Email
{
    private $email;

    private function __construct(string $email)
    {
        $this->email = FormHelper::filterUserInput($email);
    }

    public static function fromString(string $email): self
    {
        return new self($email);
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function isValid(): bool
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
}
