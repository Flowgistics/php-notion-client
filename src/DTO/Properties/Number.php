<?php

namespace Flowgistics\PhpNotionClient\DTO\Properties;

use Illuminate\Contracts\Support\Arrayable;

class Number implements Arrayable
{
    public const string TYPE = 'number';

    public function __construct(
        public ?int $number,
    ) {}

    public static function fromNumber(?int $number): self
    {
        return new self(
            number: $number,
        );
    }

    public function toArray(): array
    {
        return [
            'type' => self::TYPE,
            'number' => $this->number,
        ];
    }
}
