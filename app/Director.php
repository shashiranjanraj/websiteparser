<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    //
   protected $fillable = ['din','name','designation','dateofopinment'];

   public function company()
   {
       $this->belongsTo('App\Company');
       # code...
   }
}
