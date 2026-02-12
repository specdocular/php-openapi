<?php

namespace Tests\Unit\Schema\Objects;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Specdocular\OpenAPI\Schema\Objects\Server\Fields\Variables\VariableEntry;
use Specdocular\OpenAPI\Schema\Objects\Server\Server;
use Specdocular\OpenAPI\Schema\Objects\ServerVariable\ServerVariable;

#[CoversClass(ServerVariable::class)]
class ServerVariableTest extends TestCase
{
    public function testCreateWithAllParametersWorks(): void
    {
        $serverVariable = ServerVariable::create('Earth')
            ->enum('Earth', 'Mars', 'Saturn')
            ->description('The planet the server is running on');

        $server = Server::default()
            ->variables(
                VariableEntry::create(
                    'ServerVariableName',
                    $serverVariable,
                ),
            );

        $this->assertSame([
            'url' => '/',
            'variables' => [
                'ServerVariableName' => [
                    'enum' => ['Earth', 'Mars', 'Saturn'],
                    'default' => 'Earth',
                    'description' => 'The planet the server is running on',
                ],
            ],
        ], $server->compile());
    }
}
