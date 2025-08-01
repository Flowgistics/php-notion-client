<?php

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

    public static function fromArray(array $array): Annotation
    {
        return new self(
            bold: $array['bold'],
            italic: $array['italic'],
            underline: $array['underline'],
            strikethrough: $array['strikethrough'],
            code: $array['code'],
            color: $array['color'],
        );
    }
}
