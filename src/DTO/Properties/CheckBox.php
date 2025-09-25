<?php

namespace Flowgistics\PhpNotionClient\DTO\Properties;

use Illuminate\Contracts\Support\Arrayable;

class CheckBox implements Arrayable
{
    public const string TYPE = 'checkbox';

    public function __construct(
        public bool $checkbox,
    ) {}

    public static function fromArray(array $array): self
    {
        return new self(
            checkbox: $array['checkbox'],
        );
    }

    public function toArray(): array
    {
        return [
            'type'     => self::TYPE,
            'checkbox' => $this->checkbox,
        ];
    }
}
