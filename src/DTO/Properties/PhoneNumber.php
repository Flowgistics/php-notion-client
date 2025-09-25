<?php

namespace Flowgistics\PhpNotionClient\DTO\Properties;

use Illuminate\Contracts\Support\Arrayable;

class PhoneNumber implements Arrayable
{
    public const string TYPE = 'phone_number';

    public function __construct(
        public string $phoneNumber,
    ) {}

    public static function fromArray(array $array): self
    {
        return new self(
            phoneNumber: $array['phoneNumber'],
        );
    }

    public function toArray(): array
    {
        return [
            'type' => self::TYPE,
            'phoneNumber' => $this->phoneNumber,
        ];
    }
}
