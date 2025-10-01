<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    /**
     * Adiciona um produto ao carrinho global.
     */
    public function add(Product $product)
    {
        // Busca o carrinho global com id=1 ou cria se não existir.
        // Este é o coração da lógica de "carrinho único".
        $cart = Cart::firstOrCreate(['id' => 1]);

        // Verifica se o item já existe no carrinho
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Se existe, incrementa a quantidade
            $cartItem->increment('quantity');
        } else {
            // Se não, cria um novo item associado ao carrinho global
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        return back()->with('success', 'Produto adicionado ao carrinho!');
    }

    /**
     * Exibe os itens do carrinho global.
     */
    public function index()
    {
        $cart = Cart::find(1); // Encontra o carrinho global
        $cartItems = $cart ? $cart->items()->with('product')->get() : collect();

        // Passa os itens para uma view (ex: 'cart.index')
        return view('cart.index', compact('cartItems'));
    }
}