<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
    public function index() {
        return "index";
    }

    public function login(){
        return "login";
    }


}
