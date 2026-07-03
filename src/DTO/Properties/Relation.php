<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\DTO\Properties;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
class Relation implements Arrayable
{
    public const string TYPE = 'relation';

    /**
     * @param array<int, array{id: string}> $relation
     */
    public function __construct(
        public array $relation,
    ) {}

    /**
     * @param array<mixed, mixed> $array
     */
    public static function fromArray(array $array): self
    {
        return new self(
            relation: array_values(array_filter(array_map(
                static fn(mixed $item): ?array => is_array($item) && is_string($item['id'] ?? null) ? ['id' => $item['id']] : null,
                $array,
            ))),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            "relation" => [$this->relation],
            "type"     => self::TYPE,
        ];
    }
}
