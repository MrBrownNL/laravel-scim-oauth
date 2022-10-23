<?php

namespace App\SCIM;

use App\Models\Product;
use ArieTimmerman\Laravel\SCIMServer\Attribute\AttributeMapping;
use ArieTimmerman\Laravel\SCIMServer\Helper;
use ArieTimmerman\Laravel\SCIMServer\SCIM\Schema;
use ArieTimmerman\Laravel\SCIMServer\SCIMConfig;

class CustomSCIMConfig extends SCIMConfig
{
    public function getConfigForResource($name)
    {
        if ($name === 'Products') {
            return $this->getProductConfig();
        }

        if ($name === 'Users') {
            return $this->getUserConfig();
        }

        $result = $this->getConfig();
        return @$result[$name];
    }

    public function getConfig()
    {
        return [
            'Users' => $this->getUserConfig(),
            'Products' => $this->getProductConfig(),
        ];
    }

    public function getUserConfig()
    {
        return [

            // Set to 'null' to make use of auth.providers.users.model (App\User::class)
            'class' => Helper::getAuthUserClass(),

            'validations' => [

                'urn:ietf:params:scim:schemas:core:2.0:User:externalId' => 'required|unique:users,externalId',
                'urn:ietf:params:scim:schemas:core:2.0:User:userName' => 'required',
                'urn:ietf:params:scim:schemas:core:2.0:User:password' => 'nullable',
                'urn:ietf:params:scim:schemas:core:2.0:User:active' => 'boolean',
                'urn:ietf:params:scim:schemas:core:2.0:User:emails' => 'required|unique:users,email|array',
                'urn:ietf:params:scim:schemas:core:2.0:User:emails.*.value' => 'required|email',
                'urn:ietf:params:scim:schemas:core:2.0:User:roles' => 'nullable|array',
                'urn:ietf:params:scim:schemas:core:2.0:User:roles.*.value' => 'required',

            ],

            'singular' => 'User',
            'schema' => [Schema::SCHEMA_USER],

            //eager loading
            'withRelations' => [],
            'map_unmapped' => true,
            'unmapped_namespace' => 'urn:ietf:params:scim:schemas:laravel:unmapped',
            'description' => 'User Account',

            // Map a SCIM attribute to an attribute of the object.
            'mapping' => [
                'schemas' => AttributeMapping::constant(
                    [
                        'urn:ietf:params:scim:schemas:core:2.0:User',
                    ]
                )->ignoreWrite(),

                'id' => AttributeMapping::eloquent("id")->disableWrite(),

                'externalId' => AttributeMapping::eloquent("externalId"),

                'meta' => [
                    'created' => AttributeMapping::eloquent("created_at")->disableWrite(),
                    'lastModified' => AttributeMapping::eloquent("updated_at")->disableWrite(),

                    'location' => (new AttributeMapping())->setRead(
                        function ($object) {
                            return route(
                                'scim.resource',
                                [
                                    'resourceType' => 'Users',
                                    'resourceObject' => $object->id
                                ]
                            );
                        }
                    )->disableWrite(),

                    'resourceType' => AttributeMapping::constant("User")
                ],

                'userName' => AttributeMapping::eloquent("name"),

                'name' => [
                    'formatted' => null,
                    'familyName' => null,
                    'givenName' => AttributeMapping::eloquent("name"),
                    'middleName' => null,
                    'honorificPrefix' => null,
                    'honorificSuffix' => null
                ],

                'active' => AttributeMapping::eloquent("active"),

                // Multi-Valued Attributes
                'emails' => [[
                    "value" => AttributeMapping::eloquent("email"),
                    "display" => null,
                    "type" => AttributeMapping::constant("work")->ignoreWrite(),
                    "primary" => AttributeMapping::constant(true)->ignoreWrite()
                ]],


                'urn:ietf:params:scim:schemas:core:2.0:User' => [

                    'userName' => AttributeMapping::eloquent("name"),

                    'name' => [
                        'formatted' => null,
                        'familyName' => null,
                        'givenName' => AttributeMapping::eloquent("name"),
                        'middleName' => null,
                        'honorificPrefix' => null,
                        'honorificSuffix' => null
                    ],

                    'displayName' => null,
                    'nickName' => null,
                    'profileUrl' => null,
                    'title' => null,
                    'userType' => null,
                    'preferredLanguage' => null, // Section 5.3.5 of [RFC7231]
                    'locale' => null, // see RFC5646
                    'timezone' => null, // see RFC6557
                    'active' => AttributeMapping::eloquent("active"),

                    'password' => AttributeMapping::eloquent('password')->disableRead(),

                    // Multi-Valued Attributes
                    'emails' => [[
                        "value" => AttributeMapping::eloquent("email"),
                        "display" => null,
                        "type" => AttributeMapping::constant("other")->ignoreWrite(),
                        "primary" => AttributeMapping::constant(true)->ignoreWrite()
                    ],[
                        "value" => AttributeMapping::eloquent("email"),
                        "display" => null,
                        "type" => AttributeMapping::constant("work")->ignoreWrite(),
                        "primary" => AttributeMapping::constant(true)->ignoreWrite()
                    ]],

                    'phoneNumbers' => [[
                        "value" => null,
                        "display" => null,
                        "type" => null,
                        "primary" => null
                    ]],

                    'ims' => [[
                        "value" => null,
                        "display" => null,
                        "type" => null,
                        "primary" => null
                    ]], // Instant messaging addresses for the User

                    'photos' => [[
                        "value" => null,
                        "display" => null,
                        "type" => null,
                        "primary" => null
                    ]],

                    'addresses' => [[
                        'formatted' => null,
                        'streetAddress' => null,
                        'locality' => null,
                        'region' => null,
                        'postalCode' => null,
                        'country' => null
                    ]],

                    'groups' => [[
                        'value' => null,
                        '$ref' => null,
                        'display' => null,
                        'type' => null,
                    ]],

                    'entitlements' => null,
                    'roles' => null,
                    'x509Certificates' => null,
                ],

            ]
        ];
    }

