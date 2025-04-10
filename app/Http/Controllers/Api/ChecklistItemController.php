<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecklistItemController extends Controller
{
    /**
     * Get all items in checklist
     */
    public function index($checklistId): JsonResponse
    {
        $checklist = Auth::user()->checklists()->findOrFail($checklistId);
        $items = $checklist->items()->get();

        return response()->json([
            'status' => true,
            'data' => $items
        ]);
    }

    /**
     * Create new item in checklist
     */
    public function store(Request $request, $checklistId): JsonResponse
    {
        $request->validate([
            'item_name' => 'required|string|max:255'
        ]);

        $checklist = Auth::user()->checklists()->findOrFail($checklistId);

        $item = $checklist->items()->create([
            'item_name' => $request->item_name,
            'is_completed' => false
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Item created successfully',
            'data' => $item
        ], 201);
    }

    /**
     * Update item status (complete/incomplete)
     */
    public function updateStatus($checklistId, $itemId): JsonResponse
    {
        $item = Auth::user()
            ->checklists()->findOrFail($checklistId)
            ->items()->findOrFail($itemId);

        $item->update([
            'is_completed' => !$item->is_completed
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Item status updated',
            'data' => $item
        ]);
    }

    /**
     * Rename checklist item
     */
    public function rename(Request $request, $checklistId, $itemId): JsonResponse
    {
        $request->validate([
            'item_name' => 'required|string|max:255'
        ]);

        $item = Auth::user()
            ->checklists()->findOrFail($checklistId)
            ->items()->findOrFail($itemId);

        $item->update([
            'item_name' => $request->item_name
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Item renamed successfully',
            'data' => $item
        ]);
    }

    /**
     * Delete checklist item
     */
    public function destroy($checklistId, $itemId): JsonResponse
    {
        $item = Auth::user()
            ->checklists()->findOrFail($checklistId)
            ->items()->findOrFail($itemId);

        $item->delete();

        return response()->json([
            'status' => true,
            'message' => 'Item deleted successfully'
        ]);
    }
}
