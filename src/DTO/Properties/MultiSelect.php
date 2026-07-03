<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\DTO\Properties;

use Flowgistics\PhpNotionClient\Enums\Color;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
class MultiSelect implements Arrayable
{
    public const string TYPE = 'multi_select';

    public function __construct(
        public string $id,
        public string $name,
        public ?Color $color,
    ) {}

    /**
     * @param array<mixed, mixed> $array
     */
    public static function fromArray(array $array): self
    {
        return new self(
            id: is_string($array['id'] ?? null) ? $array['id'] : '',
            name: is_string($array['name'] ?? null) ? $array['name'] : '',
            color: Color::tryFrom(is_string($array['color'] ?? null) ? $array['color'] : ''),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id'    => $this->id,
            'type'  => self::TYPE,
            'name'  => $this->name,
            'color' => $this->color?->value,
        ];
    }
}
