<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Raca;

class RacaController extends Controller {

    public function index() {

        $racas = Raca::all();
        return view('raca.index')->with('racas', $racas);
    }

    public function create() { }

    public function store(Request $request) {

        $raca = new Raca();
        $raca->nome = mb_strtoupper($request->input('nome'), 'UTF-8');
        $raca->descricao = mb_strtoupper($request->input('descricao'), 'UTF-8');
        $raca->save();

        return json_encode($raca);
    }

    public function show($id) {

        $raca = Raca::find($id);
        if (isset($raca)) {
            return json_encode($raca);
        }

        return response('Produto não encontrado', 404);
    }

    public function edit($id) { }

    public function update(Request $request, $id) {

        $raca = Raca::find($id);
        if (isset($raca)) {
            $raca->nome = mb_strtoupper($request->input('nome'), 'UTF-8');
            $raca->descricao = mb_strtoupper($request->input('descricao'), 'UTF-8');
            $raca->save();
            return json_encode($raca);
        }

        return response('Raça não encontrada', 404);
    }

    public function destroy($id) {

        $raca = Raca::find($id);
        if (isset($raca)) {
            $raca->delete();
            return response('OK', 200);
        }
        return response('Raça não encontrada', 404);
    }

    public function loadJson() {

        $raca = Raca::all();
        return json_encode($raca);
    }
}