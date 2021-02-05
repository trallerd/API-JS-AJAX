<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Clinica;

class ClinicaController extends Controller
{

    public function index()
    {
        $clinicas = Clinica::all();
        return view('clinica.index')->with('clinicas',$clinicas);
    }


    public function create(){}

    public function store(Request $request)
    {
        $clinica = new Clinica();
        $clinica->nome = mb_strtoupper($request->input('nome'), 'UTF-8');
        $clinica->cep = $request->input('cep');
        $clinica->endereco = mb_strtoupper($request->input('endereco'));
        $clinica->telefone = mb_strtoupper($request->input('telefone'));
        $clinica->save();

        return json_encode($clinica);
    }

    public function show($id)
    {
        $clinica = Clinica::find($id);
        if (isset($clinica)) {
            return json_encode($clinica);
        }
        return response('Clinica não encontrada', 404);
    }

    public function edit($id){}


    public function update(Request $request, $id){
        $clinica = Clinica::find($id);
        if (isset($clinica)) {
            $clinica->nome = mb_strtoupper($request->input('nome'), 'UTF-8');
            $clinica->cep = $request->input('cep');
            $clinica->endereco = mb_strtoupper($request->input('endereco'));
            $clinica->telefone = mb_strtoupper($request->input('telefone'));
            $clinica->save();
            return json_encode($clinica);
        }
        return response('Clinica não encontrada', 404);
    }


    public function destroy($id)
    {
        $clinica = Clinica::find($id);
        if (isset($clinica)) {
            $clinica->delete();
            return response('OK', 200);
        }
        return response('Clinica não encontrado', 404);
    }

    public function loadJson()
    {

        $clinica = Clinica::all();
        return json_encode($clinica);
    }
}
