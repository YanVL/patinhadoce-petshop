<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Repositories\PetRepository;
use Illuminate\Http\Request;

class PetController extends Controller
{
    protected $pet;
    public function __construct(Pet $pet)
    {
        $this->pet = $pet;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $petRepository = new PetRepository($this->pet);

        if ($request->has('atributos_cliente')) {
            $atributos_cliente = 'cliente:id,' . $request->atributos_cliente;
            $petRepository->selectAtributosRegistros($atributos_cliente);
        } else {
            $petRepository->selectAtributosRegistros('cliente');
        }

        if ($request->has('filtro')) {
            $petRepository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $petRepository->selectAtributosCliente($request->atributos);
        }

        return response()->json($petRepository->getResultado(), 200);
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
        $request->validate($this->pet->rules(), $this->pet->feedback());

        $pet = $this->pet->create([
            'cliente_id' => $request->cliente_id,
            'nome' => $request->nome,
            'especie' => $request->especie,
            'observacao' => $request->observacao
        ]);
        return response()->json($pet, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pet = $this->pet->with('cliente')->find($id);
        if ($pet === null) {
            return response()->json(['erro' => 'O recurso pesquisado n??o existe.'], 404);
        }
        return response()->json($pet, 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function edit(Pet $pet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //(*1)-necessario realizar validacoes diferentes para os metodos put e patch
        $pet = $this->pet->find($id);

        if ($pet === null) {
            return response()->json(['erro' => 'Atualiza????o falhou. O funcion??rio n??o existe.'], 404);
        }

        if ($request->method() ===  'PATCH') {

            $regrasDinamicas = array();

            //(*1)-percorrendo todas as regras (rules) definidas no model 
            foreach ($pet->rules() as $input => $regra) {
                //coletando as regras aplicaveis na requisicao patch
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas, $pet->feedback());
        } else {
            $request->validate($pet->rules(), $pet->feedback());
        }

        $pet->update($request->all());
        return response()->json($pet, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pet = $this->pet->find($id);

        if ($pet === null) {
            return response()->json(['erro' => 'Exlus??o falhou. O id pesquisado n??o existe.'], 404);
        }

        $pet->delete();
        return response()->json(['msg' => 'Pet descadastrado'], 200);
    }
}
