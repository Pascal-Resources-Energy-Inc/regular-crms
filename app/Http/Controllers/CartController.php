<?php

namespace App\Http\Controllers;

use App\TransactionDetail;
use App\AreaDistributor;
use App\Item;
use App\Client;
use App\Dealer;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // public function index(Request $request)
    // {
    //     $customers = Client::whereHas('serial')->get();
    //     $items = Item::get();
    //     $dealers = Dealer::get();
    //     $transactions = [];
    //     //  dd(auth()->user());
    //     if(auth()->user()->role == "Admin")
    //     {
    //         $transactions = TransactionDetail::get();
    //     }
    //     elseif(auth()->user()->role == "Dealer")
    //     {
    //         $transactions = TransactionDetail::where('dealer_id',auth()->user()->id)->get();
    //     }
    //     return view('cart',
    //         array(
    //             'transactions' => $transactions,
    //             'items' => $items,
    //             'customers' => $customers,
    //             'dealers' => $dealers,
    //         )
    //     );
    // }
    public function index(Request $request)
    {
        $user = auth()->user(); // ✅ FIX: define user
        
        $customers = Client::whereHas('serial')->get();
        $items = Item::get();
        $dealers = Dealer::get();

        $transactions = [];

        $areaDistributor = AreaDistributor::with('areas')->get();

        if ($user->role == "Admin") {
            $transactions = TransactionDetail::get();
        } elseif ($user->role == "Dealer") {
            $transactions = TransactionDetail::where('dealer_id', $user->id)->get();
        }

        $matchedAD = null;

        if ($user->dealer->center) {
            $matchedAD = AreaDistributor::whereHas('areas', function ($q) use ($user) {
                $q->where('name', $user->dealer->center);
            })->first();
        }
        
        return view('cart', [
            'transactions' => $transactions,
            'items' => $items,
            'customers' => $customers,
            'dealers' => $dealers,
            'areaDistributor' => $areaDistributor,
            'userCenter' => $user->dealer->center ?? null, // ✅ FIXED
            'matchedAD' => $matchedAD,
        ]);
    }
    
}
