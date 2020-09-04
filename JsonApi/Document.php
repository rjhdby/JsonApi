<?php
declare(strict_types=1);

namespace JsonApi;

use JsonSerializable;

final class Document implements JsonSerializable
{
    /** @var ResourceObject[] */
    private ?array $data = null;
    private ?array $errors = null;
    private ?Meta $meta = null;
    private ?Links $links = null;
    /** @var ResourceObject[] */
    private array $included = [];

    public function jsonSerialize()
    {
        return array_filter(
            [
                'data'     => count($this->data) === 1 ? $this->data[0] : $this->data,
                'errors'   => $this->errors,
                'meta'     => $this->meta,
                'links'    => $this->links,
                'included' => $this->included
            ],
            fn($it) => $it !== null
        );
    }

    public function setMeta(?Meta $meta): void
    {
        $this->meta = $meta;
    }

    public function setLinks(?Links $links): void
    {
        $this->links = $links;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function setIncluded(array $included): void
    {
        $this->included = $included;
    }
}