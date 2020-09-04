<?php
declare(strict_types=1);

namespace JsonApi\Serialize;

use Domain\Author;
use JsonApi\Links;
use JsonApi\Relation;

final class PeopleSerializer implements Serializer
{

    /**
     * @param Author $target
     *
     * @return string
     */
    public function getId($target): string
    {
        return $target->id;
    }

    /**
     * @param Author $target
     *
     * @return array
     */
    public function getAttributes($target): array
    {
        return [
            "first-name" => $target->firstName,
            "last-name"  => $target->lastName,
            "twitter"    => $target->twitter
        ];
    }

    /**
     * @param Author $target
     * @return Links
     */
    public function getLinks($target): Links
    {
        return new Links("http://example.com/people/" . $target->id);
    }

    /**
     * @param Author      $target
     * @param string|null $rootPath
     *
     * @return Relation[]
     */
    public function getRelations($target, ?string $rootPath = null): array
    {
        return [];
    }

    public function getType(): string
    {
        return 'people';
    }
}