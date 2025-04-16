<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('search'); 
    
        if ($query) {
            $orders = Order::with('member', 'user')
                ->where(function ($q) use ($query) {
                    $q->whereHas('member', function ($subQuery) use ($query) {
                        $subQuery->where('name', 'LIKE', "%{$query}%");
                    })
                    ->orWhere('total_price', 'LIKE', "%{$query}%")
                    ->orWhereHas('user', function ($subQuery) use ($query) {
                        $subQuery->where('name', 'LIKE', "%{$query}%");
                    });
                })
                ->paginate(5);
        } else {
            $orders = Order::with('member', 'user')->paginate(5);
        }
    
        return view('order.index', compact('orders'));
    }
    
    public function dashboard(Request $request)
    {
        $totalOrdersToday = DB::table('orders')
            ->whereDate('created_at', Carbon::today())
            ->count();
    
        $penjualanPerProduk = DetailOrder::select('products.name', DB::raw('SUM(quantity) as total'))
            ->join('products', 'products.id', '=', 'detail_orders.product_id')
            ->groupBy('products.name')
            ->get();
    
            // $ordersPerMonth = DB::table('orders')
            //     ->selectRaw("DATE_FORMAT(created_at, '%M') as month, COUNT(*) as total")
            //     ->whereBetween('created_at', [Carbon::now()->subMonths(11)->startOfMonth(), Carbon::now()->endOfMonth()])
            //     ->groupByRaw("MONTH(created_at)")
            //     ->orderByRaw("MIN(created_at)")
            //     ->get();
    
        return view('dashboard', compact('totalOrdersToday', 'penjualanPerProduk'));
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
        $ordersData = json_decode($request->orders, true); 
        $phone = $request->phone;
        $grandTotalRaw = (int) $request->grand_total;
        $totalPayment = (int) $request->total_payment;
        
    
        $member = Member::where('no_telp', $phone)->first();
        // $poinUsed = $member ? $member->poin : 0;

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

        $poinUsed = $grandTotalRaw - $grandTotal;

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

    public function export()
    {
        return Excel::download(new OrderExport, 'orders.xlsx'); 
    }   

    public function exportExcel($id) {
        $order = Order::findOrFail($id);
        return Excel::download(new OrderExport($order), 'order_' . $order->id . '.xlsx');
    }
}
