<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\ConnectionException;
use RealRashid\SweetAlert\Facades\Alert;

class IndexController extends Controller
{
 
    public function map(){
        
        $base_url = 'http://192.168.1.74:8080/';
        $citycode = Http::get(getenv("REST_BASE_URL") . "/countries/map", [
            "dspace_base_url" => $base_url,
        ])->json();
        
        $divisions = array_column(code_iso_list(), 'divisions');
        $allcoordinates = [];
        foreach(array_keys($citycode) as $code){
            
            $coordinates=array_column($divisions, $code);
            if(isset($coordinates[0]))
            {
                array_push($allcoordinates, $coordinates[0]);
            }
                            
        }

        return view('map', ['allcoordinates'=>$allcoordinates]);

        
    }  
    
    
}
