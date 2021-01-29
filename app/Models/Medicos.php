<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicos extends Model
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = ['id','nome','cpf_cnpj','email','telefone1','telefone2','cep','endereco','numero'];
    protected $hidden = ['created_at','updated_at','deleted_at'];
    protected $table = 'medicos';

    static function do_all(){
        $data = Medicos::paginate();
        return $data;
    }

    static function do_show($id){
        $data = Medicos::where('id',$id)->get();
        return $data;
    }

    static function do_save($request, $id = null){
        if($id){
        $data = Medicos::findOrFail($id);
        }else{
        $data = new Medicos;
        }

        $data->nome         = $request['nome'];
        $data->cpf_cnpj     = $request['cpf_cnpj'];
        $data->email        = $request['email'];
        $data->telefone1    = $request['telefone1'];
        $data->telefone2    = $request['telefone2'];
        $data->cep          = $request['cep'];
        $data->endereco     = $request['endereco'];
        $data->numero       = $request['numero'];
        $data->save();
        return $data;
    }

    static function do_delete($id){
        $data = Medicos::where('id',$id)->firstOrFail();
        $data->delete();
        return $data;
    }
}
