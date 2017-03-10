<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * @inheritdoc
     */
    protected $table = 'user';

    /**
     * @inheritdoc
     */
    protected $fillable = ['email', 'first_name', 'last_name', 'gender', 'country'];
}
