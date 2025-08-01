<?php

namespace Flowgistics\PhpNotionClient\DTO\Properties;

class Formula
{
    public const string TYPE = 'formula';

    public function __construct(
        public string $type,
        public ?int $number = null,
        public ?string $string = null,
        public ?string $date = null,
        public ?bool $boolean = null,
    ) {}

    public static function fromArray(array $array): self
    {
        return new self(
            type: $array['type'],
            number: $array['number'] ?? null,
            string: $array['string'] ?? null,
            date: $array['date'] ?? null,
            boolean: $array['boolean'] ?? null,
        );
    }
}
