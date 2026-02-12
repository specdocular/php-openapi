<?php

namespace Tests\Unit\Schema\Objects;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Specdocular\OpenAPI\Schema\Objects\Info\Info;
use Specdocular\OpenAPI\Schema\Objects\License\License;

#[CoversClass(License::class)]
class LicenseTest extends TestCase
{
    public function testCreateWithAllParametersWorks(): void
    {
        $license = License::create('MIT')->identifier('MIT');

        $info = Info::create('Example Api', 'v1')->license($license);

        $this->assertSame([
            'title' => 'Example Api',
            'license' => [
                'name' => 'MIT',
                'identifier' => 'MIT',
            ],
            'version' => 'v1',
        ], $info->compile());
    }
}
