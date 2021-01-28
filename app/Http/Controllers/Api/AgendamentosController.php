<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\RequestResource;
use App\Http\Resources\ResponseResourceCollection;
use App\Models\Agendamentos;
use Log;

class AgendamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = Agendamentos::paginate();
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
            'medicos_id' => 'required',
            'pacientes_id' => 'required',
            'data' => 'required',
            'hora_ini' => 'required',
            'hora_fin' => 'required',
        ]);

        $dados = new Agendamentos();
        $dados->medicos_id      = $request->input('medicos_id');
        $dados->pacientes_id    = $request->input('pacientes_id');
        $dados->data            = $request->input('data');
        $dados->hora_ini        = $request->input('hora_ini');
        $dados->hora_fin        = $request->input('hora_fin');
        $dados->status          = $request->input('status');
        $dados->save();

        Log::info("Agendamento ID {$dados->id} created successfully.");

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
        $dados = Agendamentos::where('id',$id)->get();
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
            'medicos_id' => 'required',
            'pacientes_id' => 'required',
            'data' => 'required',
            'hora_ini' => 'required',
            'hora_fin' => 'required',
        ]);

        $dados = Agendamentos::findOrFail($id);
        $dados->medicos_id      = $request->input('medicos_id');
        $dados->pacientes_id    = $request->input('pacientes_id');
        $dados->data            = $request->input('data');
        $dados->hora_ini        = $request->input('hora_ini');
        $dados->hora_fin        = $request->input('hora_fin');
        $dados->status          = $request->input('status');
        $dados->save();

        Log::info("Agendamento ID {$dados->id} updated successfully.");

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
        $dados = Agendamentos::where('id',$id)->firstOrFail();
        $dados->delete();

        Log::info("Agendamento ID {$dados->id} deleted successfully.");

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
