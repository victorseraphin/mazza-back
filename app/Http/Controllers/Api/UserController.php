<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\RequestResource;
use App\Http\Resources\ResponseResourceCollection;
use App\Models\User;
use Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = User::paginate();
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
            'name' => 'bail|required|string|max:255',
            'email' => 'bail|required|string|max:255|email|unique:users,email',
            'password' => 'bail|required|string|min:8'
        ]);

        $dados = new User();
        $dados->name = $request->input('name');
        $dados->email = $request->input('email');
        $dados->password = Hash::make($request->input('password'));
        $dados->save();

        Log::info("User ID {$dados->id} created successfully.");

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
        $dados = User::where('id',$id)->get();
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
            'name' => 'bail|required|string|max:255',
            'email' => 'bail|required|string|max:255|email|unique:users,email,'.$user->id
        ]);

        $dados = User::findOrFail($id);
        $dados->name = $request->input('name');
        $dados->email = $request->input('email');
        $dados->save();

        Log::info("User ID {$dados->id} updated successfully.");

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
        $dados = User::where('id',$id)->firstOrFail();
        $dados->delete();

        Log::info("User ID {$dados->id} deleted successfully.");

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
