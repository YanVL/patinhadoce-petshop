<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    protected $funcionario;
    public function __construct(Funcionario $funcionario)
    {
        $this->funcionario = $funcionario;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $funcionario = $this->funcionario->all();
        return response()->json($funcionario, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->funcionario->rules(), $this->funcionario->feedback());

        $funcionario = $this->funcionario->create($request->all());
        return response()->json($funcionario, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $funcionario = $this->funcionario->find($id);
        if ($funcionario === null) {
            return response()->json(['erro' => 'O recurso pesquisado não existe.'], 404);
        }
        return response()->json($funcionario, 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Funcionario  $funcionario
     * @return \Illuminate\Http\Response
     */
    public function edit(Funcionario $funcionario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //(*1)-necessario realizar validacoes diferentes para os metodos put e patch
        $funcionario = $this->funcionario->find($id);

        if ($funcionario === null) {
            return response()->json(['erro' => 'Atualização falhou. O funcionário não existe.'], 404);
        }

        if ($request->method() ===  'PATCH') {

            $regrasDinamicas = array();

            //(*1)-percorrendo todas as regras (rules) definidas no model 
            foreach ($funcionario->rules() as $input => $regra) {
                //coletando as regras aplicaveis na requisicao patch
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas, $funcionario->feedback());
        } else {
            $request->validate($funcionario->rules(), $funcionario->feedback());
        }

        $funcionario->update($request->all());
        return response()->json($funcionario, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Funcionario  $funcionario
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $funcionario = $this->funcionario->find($id);

        if ($funcionario === null) {
            return response()->json(['erro' => 'Exclusão falhou. O id pesquisado não existe.'], 404);
        }

        $funcionario->delete();
        return response()->json(['msg' => 'Funcionário removido com sucesso'], 200);
    }
}
