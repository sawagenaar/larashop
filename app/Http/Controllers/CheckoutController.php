<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function profile() {
        $user = Auth::user();
        // Op token gebaseerde unieke gebruikers-ID
        $userID = CartFacade::session('_token');
        // Totaal aantal artikelen in de winkelwagen
        $cartTotalQuantity = $userID->getTotalQuantity();
        // Totale kosten van producten
        $subTotal = $userID->getSubTotal();
        // Producten in de winkelwagen
        $items = $userID->getContent();
        return view('cart.profile', compact('items', 'cartTotalQuantity', 'subTotal', 'user'));
    }

    public function delivery(Request $request) {
        $user = Auth::user();
        // Op token gebaseerde unieke gebruikers-ID
        $userID = CartFacade::session('_token');
        // Totaal aantal artikelen in de winkelwagen
        $cartTotalQuantity = $userID->getTotalQuantity();
        // Totale kosten van producten
        $subTotal = $userID->getSubTotal();
        // Producten in de winkelwagen
        $items = $userID->getContent();
        // Nieuwe bestelvelden aan de tabel toevoegen
        $order = new Order();
        $order->user_id = $user->id;
        $order->name = $request->name;
        $order->surname = $request->surname;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->cart_data = $order->setCartDataAttribute($items);
        $order->totalQuantity = $cartTotalQuantity;
        $order->subTotal = $subTotal;
        $order->save();
        return view('cart.delivery', compact('items', 'cartTotalQuantity', 'subTotal', 'order'));
    }

    public function make(Request $request, $id) {
        // Op token gebaseerde unieke gebruikers-ID
        $userID = CartFacade::session('_token');
        // Producten in de winkelwagen
        $items = $userID->getContent();
        $user = Auth::user();
        // Totaal aantal artikelen in de winkelwagen
        $cartTotalQuantity = $userID->getTotalQuantity();
        // Totale kosten van producten
        $subTotal = $userID->getSubTotal();
        // Nieuwe velden voor bestellingen aan de tabel toevoegen
        $order = Order::where('id', $id)->firstOrFail();
        $order->day = $request->day;
        $order->partday = $request->partday;
        // Winkelwagengegevens verwijderen als de bestelling is opgeslagen
        if ($order->save()) {
            $userID->clear();
            return redirect()->route('cart.index')->with('success', 'Orded created successfully');
        }
        return view('cart.index', compact('items', 'subTotal', 'cartTotalQuantity'));
    }

    public function orders() {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        // deserialiseren van gegevens cart_data
        $orders->transform(function($order) {
            $order->cart_data = unserialize($order->cart_data);
            return $order;
        });
        return view('cart.orders', compact('orders'));
    }

    public function order($id) {
        $user = Auth::user();
        // Geselecteerde order
        $order = Order::where('id', $id)->firstOrFail();
        // deserialiseren van gegevens cart_data
        $order->cart_data = unserialize($order->cart_data);
        return view('cart.order', compact('order'));
    }
}