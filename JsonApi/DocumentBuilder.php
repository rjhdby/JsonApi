<?php
declare(strict_types=1);

namespace JsonApi;

use JsonApi\Serialize\FieldsFilter;
use JsonApi\Serialize\Serializer;
use JsonApi\Serialize\SerializerFactory;

final class DocumentBuilder
{
    private Document $document;

    /** @var ResourceObject[] */
    private array $data;
    /** @var ResourceObject[] */
    private array $relations = [];

    public function assemble(array $data, ?RequestSchema $schema = null): DocumentBuilder
    {
        if ($schema === null) {
            $schema = new RequestSchema();
        }

        $this->document = new Document();

        foreach ($data as $object) {
            $serializer = SerializerFactory::getSerializer($object);
            $resource = $this->makeResourceObject($object, $serializer);
            $this->data[] = $resource;
            $this->processRelations($resource, $schema);
        }

        do {
            $hasNew = false;
            foreach ($this->relations as $resource) {
                $hasNew = $this->processRelations($resource, $schema) || $hasNew;
            }
        } while ($hasNew);

        $this->document->setData($this->data);
        $this->document->setIncluded(array_values($this->relations));

        return $this;
    }

    private function processRelations(ResourceObject $resource, RequestSchema $schema): bool
    {
        $hasNew = false;
        foreach ($resource->getRelationships() as $path => $relation) {
            $rootPath = ltrim(($relation->getRootPath() ?? "") . '.' . $path, '.');
            if ($schema->mustBeIncluded($rootPath)) {
                $hasNew = $this->appendRelation($relation, $rootPath) || $hasNew;
            }
        }

        return $hasNew;
    }

    private function appendRelation(Relation $relation, ?string $rootPath = null): bool
    {
        $hasNew = false;
        foreach ($relation->getRelationObjects() as $object) {
            $serializer = SerializerFactory::getSerializer($object);
            if ($serializer === null) {
                continue;
            }

            $hash = $serializer->getType() . '+' . $serializer->getId($object);
            if (isset($this->relations[$hash])) {
                continue;
            }

            $this->relations[$hash] = $this->makeResourceObject($object, $serializer, $rootPath);
            $hasNew = true;
        }

        return $hasNew;
    }

    private function makeResourceObject($object, Serializer $serializer, ?string $rootPath = null): ResourceObject
    {
        return new ResourceObject(
            $serializer->getId($object),
            $serializer->getType(),
            FieldsFilter::filter($serializer->getAttributes($object)),
            $this->getRelations($serializer->getRelations($object, $rootPath)),
            $serializer->getLinks($object),
            null
        );
    }

    public function addLinks(?Links $links): DocumentBuilder
    {
        $this->document->setLinks($links);

        return $this;
    }

    public function addMeta(?Meta $meta): DocumentBuilder
    {
        $this->document->setMeta($meta);

        return $this;
    }

    public function build(): Document
    {
        return $this->document;
    }

    public function getJson(): string
    {
        return json_encode($this->document, JSON_PRETTY_PRINT);
    }

    /**
     * @param Relation[] $relations
     * @return array
     */
    private function getRelations(array $relations): array
    {
        $relations = FieldsFilter::filter($relations);
        $out = [];
        /**
         * @var string   $key
         * @var Relation $value
         */
        foreach ($relations as $key => $value) {
            $objects = $value->getRelationObjects();
            if ($value->getLinks() === null && count($objects) === 1) {
                $value->setLinks(SerializerFactory::getSerializer($objects[0])->getLinks($objects[0]));
            }
            foreach ($objects as $relation) {
                $serializer = SerializerFactory::getSerializer($relation);
                $value->addData(['type' => $serializer->getType(), 'id' => $serializer->getId($relation)]);
            }
            $out[$key] = $value;
        }

        return $out;
    }
}