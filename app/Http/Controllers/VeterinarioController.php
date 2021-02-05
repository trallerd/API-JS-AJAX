<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Veterinario;
use \App\Especialidade;

class VeterinarioController extends Controller
{

    public function index()
    {
        $especialidades = Especialidade::all();
        $veterinarios = Veterinario::all();
        return view('veterinario.index',compact(['veterinarios','especialidades']));
    }


    public function create(){}

    public function store(Request $request){
        $especialidade = Especialidade::select('*')->where('nome', $request->input('especialidade_id'))->get()->toJson();
        $veterinario = new Veterinario();
        $veterinario->nome = mb_strtoupper($request->input('nome'), 'UTF-8');
        $veterinario->crmv = $request->input('crmv');
        $veterinario->especialidade_id = $especialidade[7];
        $veterinario->save();

        return json_encode($veterinario);
    }

    public function show($id)
    {
        $especialidades = Especialidade::all();
        $veterinario = Veterinario::find($id);
        $especialidade = Especialidade::find($veterinario->especialidade_id);
        if (isset($veterinario)) {
            $data[0] = $veterinario;
            $data[1] = $especialidade;
            $data[2] = $especialidades;
            return json_encode($data);
        }

        return response('Veterinario não encontrada', 404);
    }

    public function edit($id){}


    public function update(Request $request, $id)
    {
        $especialidades = Especialidade::all();
        $especialidade = Especialidade::select('*')->where('nome', $request->input('especialidade_id'))->get()->toJson();
        $veterinario = Veterinario::find($id);
        if (isset($veterinario)) {
            $veterinario->nome = mb_strtoupper($request->input('nome'), 'UTF-8');
            $veterinario->crmv = $request->input('crmv');
            $veterinario->especialidade_id = $especialidade[7];
            $veterinario->save();
                $data[0] = $veterinario;
                $data[1] = $especialidade;
                $data[2] = $especialidades;
                return json_encode($data);
        }
            return response('Veterinario não encontrado', 404);
    }


    public function destroy($id)
    {
        $veterinario = Veterinario::find($id);
        if (isset($veterinario)) {
            $veterinario->delete();
            return response('OK', 200);
        }
        return response('Veterinario não encontrado', 404);
        return redirect()->route('veterinario.index');
    }

    public function loadJson()
    {
        $veterinario = Veterinario::all();
        return json_encode($veterinario);
    }
}