    public function getProductConfig()
    {
        return [
            'class' => Product::class,

            'validations' => [

                'urn:ietf:params:scim:schemas:core:2.0:Product:name' => 'required',
                'urn:ietf:params:scim:schemas:core:2.0:Product:detail' => 'required',
                'urn:ietf:params:scim:schemas:core:2.0:Product:price' => 'required|numeric',
            ],

            'singular' => 'Product',
            'schema' => 'urn:ietf:params:scim:schemas:core:2.0:Product',

            //eager loading
            'withRelations' => [],
            'map_unmapped' => true,
            'unmapped_namespace' => 'urn:ietf:params:scim:schemas:laravel:unmapped',
            'description' => 'Product',

            // Map a SCIM attribute to an attribute of the object.
            'mapping' => [

                'id' => AttributeMapping::eloquent("id")->disableWrite(),

                'meta' => [
                    'image' => AttributeMapping::eloquent("image")->disableWrite(),
                    'created' => AttributeMapping::eloquent("created_at")->disableWrite(),
                    'lastModified' => AttributeMapping::eloquent("updated_at")->disableWrite(),
                    'location' => (new AttributeMapping())->setRead(
                        function ($object) {
                            return route(
                                'scim.resource',
                                [
                                    'resourceType' => 'Products',
                                    'resourceObject' => $object->id
                                ]
                            );
                        }
                    )->disableWrite(),
                    'resourceType' => AttributeMapping::constant("Product")
                ],

                'schemas' => AttributeMapping::constant(
                    [
                        'urn:ietf:params:scim:schemas:core:2.0:Product',
                    ]
                )->ignoreWrite(),

                'urn:ietf:params:scim:schemas:core:2.0:Product' => [
                    'name' => AttributeMapping::eloquent("name"),
                    'detail' => AttributeMapping::eloquent("detail"),
                    'price' => AttributeMapping::eloquent("price"),
                ],
            ]
        ];
    }
}

