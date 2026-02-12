<?php

use Specdocular\JsonSchema\Draft202012\Contracts\JSONSchema;
use Specdocular\JsonSchema\Draft202012\Keywords\Properties\Property;
use Specdocular\OpenAPI\Contracts\Abstract\Factories\Components\SchemaFactory;
use Specdocular\OpenAPI\Contracts\Interface\ShouldBeReferenced;
use Specdocular\OpenAPI\Schema\Objects\Components\Components;
use Specdocular\OpenAPI\Schema\Objects\Contact\Contact;
use Specdocular\OpenAPI\Schema\Objects\Info\Info;
use Specdocular\OpenAPI\Schema\Objects\License\License;
use Specdocular\OpenAPI\Schema\Objects\MediaType\MediaType;
use Specdocular\OpenAPI\Schema\Objects\OpenAPI\OpenAPI;
use Specdocular\OpenAPI\Schema\Objects\Operation\Operation;
use Specdocular\OpenAPI\Schema\Objects\Parameter\Parameter;
use Specdocular\OpenAPI\Schema\Objects\PathItem\PathItem;
use Specdocular\OpenAPI\Schema\Objects\PathItem\Support\AvailableOperation;
use Specdocular\OpenAPI\Schema\Objects\PathItem\Support\HttpMethod;
use Specdocular\OpenAPI\Schema\Objects\Paths\Fields\Path;
use Specdocular\OpenAPI\Schema\Objects\Paths\Paths;
use Specdocular\OpenAPI\Schema\Objects\RequestBody\RequestBody;
use Specdocular\OpenAPI\Schema\Objects\Response\Response;
use Specdocular\OpenAPI\Schema\Objects\Responses\Fields\HTTPStatusCode;
use Specdocular\OpenAPI\Schema\Objects\Responses\Responses;
use Specdocular\OpenAPI\Schema\Objects\Responses\Support\ResponseEntry;
use Specdocular\OpenAPI\Schema\Objects\Schema\Formats\IntegerFormat;
use Specdocular\OpenAPI\Schema\Objects\Schema\Schema;
use Specdocular\OpenAPI\Schema\Objects\Server\Server;
use Specdocular\OpenAPI\Support\Serialization\PathParameter;
use Specdocular\OpenAPI\Support\Serialization\QueryParameter;
use Specdocular\OpenAPI\Support\SharedFields\Content\ContentEntry;
use Specdocular\OpenAPI\Support\SharedFields\Parameters;
use Specdocular\OpenAPI\Support\Style\Styles\Form;

