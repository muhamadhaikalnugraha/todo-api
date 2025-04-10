<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $checklists = auth()->user()->checklists()->with('items')->get();

        return response()->json([
            'status' => true,
            'data' => [
                'checklists' => $checklists,
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $checklist = auth()->user()->checklists()->create([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Checklist created successfully',
            'data' => [
                'checklist' => $checklist,
            ],
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $checklist = auth()->user()->checklists()->with('items')->findOrFail($id);

        return response()->json([
            'status' => true,
            'checklist' => $checklist,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $checklist = auth()->user()->checklists()->findOrFail($id);

        $checklist->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Checklist updated successfully',
            'checklist' => $checklist,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $checklistId): JsonResponse
    {
        $checklist = auth()->user()->checklists()->findOrFail($checklistId);

        $checklist->delete();

        return response()->json([
            'status' => true,
            'message' => 'Checklist deleted successfully',
            'data' => [
                'checklist' => $checklist,
            ],
        ]);
    }
}
