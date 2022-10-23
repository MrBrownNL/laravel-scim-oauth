<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class OauthAccessToken extends Model
{
    use Uuids;

    protected $table = 'oauth_access_tokens';

    protected $fillable = ['revoked'];

    public function client()
    {
        return $this->belongsTo(OauthClient::class, 'id','user_id');
    }
}
