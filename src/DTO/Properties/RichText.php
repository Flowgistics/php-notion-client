<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\DTO\Properties;

use Flowgistics\PhpNotionClient\DTO\Annotation;
use Flowgistics\PhpNotionClient\DTO\Equation;
use Flowgistics\PhpNotionClient\DTO\Mention;
use Flowgistics\PhpNotionClient\DTO\Text;
use Flowgistics\PhpNotionClient\Enums\RichTextType;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 *
 * @phpstan-consistent-constructor
 */
class RichText implements Arrayable
{
    public const string TYPE = 'rich_text';

    public function __construct(
        public RichTextType $type,
        public string       $plainText,
        public ?Equation    $equitation = null,
        public ?Mention     $mention = null,
        public ?Text        $text = null,
        public ?Annotation  $annotation = null,
        public ?string      $href = null,
    ) {}

    /**
     * @param array<mixed, mixed> $array
     */
    public static function fromArray(array $array): static
    {
        $type = RichTextType::tryFrom(is_string($array['type'] ?? null) ? $array['type'] : '') ?? RichTextType::Text;

        return new static(
            type: $type,
            plainText: is_string($array['plain_text'] ?? null) ? $array['plain_text'] : '',
            equitation: is_array($array['equation'] ?? null) ? Equation::fromArray($array['equation']) : null,
            mention: is_array($array['mention'] ?? null) ? Mention::fromArray($array['mention']) : null,
            text: is_array($array['text'] ?? null) ? Text::fromArray($array['text']) : null,
            annotation: is_array($array['annotations'] ?? null) ? Annotation::fromArray($array['annotations']) : null,
            href: is_string($array['href'] ?? null) ? $array['href'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'rich_text' => $this->mapData(),
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function mapData(): array
    {
        $result = [];

        // Add the type-specific content
        switch ($this->type) {
            case RichTextType::Text:
                if ($this->text) {
                    $result['text'] = $this->text->toArray();
                }
                break;

            case RichTextType::Mention:
                if ($this->mention) {
                    $result['mention'] = $this->mention instanceof Arrayable
                        ? $this->mention->toArray()
                        : $this->mention;
                }
                break;

            case RichTextType::Equation:
                if ($this->equitation) {
                    $result['equation'] = $this->equitation instanceof Arrayable
                        ? $this->equitation->toArray()
                        : $this->equitation;
                }
                break;
        }

        // Add common properties
        $result['type'] = $this->type->value;
        $result['plain_text'] = $this->plainText;

        // Add optional properties
        if ($this->annotation) {
            $result['annotations'] = $this->annotation instanceof Arrayable
                ? $this->annotation->toArray()
                : $this->annotation;
        }

        if ($this->href) {
            $result['href'] = $this->href;
        }

        return [$result];
    }
}
