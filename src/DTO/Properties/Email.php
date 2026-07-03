<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\DTO\Properties;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
class Email implements Arrayable
{
    public const string TYPE = 'email';

    public function __construct(
        public ?string $email,
    ) {}

    /**
     * @param array<mixed, mixed> $array
     */
    public static function fromArray(array $array): self
    {
        return new self(
            email: is_string($array['email'] ?? null) ? $array['email'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'type'  => self::TYPE,
            'email' => $this->email,
        ];
    }
}
