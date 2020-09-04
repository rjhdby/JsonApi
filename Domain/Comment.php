<?php
declare(strict_types=1);

namespace Domain;

final class Comment
{
    public string $id;
    public string $body;
    public Author $author;

    public function __construct(string $id, string $body, Author $author)
    {
        $this->id = $id;
        $this->body = $body;
        $this->author = $author;
    }
}