<?php

use Flowgistics\PhpNotionClient\DTO\Page;
use Flowgistics\PhpNotionClient\DTO\Properties\CheckBox;
use Flowgistics\PhpNotionClient\DTO\Properties\Date;
use Flowgistics\PhpNotionClient\DTO\Properties\Email;
use Flowgistics\PhpNotionClient\DTO\Properties\Formula;
use Flowgistics\PhpNotionClient\DTO\Properties\MultiSelect;
use Flowgistics\PhpNotionClient\DTO\Properties\Number;
use Flowgistics\PhpNotionClient\DTO\Properties\PhoneNumber;
use Flowgistics\PhpNotionClient\DTO\Properties\Relation;
use Flowgistics\PhpNotionClient\DTO\Properties\Title;

it('hydrates a page title containing an inline url', function () {
    $page = Page::fromArray(pagePayload([
        'Name'    => [
            'id'    => 'title',
            'type'  => 'title',
            'title' => [[
                'type'        => 'text',
                'text'        => [
                    'content' => 'https://flowgistics.nl',
                    'link'    => ['url' => 'https://flowgistics.nl'],
                ],
                'annotations' => annotations(),
                'plain_text'  => 'https://flowgistics.nl',
                'href'        => 'https://flowgistics.nl',
            ]],
        ],
        'Project' => [
            'id'       => 'project',
            'type'     => 'relation',
            'relation' => [['id' => 'project-page-id']],
        ],
        'TaskId'  => [
            'id'        => 'task',
            'type'      => 'rich_text',
            'rich_text' => [],
        ],
    ]));

    expect($page->getProperty('Name'))->toBeInstanceOf(Title::class)
        ->and($page->getProperty('Name')->text->link)->toBe('https://flowgistics.nl')
        ->and($page->getProperty('Name')->href)->toBe('https://flowgistics.nl')
        ->and($page->getProperty('Project'))->toBeInstanceOf(Relation::class)
        ->and($page->getProperty('Project')->relation)->toBe([['id' => 'project-page-id']])
        ->and($page->getProperty('TaskId'))->toBeNull();
});

it('hydrates supported page property values without dropping falsey values', function () {
    $page = Page::fromArray(pagePayload([
        'Done'      => ['id' => 'done', 'type' => 'checkbox', 'checkbox' => false],
        'Estimate'  => ['id' => 'estimate', 'type' => 'number', 'number' => 0],
        'Due'       => ['id' => 'due', 'type' => 'date', 'date' => ['start' => '2026-07-03', 'end' => null, 'time_zone' => null]],
        'Email'     => ['id' => 'email', 'type' => 'email', 'email' => null],
        'Phone'     => ['id' => 'phone', 'type' => 'phone_number', 'phone_number' => null],
        'Formula'   => ['id' => 'formula', 'type' => 'formula', 'formula' => ['type' => 'number', 'number' => 1.5]],
        'Tags'      => ['id' => 'tags', 'type' => 'multi_select', 'multi_select' => [['id' => 'tag', 'name' => 'Ops', 'color' => 'blue']]],
        'Website'   => ['id' => 'website', 'type' => 'url', 'url' => 'https://developers.notion.com/'],
        'Files'     => ['id' => 'files', 'type' => 'files', 'files' => [['name' => 'Spec', 'type' => 'external', 'external' => ['url' => 'https://example.com/spec.pdf']]]],
        'People'    => ['id' => 'people', 'type' => 'people', 'people' => [['object' => 'user', 'id' => 'user-id']]],
        'Status'    => ['id' => 'status', 'type' => 'status', 'status' => ['id' => 'in-progress', 'name' => 'In progress', 'color' => 'yellow']],
        'Unique ID' => ['id' => 'unique', 'type' => 'unique_id', 'unique_id' => ['prefix' => 'TASK', 'number' => 42]],
        'Rollup'    => ['id' => 'rollup', 'type' => 'rollup', 'rollup' => ['type' => 'number', 'number' => 3]],
        'Unknown'   => ['id' => 'unknown', 'type' => 'future_type', 'future_type' => ['value' => true]],
    ]));

    expect($page->getProperty('Done'))->toBeInstanceOf(CheckBox::class)
        ->and($page->getProperty('Done')->checkbox)->toBeFalse()
        ->and($page->getProperty('Estimate'))->toBeInstanceOf(Number::class)
        ->and($page->getProperty('Estimate')->number)->toBe(0)
        ->and($page->getProperty('Due'))->toBeInstanceOf(Date::class)
        ->and($page->getProperty('Email'))->toBeInstanceOf(Email::class)
        ->and($page->getProperty('Phone'))->toBeInstanceOf(PhoneNumber::class)
        ->and($page->getProperty('Formula'))->toBeInstanceOf(Formula::class)
        ->and($page->getProperty('Tags'))->toHaveCount(1)
        ->and($page->getProperty('Tags')[0])->toBeInstanceOf(MultiSelect::class)
        ->and($page->getProperty('Website'))->toBe('https://developers.notion.com/')
        ->and($page->getProperty('Files'))->toHaveCount(1)
        ->and($page->getProperty('People'))->toHaveCount(1)
        ->and($page->getProperty('Status'))->toBeInstanceOf(MultiSelect::class)
        ->and($page->getProperty('Unique ID'))->toBe(['prefix' => 'TASK', 'number' => 42])
        ->and($page->getProperty('Rollup'))->toBe(['type' => 'number', 'number' => 3])
        ->and($page->getProperty('Unknown'))->toBe(['id' => 'unknown', 'type' => 'future_type', 'future_type' => ['value' => true]]);
});

it('hydrates partial page payloads without warnings', function () {
    $page = Page::fromArray([
        'object'     => 'page',
        'properties' => [
            'Project' => [
                'id'       => 'project',
                'type'     => 'relation',
                'relation' => [['id' => 'project-page-id']],
            ],
        ],
    ]);

    expect($page->id)->toBeNull()
        ->and($page->createdTime)->toBeNull()
        ->and($page->createdBy)->toBeNull()
        ->and($page->getProperty('Project'))->toBeInstanceOf(Relation::class);
});

function pagePayload(array $properties): array
{
    return [
        'id'               => 'page-id',
        'object'           => 'page',
        'created_time'     => '2026-07-03T10:00:00.000Z',
        'last_edited_time' => '2026-07-03T10:00:00.000Z',
        'created_by'       => ['object' => 'user', 'id' => 'creator-id'],
        'last_edited_by'   => ['object' => 'user', 'id' => 'editor-id'],
        'cover'            => null,
        'icon'             => null,
        'parent'           => ['type' => 'database_id', 'database_id' => 'database-id'],
        'archived'         => false,
        'in_trash'         => false,
        'properties'       => $properties,
        'url'              => 'https://www.notion.so/page-id',
        'public_url'       => null,
    ];
}

function annotations(): array
{
    return [
        'bold'          => false,
        'italic'        => false,
        'strikethrough' => false,
        'underline'     => false,
        'code'          => false,
        'color'         => 'default',
    ];
}
