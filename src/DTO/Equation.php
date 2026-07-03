<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\DTO;

class Equation
{
    public function __construct(
        public string $expression,
    ) {}

    /**
     * @param array<mixed, mixed> $array
     */
    public static function fromArray(array $array): self
    {
        return new self(
            expression: is_string($array['expression'] ?? null) ? $array['expression'] : '',
        );
    }
}
