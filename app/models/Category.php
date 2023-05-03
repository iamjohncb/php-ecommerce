<?php

namespace App\models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model
{
    use SoftDeletes;

    public $timestamp = true;
    protected $fillable = ['name','slug'];
    protected $dates = ['deleted_at'];


}