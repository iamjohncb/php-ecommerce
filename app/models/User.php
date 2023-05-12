<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = ['username', 'fullname', 'email', 'password', 'address', 'role'];
    protected $dates = ['deleted_at'];
    protected $hidden = ['password', 'deleted_at'];
}