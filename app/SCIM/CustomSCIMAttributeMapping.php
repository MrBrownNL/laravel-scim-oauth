<?php

namespace App\SCIM;

use App\Models\User;
use ArieTimmerman\Laravel\SCIMServer\Attribute\AttributeMapping;
use ArieTimmerman\Laravel\SCIMServer\Attribute\EloquentAttributeMapping;

class CustomSCIMAttributeMapping
{
    public static function statusId($parent = null) : AttributeMapping
    {
        $eloquentAttribute = 'statusId';
        return (new EloquentAttributeMapping())->setEloquentReadAttribute($eloquentAttribute)->setParent($parent)->setAdd(
            function ($value, &$object) use ($eloquentAttribute) {
                $object->{$eloquentAttribute} = $value ? User::STATUS_ACTIVE : User::STATUS_DELETED;
            }
        )->setReplace(
            function ($value, &$object) use ($eloquentAttribute) {
                $object->{$eloquentAttribute} = $value ? User::STATUS_ACTIVE : User::STATUS_DELETED;
            }
        )->setSortAttribute($eloquentAttribute)->setEloquentAttributes([$eloquentAttribute]);
    }

}
