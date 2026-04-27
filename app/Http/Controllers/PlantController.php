<?php

namespace App\Http\Controllers;

use App\Models\PlantModel;
use Illuminate\Http\Request;
use \Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class PlantController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //TODO : implement load all the records
    $plants = PlantModel::paginate(15);
    
    return response()->json([
      'success' => true,
      'data' => $plants->items(),
      'pagination' => [
        'current_page' => $plants->currentPage(),
        'per_page' => $plants->perPage(),
        'total' => $plants->total(),
        'last_page' => $plants->lastPage(),
      ]
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //TODO: implement save record functionality
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'variety' => 'nullable|string|max:255',
      'notes' => 'nullable|string',
      'date_planted' => 'required|date',
      'seedling_count' => 'nullable|integer|min:0',
      'batch_name' => 'nullable|string|max:255',
      'starting_fund' => 'nullable|numeric|min:0',
      'seedling_source' => 'nullable|string|max:255',
    ]);

    $plant = PlantModel::create($validated);

    return response()->json([
      'success' => true,
      'message' => 'Plant record created successfully',
      'data' => $plant
    ], 201);
  }

  /**
   * Display the specified resource.
   */
  public function show(PlantModel $plantController)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, PlantModel $plantController)
  {
    //TODO : implement update record functionality
    $validated = $request->validate([
      'name' => 'sometimes|required|string|max:255',
      'variety' => 'nullable|string|max:255',
      'notes' => 'nullable|string',
      'date_planted' => 'sometimes|required|date',
      'seedling_count' => 'nullable|integer|min:0',
      'batch_name' => 'nullable|string|max:255',
      'starting_fund' => 'nullable|numeric|min:0',
      'seedling_source' => 'nullable|string|max:255',
    ]);

    $plantController->update($validated);

    return response()->json([
      'success' => true,
      'message' => 'Plant record updated successfully',
      'data' => $plantController->fresh()
    ]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(PlantModel $plant)
  {
    //TODO : implement delete record functionality
    $plant->delete();

    return response()->json([
      'success' => true,
      'message' => 'Plant record deleted successfully'
    ]);
  }
}