describe('PetStoreTest', function (): void {
    test('PetStore Example', function (): void {
        $contact = Contact::create()
            ->name('Swagger API Team')
            ->email('apiteam@swagger.io')
            ->url('https://swagger.io');

        $license = License::create('Apache 2.0')
            ->url('https://www.apache.org/licenses/LICENSE-2.0.html');

        $server = Server::create('https://petstore.swagger.io/api');

        $info = Info::create(
            'Swagger Petstore',
            '1.0.0',
        )->description('A sample API that uses a petstore as an example to demonstrate features in the OpenAPI 3.0 specification')
            ->termsOfService('https://swagger.io/terms/')
            ->contact($contact)
            ->license($license);

        $tagsParameter = Parameter::query(
            'tags',
            QueryParameter::create(
                Schema::array()->items(
                    Schema::string(),
                ),
                Form::create(),
            ),
        )->description('tags to filter by');

        $limitParameter = Parameter::query(
            'limit',
            QueryParameter::create(
                Schema::integer()->format(IntegerFormat::INT32),
            ),
        )->description('maximum number of results to return');

        $components = Components::create()
            ->schemas(Pet::create(), Animal::create(), ValidationError::create());

        $responseEntry = ResponseEntry::create(
            HTTPStatusCode::ok(),
            Response::create()->description('pet response')
                ->content(
                    ContentEntry::json(
                        MediaType::create()->schema(Pet::create()),
                    ),
                ),
        );

        $petListingResponse = ResponseEntry::create(
            HTTPStatusCode::ok(),
            Response::create()->description('pet response')
                ->content(
                    ContentEntry::json(
                        MediaType::create()->schema(
                            Schema::array()->items(
                                Pet::create(),
                            ),
                        ),
                    ),
                ),
        );

        $defaultErrorResponse = ResponseEntry::create(
            HTTPStatusCode::internalServerError(),
            Response::create()->description('unexpected error')
                ->content(
                    ContentEntry::json(
                        MediaType::create()->schema(ValidationError::create()),
                    ),
                ),
        );

        $operation = Operation::create()
            ->description(
                'Returns all pets from the system that the user has access to Nam sed condimentum est. 
                    Maecenas tempor sagittis sapien, nec rhoncus sem sagittis sit amet.
                     Aenean at gravida augue, ac iaculis sem. 
                     Curabitur odio lorem, ornare eget elementum nec, cursus id lectus. 
                     Duis mi turpis, pulvinar ac eros ac, tincidunt varius justo. 
                     In hac habitasse platea dictumst. Integer at adipiscing ante, a sagittis ligula. 
                     Aenean pharetra tempor ante molestie imperdiet. 
                     Vivamus id aliquam diam. Cras quis velit non tortor eleifend sagittis. 
                     Praesent at enim pharetra urna volutpat venenatis eget eget mauris. 
                     In eleifend fermentum facilisis. Praesent enim enim, gravida ac sodales sed, placerat id erat. 
                     Suspendisse lacus dolor, consectetur non augue vel, vehicula interdum libero. 
                     Morbi euismod sagittis libero sed lacinia. 
                     Sed tempus felis lobortis leo pulvinar rutrum. 
                     Nam mattis velit nisl, eu condimentum ligula luctus nec. 
                     Phasellus semper velit eget aliquet faucibus. 
                     In a mattis elit. Phasellus vel urna viverra, condimentum lorem id, rhoncus nibh. 
                     Ut pellentesque posuere elementum. Sed a varius odio. 
                     Morbi rhoncus ligula libero, vel eleifend nunc tristique vitae. 
                     Fusce et sem dui. Aenean nec scelerisque tortor. 
                     Fusce malesuada accumsan magna vel tempus. 
                     Quisque mollis felis eu dolor tristique, sit amet auctor felis gravida. 
                     Sed libero lorem, molestie sed nisl in, accumsan tempor nisi. 
                     Fusce sollicitudin massa ut lacinia mattis. Sed vel eleifend lorem. 
                     Pellentesque vitae felis pretium, pulvinar elit eu, euismod sapien.',
            )->operationId('findPets')
            ->parameters(Parameters::create($tagsParameter, $limitParameter))
            ->responses(Responses::create($petListingResponse, $defaultErrorResponse));

        $addPet = Operation::create()
            ->description(
                'Creates a new pet in the store.  Duplicates are allowed',
            )->operationId('addPet')
            ->requestBody(
                RequestBody::create(
                    ContentEntry::json(
                        MediaType::create()->schema(
                            Animal::create(),
                        ),
                    ),
                )
                    ->description('Pet to add to the store')
                    ->required(),
            )
            ->responses(Responses::create($responseEntry, $defaultErrorResponse));

        $path = Path::create(
            '/pets',
            PathItem::create()
                ->operations(
                    AvailableOperation::create(
                        HttpMethod::GET,
                        $operation,
                    ),
                    AvailableOperation::create(
                        HttpMethod::POST,
                        $addPet,
                    ),
                ),
        );

        $petIdParameter = Parameter::path(
            'id',
            PathParameter::create(
                Schema::integer()->format(IntegerFormat::INT64),
            ),
        )->description('ID of pet to fetch')
            ->required();

        $findPetById = Operation::create()
            ->description(
                'Returns a user based on a single ID, if the user does not have access to the pet',
            )->operationId('find pet by id')
            ->parameters(Parameters::create($petIdParameter))
            ->responses(Responses::create($responseEntry, $defaultErrorResponse));

        $petDeletedResponse = ResponseEntry::create(
            HTTPStatusCode::noContent(),
            Response::create()->description('pet deleted'),
        );

        $deletePetById = Operation::create()
            ->description('deletes a single pet based on the ID supplied')
            ->operationId('deletePet')
            ->parameters(
                Parameters::create(
                    $petIdParameter->description('ID of pet to delete'),
                ),
            )->responses(Responses::create($petDeletedResponse, $defaultErrorResponse));

        $petNested = Path::create(
            '/pets/{id}',
            PathItem::create()
                ->operations(
                    AvailableOperation::create(
                        HttpMethod::GET,
                        $findPetById,
                    ),
                    AvailableOperation::create(
                        HttpMethod::DELETE,
                        $deletePetById,
                    ),
                ),
        );

        $openApi = OpenAPI::v311($info)
            ->servers($server)
            ->paths(Paths::create($path, $petNested))
            ->components($components);

        $this->assertEquals(
            json_decode(file_get_contents(realpath(__DIR__ . '/../Support/Doubles/Stubs/petstore_expanded.json')), true, 512, JSON_THROW_ON_ERROR),
            $openApi->compile(),
        );
    });
})->coversNothing();

class Pet extends SchemaFactory implements ShouldBeReferenced
{
    public static function name(): string
    {
        return 'Pet';
    }

    public function component(): JSONSchema
    {
        return Schema::object()
            ->allOf(
                Animal::create(),
                Schema::object()
                    ->required('id')
                    ->properties(
                        Property::create(
                            'id',
                            Schema::integer()->format(IntegerFormat::INT64),
                        ),
                    ),
            );
    }
}

class Tag extends SchemaFactory
{
    public function component(): JSONSchema
    {
        return Schema::string();
    }
}

class Animal extends SchemaFactory implements ShouldBeReferenced
{
    public static function name(): string
    {
        return 'Animal';
    }

    public function component(): JSONSchema
    {
        return Schema::object()
            ->required('name')
            ->properties(
                Property::create(
                    'name',
                    Schema::string(),
                ),
                Property::create(
                    'tag',
                    Tag::create(),
                ),
            );
    }
}

class ValidationError extends SchemaFactory implements ShouldBeReferenced
{
    public static function name(): string
    {
        return 'Error';
    }

    public function component(): JSONSchema
    {
        return Schema::object()
            ->required('code', 'message')
            ->properties(
                Property::create(
                    'code',
                    Schema::integer()->format(IntegerFormat::INT32),
                ),
                Property::create(
                    'message',
                    Schema::string(),
                ),
            );
    }
}
