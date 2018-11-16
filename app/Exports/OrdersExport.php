<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Order;

class OrdersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $orders = Order::latest()->get();
      
        $data = [];

        foreach ($orders as $order) {
            $data[] =[
                        'Id' => $order->id,
                        'Email' => $order->user->email,
                        'Totel Items' => count($order->items),
                        'Amount' => $order->amount ,
                        'Payment Getway' => $order->payment_getway,
                        'Transaction Id' =>  $order->transaction_id,
                        'Payment Status' => $order->status,
                        'Order On Date' => date('d-m-Y',strtotime($order->created_at)),
                    ];
        }
        return collect($data);
    }
}
