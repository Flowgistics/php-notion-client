<?php

namespace Flowgistics\PhpNotionClient\DTO;

class Equation
{
    public function __construct(
        public string $expression
    ) {}

    public static function fromArray(array $array): self
    {
        return new self(
            expression: $array['expression'],
        );
    }
}
