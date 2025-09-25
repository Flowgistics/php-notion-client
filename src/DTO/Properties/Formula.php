<?php

namespace Flowgistics\PhpNotionClient\DTO\Properties;

use Illuminate\Contracts\Support\Arrayable;

class Formula implements Arrayable
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

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'number' => $this->number,
            'string' => $this->string,
            'date' => $this->date,
            'boolean' => $this->boolean,
        ];
    }
}
