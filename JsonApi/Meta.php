<?php
declare(strict_types=1);

namespace JsonApi;

use JsonSerializable;

final class Meta implements JsonSerializable
{
    public function jsonSerialize()
    {
        return array_filter((array) $this, fn($it) => $it !== null);
    }
}