<?php
declare(strict_types=1);

namespace JsonApi;

final class RequestSchema
{
    public array $include;
    public array $fields;

    public function __construct(array $include = [], array $fields = [])
    {
        $this->include = $this->makeAllVariants($include);
        $this->fields = $this->makeAllVariants($fields); //todo fields[articles]=title,body&fields[people]=name
    }

    private function makeAllVariants(array $keys): array
    {
        $allVariants = [];
        foreach ($keys as $key) {
            $paths = explode('.', $key);
            for ($i = 1; $i <= count($paths); $i++) {
                $allVariants[implode('.', array_slice($paths, 0, $i))] = true;
            }
        }
        return $allVariants;
    }

    public static function fromJson(string $json): RequestSchema
    {
        $parsed = json_decode($json, true);

        return new self($parsed['include'] ?? [], $parsed['fields'] ?? []);
    }

    public function mustBeIncluded(string $path): bool
    {
        return isset($this->include[$path]);
    }
}