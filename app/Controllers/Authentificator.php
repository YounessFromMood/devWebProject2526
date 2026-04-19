<?php

namespace App\Controllers;

class Authentificator extends BaseController {

    public function loginPage(): void {
        //return view('login_page');
    }

    public function toLogIn(): void {
        //return view('welcome_message');
    }

    public function registerPage():void {
        //return view('register_page)
    }

    public function toRegister(): void {
        //return view('welcome_message');
    }

    function logout() :void {
        //return view('index');
    }
}