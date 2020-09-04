<?php
declare(strict_types=1);

namespace Domain;

class People
{
    public string $id;
    public ?string $firstName = null;
    public ?string $lastName = null;
    public ?string $twitter = null;

    public function __construct(string $id, ?string $firstName, ?string $lastName, ?string $twitter)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->twitter = $twitter;
    }
}