<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Login extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function autenticar()
    {
        $usuarioModel = new UsuarioModel();

        $identificador = trim((string) $this->request->getPost('usuario'));
        $password = (string) $this->request->getPost('password');

        $usuario = $usuarioModel
            ->groupStart()
                ->where('usuario', $identificador)
                ->orWhere('correo', $identificador)
            ->groupEnd()
            ->first();

        if (!$usuario || !password_verify($password, $usuario['password'])) {
            return redirect()
                ->to('/login')
                ->with('error', 'Usuario, correo o contraseña incorrectos.');
        }

        session()->set([
            'id_usuario' => $usuario['id_usuario'],
            'nombre'     => $usuario['nombre'],
            'usuario'    => $usuario['usuario'],
            'logueado'   => true,
        ]);

        return redirect()->to('/inicio');
    }

    public function cerrarSesion()
    {
        session()->destroy();

        return redirect()
            ->to('/login')
            ->with('mensaje', 'Sesión cerrada correctamente.');
    }
}