<?php
declare(strict_types=1);

namespace JsonApi;

use JsonSerializable;

final class RelatedLink implements JsonSerializable
{
    private string $href;
    private ?Meta $meta;

    public function __construct(string $href, ?Meta $meta = null)
    {
        $this->href = $href;
        $this->meta = $meta;
    }

    public function jsonSerialize()
    {
        return array_filter(
            [
                'href' => $this->href,
                'meta' => $this->meta
            ],
            fn($it) => $it !== null
        );
    }
}