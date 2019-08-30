<?php
/*
|--------------------------------------------------------------------------
| Author: Vlad Salabun / https://t.me/vlad_salabun 
| Model: Users:
|--------------------------------------------------------------------------
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
   protected $table = 'users';
   public $timestamps = false;
}