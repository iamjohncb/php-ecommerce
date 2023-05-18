<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class User extends Model
{
    use SoftDeletes;

    public function transform(array $data){
        $users = [];
        foreach ($data as $item){
            $added = new Carbon($item->created_at);
            array_push($users, [
                'id' => $item->id,
                'username' => $item->username,
                'fullname' => $item->fullname,
                'email' => $item->email,
                'address' => $item->address,
                'role' => $item->role,
                'added' => $added->toFormattedDateString()
            ]);
        }

        return $users;
    }

}