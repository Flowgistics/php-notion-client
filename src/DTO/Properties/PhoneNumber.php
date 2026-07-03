<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\DTO\Properties;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
class PhoneNumber implements Arrayable
{
    public const string TYPE = 'phone_number';

    public function __construct(
        public ?string $phoneNumber,
    ) {}

    /**
     * @param array<mixed, mixed> $array
     */
    public static function fromArray(array $array): self
    {
        $phoneNumber = $array['phone_number'] ?? $array['phoneNumber'] ?? null;

        return new self(
            phoneNumber: is_string($phoneNumber) ? $phoneNumber : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'type'         => self::TYPE,
            'phone_number' => $this->phoneNumber,
        ];
    }
}
