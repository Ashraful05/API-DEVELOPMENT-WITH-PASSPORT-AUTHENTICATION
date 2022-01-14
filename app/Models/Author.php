<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticateContract;

use Laravel\Passport\HasApiTokens;

class Author extends Model implements AuthenticateContract
{
    use HasFactory,HasApiTokens,Authenticatable;

    protected $fillable=[
      'name','email','password','phone_no'
    ];

    public $timestamps = false;

    public function book()
    {
        return $this->hasMany(Book::class);
    }
}
