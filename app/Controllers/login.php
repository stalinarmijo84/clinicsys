<?php

namespace App\Controllers;

use App\Models\PacientesModel;

class Login extends BaseController
{
    protected $pacientes;
    protected $reglasInsertar;
    public function __construct()
    {
        $this->pacientes = new PacientesModel();
        helper(['form']);
        $this->reglasInsertar = [
            'fecha_nac' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'La fecha de nacimiento es obligatorio.',
                    'valid_date' => 'La fecha de necimiento debe ser válida.'
                ]
            ],
            'nombres' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Por favor Ingrese al menos un Nombre.'
                ]
            ],
            'apellidos' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Por favor Ingrese al menos un Apellido.'
                ]
            ],
            'cedula' => [
                'rules' => 'required|is_unique[pacientes.cedula]',
                'errors' => [
                    'required' => 'Por favor Ingrese la cédula.',
                    'is_unique' => 'La cédula ya existe en la base de datos.'
                ]
            ],
            'direccion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Por favor Ingrese la direccion.'
                ]
            ],
            'telefono' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Por favor Ingrese el telefono.'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Por favor Ingrese la Contraseña.'
                ]
            ],
            'repassword' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'El campo Verifica contraseña es obligatorio.',
                    'matches' => 'Las contraseñas no coiciden.'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email[pacientes.email]',
                'errors' => [
                    'required' => 'El correo es obligatorio.',
                    'valid_email' => 'Debe ser un correo válido.'
                ]
            ]

        ];
    }

    public function index()
    {
        echo view('login');
    }
    public function registro()
    {
        echo view('registro');
    }

    public function insertar()
    {
        $cedula_valida='';
        if (($this->request->is('post') && $this->validate($this->reglasInsertar)) && $this->validar_cedula($this->request->getPost('cedula'))) { //preguntamos si se envio datos por post
            $password = $this->request->getPost('password');
            $contrasena_encriptada = password_hash("$password", PASSWORD_DEFAULT);
            $this->pacientes->save([
                'fecha_nac' => $this->request->getPost('fecha_nac'),
                'nombres' => $this->request->getPost('nombres'),
                'apellidos' => $this->request->getPost('apellidos'),
                'cedula' => $this->request->getPost('cedula'),
                'direccion' => $this->request->getPost('direccion'),
                'telefono' => $this->request->getPost('telefono'),
                'password' => $contrasena_encriptada,
                'email' => $this->request->getPost('email')
            ]);
            //print_r($_POST);
            //echo $contrasena_encriptada;
            return redirect()->to(base_url());
        } else {
        
            if (!$this->validar_cedula($this->request->getPost('cedula'))) {
                $cedula_valida='La cedula es inválida';
            } 
        
            $data = ['cedula_valida' =>$cedula_valida ,'validation' => $this->validator];
            return view('registro', $data);
            //
            //return redirect()->to(base_url().'registro')->with('validation',$this->validator);
            // redirect()->back()->withInput($data);

        }
    }

    function validar_cedula($cedula)
    {
        // Elimina espacios en blanco y guiones
        $cedula = str_replace([' ', '-'], '', $cedula);

        // Verifica si la cédula tiene 10 dígitos numéricos
        if (strlen($cedula) !== 10 || !ctype_digit($cedula)) {
            return false;
        }

        // Obtiene los primeros 9 dígitos de la cédula
        $digitos = substr($cedula, 0, 9);

        // Obtiene el último dígito de la cédula (dígito verificador)
        $verificador = (int)substr($cedula, 9, 1);

        // Realiza el cálculo del dígito verificador
        $total = 0;
        for ($i = 0; $i < 9; $i++) {
            $digito = (int)$digitos[$i];
            if ($i % 2 === 0) {
                $digito *= 2;
                if ($digito > 9) {
                    $digito -= 9;
                }
            }
            $total += $digito;
        }
        $resultado = 10 - ($total % 10);
        // El resultado debe ser igual al dígito verificador o 10 si es 0
        if ($resultado === 10) {
            $resultado = 0;
        }
        return $resultado === $verificador;
    }
    public function login(){
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $contrasena_desencriptada = password_verify("$password", PASSWORD_DEFAULT);
    }
}
