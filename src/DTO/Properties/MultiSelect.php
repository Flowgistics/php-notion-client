<?php

namespace Flowgistics\PhpNotionClient\DTO\Properties;

use Flowgistics\PhpNotionClient\Enums\Color;

class MultiSelect
{
    public const string TYPE = 'multi_select';

    public function __construct(
        public string $id,
        public string $name,
        public Color $color,
    ) {}

    public static function fromArray(array $array): self
    {
        return new self(
            id: $array['id'],
            name: $array['name'],
            color: $array['color'],
        );
    }
}
