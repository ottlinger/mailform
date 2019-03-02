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
        $this->name = htmlspecialchars(trim($name));
        $this->contents = htmlspecialchars(trim($contents));
        $this->email = Email::fromString(htmlspecialchars(trim($email)));
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

    public function isValid()
    {
        return !empty($this->getContents()) && !empty($this->getEmail()) && !empty($this->getName());
    }

}
