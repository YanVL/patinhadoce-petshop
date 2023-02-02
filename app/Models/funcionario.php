<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'funcao'];

    public function rules()
    {
        return [
            'nome' => 'required|min:2',
            'funcao' => 'required|integer|digits_between:1,3'
        ];
    }

    public function feedback()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
        ];
    }
}
