<<<<<<< Updated upstream
=======
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
  /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $table = 'businesses';

   protected $fillable = [
        'id','rut','name','direction','flat','phone','mail','id_commune','town','id_region','updated_at'
   ];

   public $timestamps  = false;

    /**
    * Get the user that owns the Operations.
    */

}
>>>>>>> Stashed changes
