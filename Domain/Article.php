<?php
declare(strict_types=1);

namespace Domain;

final class Article
{
    public string $id;
    public ?Author $author = null;
    public ?string $title = null;
    /** @var Comment[] */
    public array $comments = [];

    public function __construct(string $id, ?Author $author, ?string $title)
    {
        $this->id = $id;
        $this->author = $author;
        $this->title = $title;
    }

    public function addComment(Comment $comment): void
    {
        $this->comments[] = $comment;
    }
}