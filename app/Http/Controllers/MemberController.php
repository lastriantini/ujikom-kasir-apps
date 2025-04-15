<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\Product;

class MemberController extends Controller
{

    public function checkMember(Request $request)
    {
        $memberStatus = $request->member === 'member'; 
        $phone = $request->phoneNumber;  
        $orders = $request->cart_data;   
        $totalPayment = $request->total_bayar;  

        if ($memberStatus) {
            $member = Member::where('no_telp', $phone)->first();
            $isMember = !is_null($member); 

            $productIds = array_keys($orders);
            $subTotal = 0;

            foreach ($orders as $index => &$order) {
                $product = Product::find($order['id']);
                $expectedSubtotal = $product->price * $order['quantity']; 

                if ((int)$order['subtotal'] !== $expectedSubtotal) {
                    return response()->json(['error' => 'Data subtotal tidak valid'], 400);
                }

                $subTotal += $expectedSubtotal;

                $order['product'] = $product;
            }

            $grandTotal = $subTotal;

            $request->session()->put('order_data', $request->all());

            return view('order.member', [
                'isMember' => $isMember,
                'member' => $member,
                'grandTotal' => $grandTotal,
                'subTotal' => $subTotal,
                'orders' => $orders,
                'phone' => $phone,
                'totalPayment' => $totalPayment
            ]);
        }

        return redirect()->route('order.store');
    }
}
