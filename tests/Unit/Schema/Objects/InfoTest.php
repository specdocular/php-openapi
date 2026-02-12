<?php

namespace Tests\Unit\Schema\Objects;

use Specdocular\OpenAPI\Schema\Objects\Contact\Contact;
use Specdocular\OpenAPI\Schema\Objects\Info\Info;
use Specdocular\OpenAPI\Schema\Objects\License\License;

describe(class_basename(Info::class), function (): void {
    it('should set all parameters', function (): void {
        $info = Info::create(
            'Pretend API',
            'v1',
        )->summary('Some Arrays!')
            ->description('A pretend API')
            ->termsOfService('https://laragen.io')
            ->contact(Contact::create())
            ->license(License::create('MIT'));

        expect($info->compile())->toBe([
            'title' => 'Pretend API',
            'summary' => 'Some Arrays!',
            'description' => 'A pretend API',
            'termsOfService' => 'https://laragen.io',
            'contact' => [],
            'license' => [
                'name' => 'MIT',
            ],
            'version' => 'v1',
        ]);
    });
})->covers(Info::class);
