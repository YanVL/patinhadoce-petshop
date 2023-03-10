<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = ['cliente_id', 'nome', 'especie', 'observacao'];

    public function rules()
    {
        return [
            'cliente_id' => 'exists:clientes,id',
            'nome' => 'required',
            'especie' => 'required',
            'observacao' 
        ];
    }

    public function feedback()
    {
        return [
            'required' => 'O campo :attribute é obrigatório'
        ];
    }

    //relacionamento de Cliente (tutor) com pet
    public function cliente() {
        //Um pet tem apenas UM Cliente (tutor)
        return $this->belongsTo('App\Models\Cliente');
    }
}
