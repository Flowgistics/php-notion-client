<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\DTO\Properties;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
class Number implements Arrayable
{
    public const string TYPE = 'number';

    public function __construct(
        public int|float|null $number,
    ) {}

    public static function fromNumber(int|float|null $number): self
    {
        return new self(
            number: $number,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'type'   => self::TYPE,
            'number' => $this->number,
        ];
    }
}
