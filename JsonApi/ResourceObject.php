<?php
declare(strict_types=1);

namespace JsonApi;

use JsonSerializable;

final class ResourceObject implements JsonSerializable
{
    private string $id;
    private string $type;
    private ?array $attributes;
    /** @var Relation[] */
    private ?array $relationships;
    private ?Links $links;
    private ?Meta $meta;

    public function __construct(
        string $id,
        string $type,
        ?array $attributes,
        ?array $relationships,
        ?Links $links,
        ?Meta $meta = null
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->attributes = $attributes;
        $this->relationships = $relationships;
        $this->links = $links;
        $this->meta = $meta;
    }

    public function jsonSerialize()
    {
        return array_filter(
            [
                'id'            => $this->id,
                'type'          => $this->type,
                'attributes'    => $this->attributes === [] ? null : $this->attributes,
                'relationships' => $this->relationships === [] ? null : $this->relationships,
                'links'         => $this->links,
                'meta'          => $this->meta
            ],
            fn($it) => $it !== null
        );
    }

    public function getRelationships(): array
    {
        return $this->relationships;
    }
}