<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Repositories\ServicoRepository;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    protected $servico;
    public function __construct(Servico $servico)
    {
        $this->servico = $servico;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $servicoRepository = new ServicoRepository($this->servico);

        if ($request->has('filtro')) {
            $servicoRepository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $servicoRepository->selectAtributosCliente($request->atributos);
        }

        return response()->json($servicoRepository->getResultado(), 200);
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
        $request->validate($this->servico->rules(), $this->servico->feedback());

        $servico = $this->servico->create([
            'pet_id' => $request->pet_id,
            'funcionario_id' => $request->funcionario_id,
            'tipo' => $request->tipo,
            'preco' => $request->preco,
        ]);
        return response()->json($servico, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $servico = $this->servico->find($id);
        if ($servico === null) {
            return response()->json(['erro' => 'O recurso pesquisado não existe.'], 404);
        }
        return response()->json($servico, 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Servico  $servico
     * @return \Illuminate\Http\Response
     */
    public function edit(Servico $servico)
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
        $servico = $this->servico->find($id);

        if ($servico === null) {
            return response()->json(['erro' => 'Atualização falhou. O Tutor informado não existe.'], 404);
        }

        if ($request->method() ===  'PATCH') {

            $regrasDinamicas = array();

            //(*1)-percorrendo todas as regras (rules) definidas no model 
            foreach ($servico->rules() as $input => $regra) {
                //coletando as regras aplicaveis na requisicao patch
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas, $servico->feedback());
        } else {
            $request->validate($servico->rules(), $servico->feedback());
        }

        $servico->update($request->all());
        return response()->json($servico, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Servico  $servico
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $servico = $this->servico->find($id);

        if ($servico === null) {
            return response()->json(['erro' => 'Exclusão falhou. O id pesquisado não existe.'], 404);
        }

        $servico->delete();
        return response()->json(['msg' => 'Serviço cancelado com sucesso'], 200);
    }
}
