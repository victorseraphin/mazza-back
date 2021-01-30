<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\RequestResource;
use App\Http\Resources\ResponseResourceCollection;
use App\Models\Medicos;
use Log;

class MedicosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = Medicos::do_all();
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
        $validate = $this->validate_inputs($request);

        if(!$validate){
            $dados = Medicos::do_save($request);
            if($dados){
                Log::info("Medico ID {$dados->id} created successfully.");
                return (new RequestResource($dados))->response()->setStatusCode(Response::HTTP_CREATED);
            }else{
                Log::info("Medico ID {$dados->id} problem registering new record.");
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
        $dados = Medicos::do_show($id);
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
        $validate = $this->validate_inputs($request, $id);
        if(!$validate){
            $dados = Medicos::do_save($request, $id);
            if($dados){
                Log::info("Medico ID {$dados->id} updated successfully.");
                return (new RequestResource($dados))->response()->setStatusCode(Response::HTTP_CREATED);
            }else{
                Log::info("Medico ID {$dados->id} problem changing record.");
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
        $dados = Medicos::do_delete($id);
        if($dados){
            Log::info("Medico ID {$dados->id} deleted successfully.");
            return response(null, Response::HTTP_NO_CONTENT);
        }else{
            Log::info("Medico ID {$dados->id} problem deleting record.");
            return response()->json(['message' => 'Problem deleting record.'], 404);
        }        
    }

     /**
    * Validates input
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function validate_inputs($request, $id = null)
    {        
        $verificar_email = Medicos::where('email','=',$request->email)->first();
        if($id != null){
            
            if($verificar_email != null and $verificar_email->id != $id){
                return response()->json(['message' => "Este e-mail já está cadastrado no sistema!"], 404);
            }
        }else{
            if($verificar_email != null){
                return response()->json(['message' => "Este e-mail já está cadastrado no sistema!"], 404);
            }
        } 
        if($request->nome ==  null){
            return response()->json(['message' => "Digite um nome."], 404);
        }
        if($request->email ==  null){
            return response()->json(['message' => "Digite um e-mail."], 404);
        }        
    }
}
