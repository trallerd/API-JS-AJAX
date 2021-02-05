<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Especialidade;

class especialidadeController extends Controller
{

    public function index()
    {
        $especialidades = Especialidade::all();
        return view('especialidade.index')->with('especialidades',$especialidades);
    }


    public function create()
    {
    }

    public function store(Request $request)
    {
        $especialidade = new Especialidade();
        $especialidade->nome = mb_strtoupper($request->input('nome'), 'UTF-8');
        $especialidade->descricao = $request->input('descricao');
        $especialidade->save();

        return json_encode($especialidade);
    }

    public function show($id){
        $especialidade = Especialidade::find($id);
        if (isset($especialidade)) {
            return json_encode($especialidade);
        }
        return response('Especialidade não encontrada', 404);
    }

    public function edit($id){}

    public function update(Request $request, $id){
        $especialidade = Especialidade::find($id);
        if (isset($especialidade)) {
            $especialidade->nome = mb_strtoupper($request->input('nome'), 'UTF-8');
            $especialidade->descricao = $request->input('descricao');
            $especialidade->save();
            return json_encode($especialidade);
        }
        return response('Especialidade não encontrada', 404);
    }


    public function destroy($id){
        $especialidade = Especialidade::find($id);
        if (isset($especialidade)) {
            $especialidade->delete();
            return response('OK',200);
        }
        return response('Especialidade não encontrada', 404);
    }
    public function loadJson(){
        $especialidade = Especialidade::all();
        return json_encode($especialidade);
    }
}
