<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\DTO;

use Flowgistics\PhpNotionClient\Enums\Color;

class Annotation
{
    public function __construct(
        public bool $bold,
        public bool $italic,
        public bool $underline,
        public bool $strikethrough,
        public bool $code,
        public Color $color,
    ) {}

    /**
     * @param array<mixed, mixed> $array
     */
    public static function fromArray(array $array): Annotation
    {
        return new self(
            bold: (bool) ($array['bold'] ?? false),
            italic: (bool) ($array['italic'] ?? false),
            underline: (bool) ($array['underline'] ?? false),
            strikethrough: (bool) ($array['strikethrough'] ?? false),
            code: (bool) ($array['code'] ?? false),
            color: Color::tryFrom(is_string($array['color'] ?? null) ? $array['color'] : '') ?? Color::default,
        );
    }
}
