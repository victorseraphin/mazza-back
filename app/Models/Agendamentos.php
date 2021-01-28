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

    protected $fillable = ['id','medicos_id','pacientes_id','data','hora_ini','hora_fin','status'];
    protected $hidden = ['created_at','updated_at','deleted_at'];
    protected $table ='agendamentos';
}
