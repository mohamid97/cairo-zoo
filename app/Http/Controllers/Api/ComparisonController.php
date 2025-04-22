<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ComparisonResource;
use App\Models\Admin\Comparison;
use App\Models\Admin\ComparisonItem;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComparisonController extends Controller
{
    use ResponseTrait;

    // Get user's comparison list
    public function index(Request $request)
    {
        $comparison = Comparison::with(['items.product'])->where('user_id', $request->user()->id)->first();
        
        return $this->res(true, 'User Comparison List', 200, new ComparisonResource($comparison));
    }

    // Add a product to comparison list
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        
        try {
            DB::beginTransaction();

            // Get authenticated user
            $user = $request->user();

            // Find or create the comparison for the user
            $comparison = Comparison::firstOrCreate(['user_id' => $user->id]);

            // Check if the product is already in the comparison list
            $comparisonItem = ComparisonItem::where('comparison_id', $comparison->id)
                ->where('product_id', $request->product_id)
                ->first();

            if (!$comparisonItem) {
                // Add the product to the comparison if it doesn't exist
                ComparisonItem::create([
                    'comparison_id' => $comparison->id,
                    'product_id' => $request->product_id,
                ]);
            }
            
            DB::commit();
            
            return $this->res(true, 'Product added to comparison list', 200, new ComparisonResource($comparison->load(['items.product'])));

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->res(false, $e->getMessage(), 500);
        }
    }

    // Remove a product from comparison list
    public function delete(Request $request)
    {
        $user = $request->user();
        
        // Fetch the user's comparison
        $comparison = Comparison::where('user_id', $user->id)->first();

        if (!$comparison) {
            return $this->res(true, 'No Comparison List For This User', 404);
        }

        // Now fetch the comparison item based on the retrieved comparison ID
        $comparisonItem = ComparisonItem::where('comparison_id', $comparison->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($comparisonItem) {
            $comparisonItem->delete();
            return $this->res(true, 'Comparison Item Deleted Successfully', 200, new ComparisonResource($comparison->load(['items.product'])));
        }

        return $this->res(true, 'Comparison Item Not Found', 404);
    }
}
