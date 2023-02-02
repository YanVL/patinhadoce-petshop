<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nome', 'especie', 'observacao'];

    public function rules()
    {
        return [
            'user_id' => 'exists:users,id',
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
}
