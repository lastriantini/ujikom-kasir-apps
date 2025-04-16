<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\Product;

class MemberController extends Controller
{

    public function checkMember(Request $request)
    {
        if ($request->member !== 'member') {
            return redirect()->route('order.store');
        }

        $phone = $request->phone;
        // dd($phone);
        $orders = json_decode($request->cart_data, true);
        $totalPayment = $request->total_bayar;
        $member_status = $request->member;  

        // dd($member_status);


        if (!is_array($orders)) {
            return back()->withErrors(['cart_data' => 'Data produk tidak valid.']);
        }

        $member = Member::where('no_telp', $phone)->first();
        $isMember = !is_null($member);

        $subTotal = 0;

        foreach ($orders as $index => $order) {
            $product = Product::find($order['id']);
            if (!$product) continue;
        
            $expectedSubtotal = $product->price * $order['quantity'];
        
            if ((int)$order['subtotal'] !== $expectedSubtotal) {
                return response()->json(['error' => 'Subtotal tidak sesuai'], 400);
            }
        
            $subTotal += $expectedSubtotal;
            $orders[$index]['product'] = $product;
        }

        $grandTotal = $subTotal;

        $request->session()->put('order_data', [
            'orders' => $orders,
            'member' => $member,
            'total' => $grandTotal
        ]);

        return view('order.checkMember', compact(
            'isMember', 'member', 'grandTotal', 'subTotal', 'orders', 'phone', 'totalPayment', 'member_status'
        ));
    }

}
