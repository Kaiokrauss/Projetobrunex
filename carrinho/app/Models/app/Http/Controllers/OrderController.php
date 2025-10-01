<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;

class OrderController extends Controller
{
    /**
     * Processa a compra usando os itens do carrinho global.
     * Requer que o usuário esteja autenticado.
     */
    public function store(Request $request)
    {
        $user = Auth::user(); // O usuário precisa estar logado para comprar

        // Pega o carrinho global
        $cart = Cart::find(1);

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'O carrinho está vazio.');
        }

        $cartItems = $cart->items()->with('product')->get();

        DB::beginTransaction();
        try {
            $total = $cartItems->sum(function ($item) {
                return $item->product->preco * $item->quantity;
            });

            // 1. Criar o pedido (Order) associado ao usuário LOGADO
            $order = $user->orders()->create([
                'total' => $total,
                'status' => 'Pendente'
            ]);

            // 2. Adicionar os itens do carrinho ao pedido
            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'preco_unitario' => $item->product->preco
                ]);
            }

            // 3. Limpar o carrinho GLOBAL, esvaziando-o para todos.
            $cart->items()->delete();

            DB::commit();

            // Redireciona para o histórico de pedidos do usuário
            return redirect()->route('orders.index')->with('success', 'Compra realizada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocorreu um erro ao processar sua compra.');
        }
    }
    
    // O método index para ver o histórico de pedidos do usuário permanece o mesmo
    public function index()
    {
        $orders = Auth::user()->orders()->with('items.product')->latest()->get();
        return view('orders.index', compact('orders'));
    }
}