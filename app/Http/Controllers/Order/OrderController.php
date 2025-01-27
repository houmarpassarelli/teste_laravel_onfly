<?php

namespace App\Http\Controllers\Order;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        return Inertia::render('Order/Orders');
    }
    public function create()
    {
        return Inertia::render('Order/Register');
    }

    public function show($id)
    {
        $order = Order::find($id);
        $order->departureDate = date('d/m/Y', strtotime($order->departureDate));
        $order->returnDate = $order->returnDate ? date('d/m/Y', strtotime($order->returnDate)) : "Não definido";  

        return Inertia::render('Order/Resume', ['order' => $order]);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'departureDate' => 'required|date',
            'returnDate' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $order = new Order();
        $order->fullName = $request->input('fullName');
        $order->state = $request->input('state');
        $order->city = $request->input('city');
        $order->departureDate = $request->input('departureDate');
        $order->returnDate = $request->input('returnDate');
        $order->save();

        return response()->json(['message' => 'Pedido enviado com sucesso!']);
    }

    public function get($id = null)
    {
        if ($id) {
            $order = Order::find($id);
    
            if (!$order) {
                return response()->json(['error' => 'Pedido não encontrado'], 404);
            }
    
            return response()->json($order);
        }
    
        // Caso $id não seja fornecido, retorna todos os registros
        $orders = Order::all();
        return response()->json($orders);
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['error' => 'Pedido não encontrado'], 404);
        }

        $order->status = $request->status;
        $order->save();

        return response()->json(['success' => 'Status atualizado com sucesso']);
    }
}