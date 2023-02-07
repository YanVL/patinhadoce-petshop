<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;


class ClienteController extends Controller
{
    protected $cliente;
    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clientes = array();

        if ($request->has('atributos_pets')) {
            $atributos_pets = $request->atributos_pets;
            $clientes = $this->cliente->with('pets:id,' . $atributos_pets);
        } else {
            $clientes = $this->cliente->with('pets');
        }

        if ($request->has('filtro')) {
            $filtros = explode(';', $request->filtro);
            foreach ($filtros as $key => $condicao) {

                $condicaoDePesquisa = explode(':', $condicao);
                $clientes = $clientes->where($condicaoDePesquisa[0], $condicaoDePesquisa[1], $condicaoDePesquisa[2]);
            }
        }

        if ($request->has('atributos')) {
            $atributos = $request->atributos;
            $clientes = $clientes->selectRaw($atributos)->get();
        } else {
            $clientes = $clientes->get();
        }

        return response()->json($clientes, 200);
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
     * @param  \App\Http\Requests\StoreClienteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->cliente->rules(), $this->cliente->feedback());

        $cliente = $this->cliente->create([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'endereco' => $request->endereco
        ]);
        return response()->json($cliente, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = $this->cliente->with('pets')->find($id);
        if ($cliente === null) {
            return response()->json(['erro' => 'O recurso pesquisado não existe.'], 404);
        }
        return response()->json($cliente, 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClienteRequest  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //(*1)-necessario realizar validacoes diferentes para os metodos put e patch
        $cliente = $this->cliente->find($id);

        if ($cliente === null) {
            return response()->json(['erro' => 'Atualização falhou. O Tutor informado não existe.'], 404);
        }

        if ($request->method() ===  'PATCH') {

            $regrasDinamicas = array();

            //(*1)-percorrendo todas as regras (rules) definidas no model 
            foreach ($cliente->rules() as $input => $regra) {
                //coletando as regras aplicaveis na requisicao patch
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas, $cliente->feedback());
        } else {
            $request->validate($cliente->rules(), $cliente->feedback());
        }

        $cliente->update($request->all());
        return response()->json($cliente, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = $this->cliente->find($id);

        if ($cliente === null) {
            return response()->json(['erro' => 'Exlusão falhou. O id pesquisado não existe.'], 404);
        }

        $cliente->delete();
        return response()->json(['msg' => 'cliente descadastrado com sucesso'], 200);
    }
}
