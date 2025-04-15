<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Member;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $orders = Order::where('member_id', 'LIKE', "%{$query}%")
                ->orWhere('total_price', 'LIKE', "%{$query}%")
                ->orWhere('status', 'LIKE', "%{$query}%")
                ->paginate(5);
        } else {
            $orders = Order::with('member', 'user')->paginate(5);
        }

        return view('order.index', compact('orders'));
    }

    public function review(Request $request)
    {

        $cartDataJson = $request->input('cart_data');

        $cartData = json_decode($cartDataJson, true);

        $productIds = array_keys($cartData);
        $products = Product::whereIn('id', $productIds)->get();

        $total = 0;
        foreach ($products as $product) {
            $qty = $cartData[$product->id];
            $total += $product->price * $qty;
        }       

        return view('order.review', [
            'products' => $products,
            'cartData' => $cartData,
            'total' => $total,  
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $isPointUse = $request->usePoint === 'true';
        $ordersData = json_decode($request->orders, true); // perbaikan di sini!
        $phone = $request->phone;
        $grandTotal = (int) $request->grand_total;
        $totalPayment = (int) $request->total_payment;
        
    
        $member = Member::where('no_telp', $phone)->first();
        $poinUsed = $member ? $member->poin : 0;
    
        $member_status = $request->member;  
        if ($member_status === 'member') {
            if (!$member) {
                // Buat member baru
                $member = Member::create([
                    'name' => $request->member_name,
                    'no_telp' => $phone,
                    'poin' => $grandTotal * 0.10,
                ]);
            } else {
                // Member sudah ada, update poin
                if ($isPointUse) {
                    $grandTotal -= $member->poin;
                    $member->poin = $grandTotal * 0.10;
                } else {
                    $member->poin += $grandTotal * 0.10;
                }
                $member->save();
            }
        }
    
        // Simpan order
        $order = Order::create([
            'member_id' => $member->id ?? 0,
            'staff_id' => 1, // Ganti jika ada sistem auth
            'total_price' => $grandTotal,
            'total_pay' => $totalPayment,
            'change' => $totalPayment - $grandTotal,
            'poinUse' => $isPointUse ? $poinUsed : 0,
        ]);
    
        // Simpan detail order
        foreach ($ordersData as $orderItem) {
            DetailOrder::create([
                'order_id' => $order->id,
                'product_id' => $orderItem['id'],
                'quantity' => $orderItem['quantity'],
                'subtotal' => $orderItem['subtotal'],
            ]);
    
            // Update stok produk
            $product = Product::find($orderItem['id']);
            if ($product) {
                $product->stock -= $orderItem['quantity'];
                $product->save();
            }
        }
    
        return view('order.invoice', [
            'order' => $order,
            'member' => $member ?? null,
            'detailOrders' => $order->detailOrder,
        ]);
    }
    


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
