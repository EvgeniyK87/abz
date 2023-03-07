<?php

namespace App\Services;

use Illuminate\Http\Request;

class ImagesService {

    public function store ($photo) 
    {
        //TO DO: handle errors by using try catch  
        \Tinify\setKey(env('TINIFY_API_KEY'));

        $source = \Tinify\fromFile($photo);
        $resized = $source->resize(array(
            "method" => "cover",
            "width" => 70,
            "height" => 70
        ));

        $name = "avatars/".date('mdYHis') . uniqid() . "-avatar.jpg";

        $resized->toFile($name);
        
        return $name;
    }

}