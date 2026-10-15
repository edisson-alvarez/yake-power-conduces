<?php

namespace App\Controllers;

use App\Models\ConduceModel;
use App\Models\ClienteModel;

class Conduces extends BaseController
{
    private function validarSesion()
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/login');
        }

        return null;
    }

    public function index()
    {
        if ($respuesta = $this->validarSesion()) {
            return $respuesta;
        }

        $db = \Config\Database::connect();

        $conduces = $db->table('conduces c')
            ->select('c.id_conduce, c.numero_conduce, c.fecha, c.observaciones, cl.nombre AS cliente')
            ->join('clientes cl', 'cl.id_cliente = c.id_cliente')
            ->orderBy('c.id_conduce', 'DESC')
            ->get()
            ->getResultArray();

        return view('conduces/index', [
            'conduces' => $conduces
        ]);
    }

    public function crear()
    {
        if ($respuesta = $this->validarSesion()) {
            return $respuesta;
        }

        return view('conduces/formulario', [
            'conduce' => null
        ]);
    }

    public function guardar()
    {
        if ($respuesta = $this->validarSesion()) {
            return $respuesta;
        }

        $clienteModel = new ClienteModel();
        $conduceModel = new ConduceModel();

        $clienteId = $clienteModel->insert([
            'nombre'     => $this->request->getPost('cliente'),
            'rnc_cedula' => $this->request->getPost('rnc_cedula'),
            'direccion'  => $this->request->getPost('direccion'),
            'atencion'   => $this->request->getPost('atencion'),
            'telefono'   => $this->request->getPost('telefono'),
        ], true);

        $conduceModel->insert([
            'numero_conduce' => $this->request->getPost('numero_conduce'),
            'fecha'           => $this->request->getPost('fecha'),
            'id_cliente'      => $clienteId,
            'id_usuario'      => session()->get('id_usuario'),
            'observaciones'   => $this->request->getPost('observaciones'),
        ]);

        return redirect()
            ->to('/conduces')
            ->with('mensaje', 'Conduce creado correctamente.');
    }

    public function editar($id)
    {
        if ($respuesta = $this->validarSesion()) {
            return $respuesta;
        }

        $db = \Config\Database::connect();

        $conduce = $db->table('conduces c')
            ->select('c.*, cl.nombre AS cliente, cl.rnc_cedula, cl.direccion, cl.atencion, cl.telefono')
            ->join('clientes cl', 'cl.id_cliente = c.id_cliente')
            ->where('c.id_conduce', $id)
            ->get()
            ->getRowArray();

        if (!$conduce) {
            return redirect()
                ->to('/conduces')
                ->with('error', 'Conduce no encontrado.');
        }

        return view('conduces/formulario', [
            'conduce' => $conduce
        ]);
    }

    public function actualizar($id)
    {
        if ($respuesta = $this->validarSesion()) {
            return $respuesta;
        }

        $conduceModel = new ConduceModel();
        $clienteModel = new ClienteModel();

        $conduce = $conduceModel->find($id);

        if (!$conduce) {
            return redirect()
                ->to('/conduces')
                ->with('error', 'Conduce no encontrado.');
        }

        $clienteModel->update($conduce['id_cliente'], [
            'nombre'     => $this->request->getPost('cliente'),
            'rnc_cedula' => $this->request->getPost('rnc_cedula'),
            'direccion'  => $this->request->getPost('direccion'),
            'atencion'   => $this->request->getPost('atencion'),
            'telefono'   => $this->request->getPost('telefono'),
        ]);

        $conduceModel->update($id, [
            'numero_conduce' => $this->request->getPost('numero_conduce'),
            'fecha'           => $this->request->getPost('fecha'),
            'observaciones'   => $this->request->getPost('observaciones'),
        ]);

        return redirect()
            ->to('/conduces')
            ->with('mensaje', 'Conduce actualizado correctamente.');
    }

    public function eliminar($id)
    {
        if ($respuesta = $this->validarSesion()) {
            return $respuesta;
        }

        $conduceModel = new ConduceModel();

        if (!$conduceModel->find($id)) {
            return redirect()
                ->to('/conduces')
                ->with('error', 'Conduce no encontrado.');
        }

        $conduceModel->delete($id);

        return redirect()
            ->to('/conduces')
            ->with('mensaje', 'Conduce eliminado correctamente.');
    }
}