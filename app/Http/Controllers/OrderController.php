<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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


    public function export()
    {
        return Excel::download(new OrdersExport, 'orders.xlsx');
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
        $ordersData = json_decode($request->orders, true); 
        $phone = $request->phone;
        $grandTotalRaw = (int) $request->grand_total;
        $totalPayment = (int) $request->total_payment;
        
    
        $member = Member::where('no_telp', $phone)->first();
        $poinUsed = $member ? $member->poin : 0;

        $member_status = $request->member;  
        // dd($member_status, $phone);
        $grandTotal = $grandTotalRaw;

        if ($member_status === 'member') {
            if ($member === null) {
                $member = Member::create([
                    'name' => $request->member_name,
                    'no_telp' => $phone,
                    'poin' => $grandTotalRaw * 0.10,
                ]);
            } else {
                if ($isPointUse) {
                    $grandTotal -= $member->poin;
                    $member->poin = $grandTotalRaw * 0.10;
                } else {
                    $member->poin += $grandTotalRaw * 0.10;
                }
                $member->save();
            }
        }

        $userID = auth()->user()->id;
    
        $order = Order::create([
            'member_id' => $member->id ?? null,
            // ganti kalo udah ada auth
            'staff_id' => $userID, 
            'total_price' => $grandTotal === 0 ? $grandTotalRaw : $grandTotal,
            'total_pay' => $totalPayment,
            'total_return' => $totalPayment - $grandTotal,
            'poin' => $isPointUse ? $poinUsed : 0,
        ]);

        // dd($);
    
        foreach ($ordersData as $orderItem) {
            DetailOrder::create([
                'order_id' => $order->id,
                'product_id' => $orderItem['id'],
                'quantity' => $orderItem['quantity'],
                'subtotal' => $orderItem['subtotal'],
            ]);

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
    
    public function invoice($id)
    {
        $order = Order::findOrFail($id);
        $staff = User::findOrFail($order->staff_id); 
        $member = $order->member;
        $detailOrders = $order->detailOrder;
        return view('order.invoice', compact('order', 'member', 'detailOrders', 'staff'));
    }

    // public function pdf($id) {
    //     $order = Order::findOrFail($id);
    //     $member = $order->member;
    //     $detailOrders = $order->detailOrder;
    //     return view('order.downloadInvoice', compact('order', 'member', 'detailOrders'));
    // }

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
    public function exportPDF($id) {
        $order = Order::findOrFail($id);
        $member = $order->member;
        $detailOrders = $order->detailOrder;
    
        $pdf = PDF::loadView('order.downloadInvoice', compact('order', 'member', 'detailOrders'));
        return $pdf->download('invoice_order_' . $order->id . '.pdf');
    }

    public function exportExcel($id) {
        $order = Order::findOrFail($id);
        return Excel::download(new OrderExport($order), 'order_' . $order->id . '.xlsx');
    }
}
