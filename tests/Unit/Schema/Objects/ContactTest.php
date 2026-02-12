<?php

namespace Tests\Unit\Schema\Objects;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Specdocular\OpenAPI\Schema\Objects\Contact\Contact;
use Specdocular\OpenAPI\Schema\Objects\Info\Info;

#[CoversClass(Contact::class)]
class ContactTest extends TestCase
{
    public function testCreateWithAllParametersWorks(): void
    {
        $contact = Contact::create()
            ->name('Example')
            ->url('https://laragen.io')
            ->email('hello@laragen.io');

        $info = Info::create('API Specification', 'v1')
            ->contact($contact);

        $this->assertSame([
            'title' => 'API Specification',
            'contact' => [
                'name' => 'Example',
                'url' => 'https://laragen.io',
                'email' => 'hello@laragen.io',
            ],
            'version' => 'v1',
        ], $info->compile());
    }
}
