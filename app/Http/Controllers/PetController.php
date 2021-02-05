<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Pet;
use \App\Raca;
use Carbon\Carbon;

class PetController extends Controller
{

    public function index()
    {
        $racas = Raca::all(); 
        $pets = Pet::all();
        return view('pet.index', compact(['pets', 'racas']));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $raca = Raca::select('*')->where('nome', $request->input('raca_id'))->get()->toJson();
        $pet = new Pet();
        $pet->nome = mb_strtoupper($request->input('nome'), 'UTF-8');
        $pet->nascimento = $request->input('nascimento');
        $pet->raca_id = $raca[7];
        $pet->save();


        return json_encode($pet);
    }

    public function show($id)
    {
        $racas = Raca::all();
        $pet = Pet::find($id);
        $raca = Raca::find($pet->raca_id);
        if (isset($pet)) {
            $data[0] = $pet;
            $data[1] = $raca;
            $data[2] = $racas;
            return json_encode($data);
        }

        return response('Pet não encontrado', 404);
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {

        $racas = Raca::all();
        $raca = Raca::select('*')->where('nome', $request->input('raca_id'))->get()->toJson();
        $pet = Pet::find($id);
        if (isset($pet)) {
            $pet->nome = mb_strtoupper($request->input('nome'), 'UTF-8');
            $pet->nascimento = $request->input('nascimento');
            $pet->raca_id = $raca[7];
            $pet->save();

            $data[0] = $pet;
            $data[1] = $raca;
            $data[2] = $racas;
            return json_encode($data);
        }

        return response('Pet não encontrado', 404);
    }

    public function destroy($id)
    {

        $pet = Pet::find($id);
        if (isset($pet)) {
            $pet->delete();
            return response('OK', 200);
        }
        return response('Pet não encontrado', 404);
    }

    public function loadJson()
    {

        $pet = Pet::all();
        return json_encode($pet);
    }
}
