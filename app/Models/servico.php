<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $fillable = ['pet_id', 'funcionario_id', 'nome', 'tipo', 'preco'];

    public function rules()
    {
        return [
            'pet_id' => 'exists:pets,id',
            'funcionario_id' => 'exists:funcionarios,id',
            'tipo' => 'required|integer|digits_between:1,3',
            'preco' => 'required',
        ];
    }

    public function feedback()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
        ];
    }
}
