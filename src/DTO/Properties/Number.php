<?php

namespace Flowgistics\PhpNotionClient\DTO\Properties;

class Number
{
    public const string TYPE = 'number';

    public function __construct(
        public int $number,
    ) {}

    public static function fromNumber(int $number): self
    {
        return new self(
            number: $number,
        );
    }
}
