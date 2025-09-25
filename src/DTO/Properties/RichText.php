<?php

namespace Flowgistics\PhpNotionClient\DTO\Properties;

use Flowgistics\PhpNotionClient\DTO\Annotation;
use Flowgistics\PhpNotionClient\DTO\Equation;
use Flowgistics\PhpNotionClient\DTO\Mention;
use Flowgistics\PhpNotionClient\DTO\Text;
use Flowgistics\PhpNotionClient\Enums\RichTextType;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

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

    public static function fromArray(array $array): self
    {
        return new self(
            type: RichTextType::from($array['type']),
            plainText: $array['plain_text'],
            equitation: isset($array['equitation']) ? Equation::fromArray($array['equitation']) : null,
            mention: isset($array['mention']) ? Mention::fromArray($array['mention']) : null,
            text: isset($array['text']) ? Text::fromArray($array['text']) : null,
            annotation: isset($array['annotations']) ? Annotation::fromArray($array['annotations']) : null,
            href: $array['href'],
        );
    }

    public function toArray(): array
    {
        return [
            'rich_text' => $this->mapData(),
        ];
    }

    protected function mapData(): array
    {
        $result = [];

        // Add the type-specific content
        switch ($this->type) {
            case RichTextType::Text:
                if ($this->text) {
                    $result['text'] = $this->text instanceof Arrayable
                        ? $this->text->toArray()
                        : $this->text;
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
