<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\SiteLog;
use App\Coupon;
use App\Order;
use App\Item;
use PDF;
use Auth;
//use Excel;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('id','desc')->paginate(15);
        Order::where('read_status',false)->update(['read_status'=>true]);
        return view('admin.pages.orders.index',compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);

        return view('admin.pages.orders.view',compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $order =  Order::findOrFail($id);

        if($order){

            $validator =  Validator::make($request->all(), [
                'status' => 'required|string|max:255',
                'note' => 'string|max:1500',
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
              $order->status = $request->status;   
              $order->note = $request->note;
              $order->save();

              SiteLog::create([
                'user_id' => Auth::id(),
                'action_type' => 'update',
                'log' => 'Order number #'.$id.' update by '.Auth::user()->name,
                'ip' => $request->ip(),
                'client' =>$request->header('user-agent'),
              ]);

              $topiscussesscreated= trans('messages.order_successfully_updated');
              $request->session()->flash('status', $topiscussesscreated);
              return redirect()->back();
            }
        }else{
            return redirect('admin/orders');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        SiteLog::create([
                'user_id' => Auth::id(),
                'action_type' => 'delete',
                'log' => 'Order number #'.$id.' deleted by '.Auth::user()->name,
                'ip' => $request->ip(),
                'client' =>$request->header('user-agent'),
              ]);

        Order::where('id',$id)->delete();
        Item::where('order_id',$id)->delete();
        return redirect()->back();
    }



    public function export_order($file_type)
    {

        $orders = Order::latest()->get();
        $data = [];

        if(in_array($file_type, ['csv','xls','xlsx'])){

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

            if(count($data)){
                $file_name = 'Orders_'.date('d-m-Y_h:i:s').'.'.$file_type;
               return  Excel::download(new OrdersExport,$file_name);
            }
        }
    }


/**
     * Download the specified order as pdf.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */

    public function invoice_download($order_id)
    {
        # code...
        $order = Order::findOrFail($order_id);

        $pdf = PDF::loadView('admin.pdf.order_detail', compact('order') );
        return $pdf->download('order.pdf');

    }
    
}
