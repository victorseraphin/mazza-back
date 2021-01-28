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
    protected $table ='medicos';
}
