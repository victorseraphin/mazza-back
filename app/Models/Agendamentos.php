<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agendamentos extends Model
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = ['id','Agendamentos_id','pacientes_id','data','hora_ini','hora_fin','status'];
    protected $hidden = ['created_at','updated_at','deleted_at'];
    protected $table ='agendamentos';

    static function do_all(){
        $data = Agendamentos::get();
        return $data;
    }

    static function do_show($id){
        $data = Agendamentos::where('id',$id)->get();
        return $data;
    }

    static function do_save($request, $id = null){
        if($id){
        $data = Agendamentos::findOrFail($id);
        }else{
        $data = new Agendamentos;
        }

        $data->medicos_id       = $request['medicos_id'];
        $data->pacientes_id     = $request['pacientes_id'];
        $data->data             = $request['data'];
        $data->hora_ini         = $request['hora_ini'];
        $data->hora_fin         = $request['hora_fin'];
        $data->status           = $request['status'];
        $data->save();
        return $data;
    }

    static function do_delete($id){
        $data = Agendamentos::where('id',$id)->firstOrFail();
        $data->delete();
        return $data;
    }
}
