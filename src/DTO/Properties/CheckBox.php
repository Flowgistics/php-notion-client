<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\DTO\Properties;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
class CheckBox implements Arrayable
{
    public const string TYPE = 'checkbox';

    public function __construct(
        public bool $checkbox,
    ) {}

    /**
     * @param array<mixed, mixed> $array
     */
    public static function fromArray(array $array): self
    {
        return new self(
            checkbox: (bool) ($array['checkbox'] ?? false),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'type'     => self::TYPE,
            'checkbox' => $this->checkbox,
        ];
    }
}
