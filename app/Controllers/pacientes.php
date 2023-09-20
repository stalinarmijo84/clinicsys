<?php

namespace App\Controllers;
use App\Models\PacientesModel;
class Login extends BaseController
{
    protected $pacientes;

    public function __construct()
    {
        $pacientes = new PacientesModel();
    }


    
}
