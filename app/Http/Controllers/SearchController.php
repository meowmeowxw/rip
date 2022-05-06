<?php


namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Category;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    /**
     * Return JSON of a product name search
     * @param id of the product
     *
     * @return  View
     */
    public function search(Request $request)
    {
        $output = '';
        if ($request->ajax() && $request->name !== null) {
            $products = Product::where('active', true)
                ->where('name', 'like', '%' . $request->name . '%')
                ->take(5)
                ->get();

            if (count($products) > 0) {
                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
                foreach ($products as $product) {
                    $output .= '<a href="' . route('product.id', $product->id) . '">' . '<li class="list-group-item">' . htmlspecialchars($product->name) . '</li></a>';
                }
                $output .= '</ul>';
            } else {
                $output .= '<li class="list-group-item">' . 'No results' . '</li>';
            }
            return $output;
        } else {
            $request->validate([
                'search' => 'required|string',
            ]);

            $products = Product::where('active', true)
                ->where('name', 'like', '%' . $request->search . '%')
                ->get();

            return view('search', [
                'products' => $products,
                'search' => $request->search,
            ]);
        }
    }

}
