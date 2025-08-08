<?php

namespace Flowgistics\PhpNotionClient\DTO\Properties;

class Relation
{
    public const string TYPE = 'relation';

    public function __construct(
        public string $id,
    ) {}

    public static function fromArray(array $array): self
    {
        return new self(
            id: $array['id'],
        );
    }
}
