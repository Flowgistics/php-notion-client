<?php

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
    public function __construct(
        public ?string                  $id,
        public ?string                  $object,
        public ?string                  $createdTime,
        public ?string                  $lastEditedTime,
        public ?User                    $createdBy,
        public ?User                    $lastEditedBy,
        public File|null|Emoji|External $cover,
        public File|null|Emoji|External $icon,
        public ?array                   $parent,
        public ?bool                    $archived,
        public ?bool                    $inTrash,
        public ?array                   $properties,
        public ?array                   $rawProperties,
        public ?string                  $url,
        public ?string                  $publicUrl,
    ) {}

    /**
     * @param array{
     *     id: string,
     *     object: string,
     *     created_time: string,
     *     last_edited_time: string,
     *     created_by: array{
     *         id: string,
     *         object: string
     *     },
     *     last_edited_by: array{
     *         id: string,
     *         object: string
     *     },
     *     cover: array{
     *         type: string
     *     },
     *     icon: array{
     *          type: string
     *      },
     *     parent: array{
     *         type: string,
     *         database_id: string
     *     },
     *     archived: bool,
     *     in_trash: bool,
     *     properties: array<string, array{
     *         id: string,
     *         type: string
     *     }>,
     *     url: string,
     *     public_url: string|null
     * } $data
     *
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            object: $data['object'],
            createdTime: $data['created_time'],
            lastEditedTime: $data['last_edited_time'],
            createdBy: User::fromArray($data['created_by']),
            lastEditedBy: User::fromArray($data['last_edited_by']),
            cover: isset($data['cover']) ? self::getObjectType($data['cover']) : null,
            icon: isset($data['icon']) ? self::getObjectType($data['icon']) : null,
            parent: $data['parent'],
            archived: $data['archived'],
            inTrash: $data['in_trash'],
            properties: isset($data['properties']) ? self::getProperties($data['properties']) : null,
            rawProperties: $data['properties'],
            url: $data['url'],
            publicUrl: $data['public_url'],
        );
    }

    /**
     * @param array{
     *     type?: string,
     *     file?: array{
     *         url: string,
     *         expiry_time: string
     *     },
     *     external?: array{
     *         url: string
     *     },
     *     emoji?: string,
     * } $data
     *
     * @return File|Emoji|External|null
     */
    private static function getObjectType(array $data): File|null|Emoji|External
    {
        if (!isset($data['type'])) {
            return null;
        }

        return match ($data['type']) {
            'file' => isset($data['file']) ? File::fromArray($data['file']) : null,
            'emoji' => Emoji::fromArray($data),
            'external' => isset($data['external']) ? External::fromArray($data['external']) : null,
            default => null,
        };
    }

    private static function getProperties(array $properties): array
    {
        return array_map(static function ($property) {
            return match ($property['type']) {
                RichText::TYPE => !empty($property['rich_text']) ? RichText::fromArray($property['rich_text'][0]) : null,
                Title::TYPE => !empty($property['title']) ? Title::fromArray($property['title'][0]) : null,
                CheckBox::TYPE => CheckBox::fromArray($property),
                Date::TYPE => !empty($property['date']) ? Date::fromArray($property['date']) : null,
                Email::TYPE => !empty($property['date']) ? Email::fromArray($property)['email'] : null,
                Formula::TYPE => !empty($property['formula']) ? Formula::fromArray($property['formula']) : null,
                MultiSelect::TYPE => !empty($property['multi_select']) ? MultiSelect::fromArray($property['multi_select']) : null,
                Number::TYPE => !empty($property['number']) ? Number::fromNumber($property['number']) : null,
                PhoneNumber::TYPE => PhoneNumber::fromArray($property),
                Relation::TYPE => !empty($property['relation']) ? Relation::fromArray($property['relation']) : null,
                default => null,
            };
        }, $properties);
    }

    public function getProperty(string $propertyName): mixed
    {
        $property = $this->properties[$propertyName] ?? null;
        if (!$property) {
            return null;
        }
        return $property;
    }
}
