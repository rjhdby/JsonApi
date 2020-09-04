<?php
declare(strict_types=1);

namespace JsonApi;

use JsonSerializable;

final class Relation implements JsonSerializable
{
    private array $relationObjects;

    private ?Links $links;
    private ?Meta $meta;
    private array $data = [];

    private ?string $rootPath;

    public function __construct(array $relationObjects, string $rootPath = null, ?Links $links = null, ?Meta $meta = null)
    {
        $this->links = $links;
        $this->rootPath = $rootPath;
        $this->meta = $meta;
        $this->relationObjects = $relationObjects;
    }

    public function getRelationObjects(): array
    {
        return $this->relationObjects;
    }

    public function jsonSerialize()
    {
        return array_filter(
            [
                'data'  => $this->data,
                'meta'  => $this->meta,
                'links' => $this->links
            ],
            fn($it) => $it !== null
        );
    }

    public function setLinks(?Links $links): void
    {
        $this->links = $links;
    }

    public function getLinks(): ?Links
    {
        return $this->links;
    }

    public function addData($object): void
    {
        $this->data[] = $object;
    }

    public function getRootPath(): ?string
    {
        return $this->rootPath;
    }
}