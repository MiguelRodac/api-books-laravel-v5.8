<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /**
     * Table name.
     */
    protected $table = 'users';

    /**
     * Primary key since migration uses id_user.
     */
    protected $primaryKey = 'id_user';

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'nickname',
        'email',
        'password',
    ];

    /**
     * Hidden attributes for arrays / JSON.
     * Password should never leak to responses.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
