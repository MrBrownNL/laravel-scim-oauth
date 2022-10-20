<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scim extends Model
{
    use Uuids;
    use HasFactory;

    protected $table = 'oauth_clients';
}
