<?php

namespace JsonApi\Serialize;

use JsonApi\Links;
use JsonApi\Relation;

interface Serializer
{
    public function getId($target): string;

    public function getAttributes($target): array;

    public function getLinks($target): Links;

    /**
     * @param             $target
     *
     * @param string|null $rootPath
     * @return Relation[]
     */
    public function getRelations($target, ?string $rootPath = null): array;

    public function getType(): string;
}