<?php
declare(strict_types=1);

namespace JsonApi;

use JsonSerializable;

final class Links implements JsonSerializable
{
    private ?string $self;
    private ?RelatedLink $related;

    public function __construct(?string $self = null, ?RelatedLink $related = null)
    {
        $this->self = $self;
        $this->related = $related;
    }

    public function jsonSerialize()
    {
        return array_filter(
            [
                'self'    => $this->self,
                'related' => $this->related
            ],
            fn($it) => $it !== null
        );
    }
}