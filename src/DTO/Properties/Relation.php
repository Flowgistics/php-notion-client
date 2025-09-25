<?php

namespace Flowgistics\PhpNotionClient\DTO\Properties;

use Illuminate\Contracts\Support\Arrayable;

class Relation implements Arrayable
{
    public const string TYPE = 'relation';

    public function __construct(
        public array $relation,
    ) {}

    public static function fromArray(array $array): self
    {
        return new self(
            relation: array_map(fn($item) => ["id" => $item["id"]], $array),
        );
    }

    public function toArray(): array
    {
        return [
            "relation" => [$this->relation],
            "type" => self::TYPE,
        ];
    }
}
