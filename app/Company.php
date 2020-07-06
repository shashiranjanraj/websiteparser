<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //

    public function contact()
    {
       return $this->hasOne('App\Contact');
        # code...
    }
    public function directors()
    {
        return $this->hasMany('App\Director');
        # code...
    }
}
