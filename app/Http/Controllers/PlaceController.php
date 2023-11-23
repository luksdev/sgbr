<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceRequest;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlaceController extends Controller
{
    public function index(Request $request)
    {
        try {
            $places = new Place();

            $params = $request->all();

            if (isset($params['name'])) {
                $places = $places->where('name', 'like', '%' . $params['name'] . '%');
            }

            return response()->json([
                'success' => true,
                'message' => 'Locais listados com sucesso',
                'data' => $places->get()->toArray()
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Falha ao listar locais. Verifique os dados e tente novamente ou contate o suporte se o problema persistir.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(PlaceRequest $request)
    {
        try {
            $place = Place::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Local cadastrado com sucesso',
                'data' => $place->toArray()
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Falha no cadastro do local. Verifique os dados e tente novamente ou contate o suporte se o problema persistir.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $place = Place::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Local encontrado com sucesso',
                'data' => $place
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Local não encontrado. Verifique se o identificador fornecido está correto e tente novamente.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(PlaceRequest $request, $id)
    {
        try {
            $place = Place::find($id);

            if ($place) {
                $place->update($request->validated());

                return response()->json([
                    'success' => true,
                    'message' => 'Local atualizado com sucesso',
                    'data' => $place
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Local não encontrado',
                ], Response::HTTP_NOT_FOUND);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar local',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function destroy($id)
    {
        try {
            $place = Place::findOrFail($id);

            if (!empty($place)) {
                $place->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Local removido com sucesso',
                    'id' => $id
                ], Response::HTTP_OK);
            }

            return response()->json([
                'success' => false,
                'message' => 'Local não encontrado',
                'id' => $id
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao remover local',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
