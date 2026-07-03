<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\DTO;

use Flowgistics\PhpNotionClient\DTO\Properties\CheckBox;
use Flowgistics\PhpNotionClient\DTO\Properties\Date;
use Flowgistics\PhpNotionClient\DTO\Properties\Email;
use Flowgistics\PhpNotionClient\DTO\Properties\Formula;
use Flowgistics\PhpNotionClient\DTO\Properties\MultiSelect;
use Flowgistics\PhpNotionClient\DTO\Properties\Number;
use Flowgistics\PhpNotionClient\DTO\Properties\PhoneNumber;
use Flowgistics\PhpNotionClient\DTO\Properties\Relation;
use Flowgistics\PhpNotionClient\DTO\Properties\RichText;
use Flowgistics\PhpNotionClient\DTO\Properties\Title;

class Page
{
    /**
     * @param array<mixed, mixed>|null $cover
     * @param array<mixed, mixed>|null $icon
     * @param array<mixed, mixed>|null $parent
     * @param array<mixed, mixed>|null $properties
     * @param array<mixed, mixed>|null $rawProperties
     */
    public function __construct(
        public ?string                  $id,
        public ?string                  $object,
        public ?string                  $createdTime,
        public ?string                  $lastEditedTime,
        public ?User                    $createdBy,
        public ?User                    $lastEditedBy,
        public File|Emoji|External|array|null $cover,
        public File|Emoji|External|array|null $icon,
        public ?array                   $parent,
        public ?bool                    $archived,
        public ?bool                    $inTrash,
        public ?array                   $properties,
        public ?array                   $rawProperties,
        public ?string                  $url,
        public ?string                  $publicUrl,
    ) {}

    /**
     * @param array<mixed, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: self::stringOrNull($data['id'] ?? null),
            object: self::stringOrNull($data['object'] ?? null),
            createdTime: self::stringOrNull($data['created_time'] ?? null),
            lastEditedTime: self::stringOrNull($data['last_edited_time'] ?? null),
            createdBy: self::userOrNull($data['created_by'] ?? null),
            lastEditedBy: self::userOrNull($data['last_edited_by'] ?? null),
            cover: self::objectTypeOrNull($data['cover'] ?? null),
            icon: self::objectTypeOrNull($data['icon'] ?? null),
            parent: is_array($data['parent'] ?? null) ? $data['parent'] : null,
            archived: is_bool($data['archived'] ?? null) ? $data['archived'] : null,
            inTrash: is_bool($data['in_trash'] ?? null) ? $data['in_trash'] : null,
            properties: is_array($data['properties'] ?? null) ? self::getProperties($data['properties']) : null,
            rawProperties: is_array($data['properties'] ?? null) ? $data['properties'] : null,
            url: self::stringOrNull($data['url'] ?? null),
            publicUrl: self::stringOrNull($data['public_url'] ?? null),
        );
    }

    private static function stringOrNull(mixed $value): ?string
    {
        return is_string($value) ? $value : null;
    }

    private static function userOrNull(mixed $value): ?User
    {
        return is_array($value) ? User::fromArray($value) : null;
    }

    /**
     * @return File|Emoji|External|array<mixed, mixed>|null
     */
    private static function objectTypeOrNull(mixed $value): File|Emoji|External|array|null
    {
        return is_array($value) ? self::getObjectType($value) : null;
    }

    /**
     * @param array<mixed, mixed> $data
     *
     * @return File|Emoji|External|array<mixed, mixed>|null
     */
    private static function getObjectType(array $data): File|Emoji|External|array|null
    {
        if (!isset($data['type'])) {
            return null;
        }

        return match ($data['type']) {
            'file'     => is_array($data['file'] ?? null) ? File::fromArray($data['file']) : null,
            'emoji'    => isset($data['emoji']) ? Emoji::fromArray($data) : null,
            'external' => is_array($data['external'] ?? null) ? External::fromArray($data['external']) : null,
            default    => $data,
        };
    }

    /**
     * @param array<mixed, mixed> $properties
     *
     * @return array<mixed, mixed>
     */
    private static function getProperties(array $properties): array
    {
        return array_map(
            static fn(mixed $property): mixed => is_array($property) ? self::getPropertyValue($property) : $property,
            $properties,
        );
    }

    /**
     * @param array<mixed, mixed> $property
     */
    private static function getPropertyValue(array $property): mixed
    {
        try {
            return match ($property['type'] ?? null) {
                RichText::TYPE     => ($richText = self::firstArrayItem($property['rich_text'] ?? null)) ? RichText::fromArray($richText) : null,
                Title::TYPE        => ($title = self::firstArrayItem($property['title'] ?? null)) ? Title::fromArray($title) : null,
                CheckBox::TYPE     => CheckBox::fromArray($property),
                Date::TYPE         => isset($property['date']) && is_array($property['date']) ? Date::fromArray($property['date']) : null,
                Email::TYPE        => Email::fromArray($property),
                Formula::TYPE      => isset($property['formula']) && is_array($property['formula']) ? Formula::fromArray($property['formula']) : null,
                MultiSelect::TYPE  => array_map(
                    static fn(array $option): MultiSelect => MultiSelect::fromArray($option),
                    self::arrayItems($property['multi_select'] ?? null),
                ),
                Number::TYPE       => Number::fromNumber(self::numberOrNull($property['number'] ?? null)),
                PhoneNumber::TYPE  => PhoneNumber::fromArray($property),
                Relation::TYPE     => is_array($property['relation'] ?? null) && $property['relation'] !== [] ? Relation::fromArray($property['relation']) : null,
                'created_by'       => is_array($property['created_by'] ?? null) ? User::fromArray($property['created_by']) : null,
                'created_time'     => $property['created_time'] ?? null,
                'files'            => $property['files'] ?? [],
                'last_edited_by'   => is_array($property['last_edited_by'] ?? null) ? User::fromArray($property['last_edited_by']) : null,
                'last_edited_time' => $property['last_edited_time'] ?? null,
                'people'           => array_map(
                    static fn(array $user): User => User::fromArray($user),
                    self::arrayItems($property['people'] ?? null),
                ),
                'rollup'           => $property['rollup'] ?? null,
                'select'           => isset($property['select']) && is_array($property['select']) ? MultiSelect::fromArray($property['select']) : null,
                'status'           => isset($property['status']) && is_array($property['status']) ? MultiSelect::fromArray($property['status']) : null,
                'url'              => $property['url'] ?? null,
                'unique_id'        => $property['unique_id'] ?? null,
                'verification'     => $property['verification'] ?? null,
                default            => $property,
            };
        } catch (\Throwable) {
            return $property;
        }

    }

    /**
     * @return array<mixed, mixed>|null
     */
    private static function firstArrayItem(mixed $value): ?array
    {
        if (!is_array($value)) {
            return null;
        }

        $first = reset($value);

        return is_array($first) ? $first : null;
    }

    /**
     * @return array<int, array<mixed, mixed>>
     */
    private static function arrayItems(mixed $value): array
    {
        if (!is_array($value)) {
            return [];
        }

        return array_values(array_filter($value, static fn(mixed $item): bool => is_array($item)));
    }

    private static function numberOrNull(mixed $value): int|float|null
    {
        return is_int($value) || is_float($value) ? $value : null;
    }

    public function getProperty(string $propertyName): mixed
    {
        if (!$this->properties || !array_key_exists($propertyName, $this->properties)) {
            return null;
        }

        return $this->properties[$propertyName];
    }
}
