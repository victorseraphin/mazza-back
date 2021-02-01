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
        $dados = Agendamentos::do_all();
        return response()->json($dados, 200);
        //return (new ResponseResourceCollection($dados))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $this->validate_inputs($request);

        if(!$validate){
            $dados = Agendamentos::do_save($request);
            if($dados){
                Log::info("Agendamento ID {$dados->id} created successfully.");
                return (new RequestResource($dados))->response()->setStatusCode(Response::HTTP_CREATED);
            }else{
                Log::info("Agendamento ID {$dados->id} problem registering new record.");
                return response()->json(['message' => 'Problem registering new record.'], 404);
            }
        }else{
            return response()->json(['message' => $validate], 404);
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dados = Agendamentos::do_show($id);
        return response()->json($dados, 200);
        //return (new ResponseResourceCollection($dados))->response();
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
        $validate = $this->validate_inputs($request);
        if(!$validate){
            $dados = Agendamentos::do_save($request, $id);
            if($dados){
                Log::info("Agendamento ID {$dados->id} updated successfully.");
                return (new RequestResource($dados))->response()->setStatusCode(Response::HTTP_CREATED);
            }else{
                Log::info("Agendamento ID {$dados->id} problem changing record.");
                return response()->json(['message' => 'Problem changing record.'], 404);
            }
        }else{
            return response()->json(['message' => $validate], 404);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dados = Agendamentos::do_delete($id);
        if($dados){
            Log::info("Agendamento ID {$dados->id} deleted successfully.");
            return response(null, Response::HTTP_NO_CONTENT);
        }else{
            Log::info("Agendamento ID {$dados->id} problem deleting record.");
            return response()->json(['message' => 'Problem deleting record.'], 404);
        }        
    }

     /**
    * Validates input
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function validate_inputs($request)
    {   
        if($request->medicos_id ==  null){
            return response()->json(['message' => "Escolha um medico."], 404);
        }
        if($request->pacientes_id ==  null){
            return response()->json(['message' => "Escolha um paciente."], 404);
        }
        if($request->data ==  null){
            return response()->json(['message' => "Digite uma data."], 404);
        }
        if($request->hora_ini ==  null){
            return response()->json(['message' => "Digite um horário de início."], 404);
        }
        if($request->hora_fin ==  null){
            return response()->json(['message' => "Digite um horário final."], 404);
        }        
    }
}
