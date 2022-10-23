<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class OauthClient extends Model
{
    use Uuids;

    protected $table = 'oauth_clients';

    public function tokens()
    {
        return $this->hasMany(OauthAccessToken::class, 'client_id');
    }
}
