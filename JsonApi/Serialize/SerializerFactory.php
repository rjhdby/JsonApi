<?php
declare(strict_types=1);

namespace JsonApi\Serialize;

use Domain\Article;
use Domain\Author;
use Domain\Comment;

final class SerializerFactory
{
    public static function getSerializer($object): ?Serializer
    {
        switch (get_class($object)) {
            case Article::class:
                return new ArticleSerializer();
            case Author::class:
                return new PeopleSerializer();
            case Comment::class:
                return new CommentSerializer();
            default:
                return null;
        }
    }
}