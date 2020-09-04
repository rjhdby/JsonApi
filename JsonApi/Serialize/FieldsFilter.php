<?php
declare(strict_types=1);

namespace JsonApi\Serialize;

final class FieldsFilter
{
    static function filter(array $data, ?array $fields = null): array
    {
        if ($fields === null || empty($fields)) {
            return array_filter($data, fn($value) => $value !== null);
        }
        return array_filter($data, fn($value, string $key) => $value !== null && in_array($key, $fields), ARRAY_FILTER_USE_KEY);
    }
}