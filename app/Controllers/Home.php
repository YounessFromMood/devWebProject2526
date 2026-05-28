<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('index');
    }

    public function details(): string
    {
        $data["myMessage"] = "Message.exe en cours de lancement...<br><br>Veuillez patienter.";
        return view('details', $data);
    }

}