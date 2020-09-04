<?php
declare(strict_types=1);

namespace JsonApi\Serialize;

use Domain\Comment;
use JsonApi\Links;
use JsonApi\Relation;

final class CommentSerializer implements Serializer
{
    /**
     * @param Comment $target
     *
     * @return string
     */
    public function getId($target): string
    {
        return $target->id;
    }

    /**
     * @param Comment $target
     *
     * @return array
     */
    public function getAttributes($target): array
    {
        return ['body' => $target->body];
    }

    /**
     * @param Comment $target
     *
     * @return Links
     */
    public function getLinks($target): Links
    {
        return new Links("http://example.com/comments/" . $target->id);
    }

    /**
     * @param Comment     $target
     * @param string|null $rootPath
     *
     * @return array
     */
    public function getRelations($target, ?string $rootPath = null): array
    {
        return array_filter(["author" => new Relation([$target->author], $rootPath)]);
    }

    public function getType(): string
    {
        return 'comments';
    }
}