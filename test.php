<?php
spl_autoload_register(function ($class) {
    @include(__DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, strtolower(substr($class, strlen(__NAMESPACE__)))) . '.php');
}
);

use Domain\Article;
use Domain\Author;
use Domain\Comment;
use JsonApi\DocumentBuilder;
use JsonApi\RequestSchema;

$author = new Author("9", "Dan", "Gebhardt", "dgeb");

$article = new Article("1", $author, "JSON:API paints my bikeshed!");

$article->addComment(new Comment("1", "AAAAA", $author));
$article->addComment(new Comment("2", "BBBBB", new Author("7", "Vas", "Petrovish", "vas")));

$builder = new DocumentBuilder();

$document = $builder->assemble([$article], RequestSchema::fromJson('{"include":["comments.author", "author"]}'))
                    ->addLinks(null)
                    ->addMeta(null)
                    ->getJson();

print_r($document);