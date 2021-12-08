<?php

namespace Petrik\Loginapp;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
    // ha a created_at / updated_at nélkül hoztuk létre:  ->
    //protected $timestamps = false;
    
    public $visible = ['id', 'email'];
}
