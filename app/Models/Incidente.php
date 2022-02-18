<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidente extends Model
{
  /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $table = 'incidente';

   protected $fillable = [
        'date','comments','registered_by',
   ];

   public $timestamps  = false;

    /**
    * Get the user that owns the Operations.
    */

}
