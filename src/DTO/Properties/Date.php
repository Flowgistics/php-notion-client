<?php

namespace Flowgistics\PhpNotionClient\DTO\Properties;

class Date
{
    public const string TYPE = 'date';

    public function __construct(
        public string $start,
        public ?string $end,
    ) {}

    public static function fromArray(array $array): self
    {
        return new self(
            start: $array['start'],
            end: $array['end'],
        );
    }
}
