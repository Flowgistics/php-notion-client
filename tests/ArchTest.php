<?php

it('will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->not->toBeUsed();

it('uses strict types')
    ->expect('Flowgistics\PhpNotionClient')
    ->classes()
    ->toUseStrictTypes();
