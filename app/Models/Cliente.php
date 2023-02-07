<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'telefone',
        'endereco',
    ];

    public function rules()
    {
        return [
            'nome' => 'required',
            'telefone' => 'required',
            'endereco' => 'required' ,
        ];
    }

    public function feedback()
    {
        return [
            'required' => 'O campo :attribute é obrigatório'
        ];
    }

    //relacionamento de pet com user (tutor)
    public function pets() {
        //Um TUTOR (user) possui MUITOS pets 
        return $this->hasMany('App\Models\Pet');
    }
}
