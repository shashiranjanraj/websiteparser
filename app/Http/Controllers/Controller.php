<?php

namespace App\Http\Controllers;

use Facade\FlareClient\View;
use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __call($name,$arguments)
    {
        $urlArray=  explode('/',url()->current());
        if(strpos($urlArray[3],'list')!==false){
            $className =  substr($urlArray[3],4);
 
            $object = app('App\\'.$className);
            
             return view('list'.$className,['data'=>$object->all()]);
 
        }
        else if(strpos($urlArray[3],'detail')!==false){
            $className =  substr($urlArray[3],6);
 
            $object = app('App\\'.$className);
             return view('detail'.$className,['data'=>$object->find($urlArray[4])]);
        }
        else{
         return view('welcome');
        }
        # code...
    }

   
}
