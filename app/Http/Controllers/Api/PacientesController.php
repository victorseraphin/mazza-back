<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\RequestResource;
use App\Http\Resources\ResponseResourceCollection;
use App\Models\Pacientes;
use Log;

class PacientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = Pacientes::paginate();
        return (new ResponseResourceCollection($dados))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'bail|required|string|max:255',
            'email' => 'bail|required|string|max:255|email|unique:pacientes,email'
        ]);

        $dados = new Pacientes();
        $dados->nome = $request->input('nome');
        $dados->cpf_cnpj = $request->input('cpf_cnpj');
        $dados->email = $request->input('email');
        $dados->telefone1 = $request->input('telefone1');
        $dados->telefone2 = $request->input('telefone2');
        $dados->cep = $request->input('cep');
        $dados->endereco = $request->input('endereco');
        $dados->numero = $request->input('numero');
        $dados->save();

        Log::info("Paciente ID {$dados->id} created successfully.");

        return (new RequestResource($dados))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dados = Pacientes::where('id',$id)->get();
        return (new RequestResource($dados))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'bail|required|string|max:255',
            'email' => 'bail|required|string|max:255|email|unique:pacientes,email,'.$id
        ]);

        $dados = Pacientes::findOrFail($id);
        $dados->nome = $request->input('nome');
        $dados->cpf_cnpj = $request->input('cpf_cnpj');
        $dados->email = $request->input('email');
        $dados->telefone1 = $request->input('telefone1');
        $dados->telefone2 = $request->input('telefone2');
        $dados->cep = $request->input('cep');
        $dados->endereco = $request->input('endereco');
        $dados->numero = $request->input('numero');
        $dados->save();

        Log::info("Paciente ID {$dados->id} updated successfully.");

        return (new RequestResource($dados))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dados = Pacientes::where('id',$id)->firstOrFail();
        $dados->delete();

        Log::info("Paciente ID {$dados->id} deleted successfully.");

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
