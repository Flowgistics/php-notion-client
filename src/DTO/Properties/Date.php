<?php

namespace Flowgistics\PhpNotionClient\DTO\Properties;

use Illuminate\Contracts\Support\Arrayable;

class Date implements Arrayable
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

    public function toArray(): array
    {
        return [
            'type' => self::TYPE,
            'start' => $this->start,
            'end' => $this->end,
        ];
    }
}
