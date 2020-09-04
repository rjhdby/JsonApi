<?php
declare(strict_types=1);

namespace JsonApi\Serialize;

use Domain\Article;
use JsonApi\Links;
use JsonApi\Relation;

final class ArticleSerializer implements Serializer
{
    /**
     * @param Article $target
     *
     * @return string
     */
    public function getId($target): string
    {
        return $target->id;
    }

    /**
     * @param Article $target
     *
     * @return array
     */
    public function getAttributes($target): array
    {
        return ["title" => $target->title];
    }

    /**
     * @param Article $target
     *
     * @return Links
     */
    public function getLinks($target): Links
    {
        return new Links("http://example.com/articles/1");
    }

    /**
     * @param Article     $target
     * @param string|null $rootPath
     *
     * @return Relation[]
     */
    public function getRelations($target, ?string $rootPath = null): array
    {
        return array_filter([
            "author"   => new Relation([$target->author], $rootPath),
            'comments' => new Relation($target->comments, $rootPath),
        ]);
    }

    public function getType(): string
    {
        return 'articles';
    }
}