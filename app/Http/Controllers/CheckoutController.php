<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Exception;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email:rfc,dns|max:255',
            'customer_phone' => 'required|string|max:10',
            'address' => 'required|string|max:500',
        ]);

        session()->put('checkout.customer', $request->only('customer_name', 'customer_email', 'customer_phone', 'address'));

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $lineItems = [];
        foreach ($cart as $id => $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount' => $item['price'] * 100,
                ],
                'quantity' => $item['quantity'],
            ];
        }

        try {
            $checkoutSession = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
                'customer_email' => $request->customer_email,
            ]);

            return redirect($checkoutSession->url);
        } catch (Exception $e) {
            return back()->with('error', 'Stripe error: ' . $e->getMessage());
        }
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        if (!$sessionId) {
            return redirect()->route('products.index')->with('error', 'Invalid checkout session.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $session = Session::retrieve($sessionId);
            if ($session->payment_status !== 'paid') {
                return redirect()->route('checkout.cancel')->with('error', 'Payment not completed.');
            }

            $cart = session()->get('cart', []);
            if (empty($cart)) {
                return redirect()->route('products.index')->with('info', 'Your cart is already empty.');
            }

            $customer = session()->get('checkout.customer', []);
            if (empty($customer)) {
                return redirect()->route('cart.index')->with('error', 'Checkout information missing.');
            }

            $total = array_sum(array_map(function($item) {
                return $item['price'] * $item['quantity'];
            }, $cart));

            $order = Order::create([
                'customer_name' => $customer['customer_name'],
                'customer_email' => $customer['customer_email'],
                'customer_phone' => $customer['customer_phone'] ?? null,
                'address' => $customer['address'] ?? null,
                'total' => $total,
                'status' => 'paid',
                'stripe_session_id' => $sessionId,
            ]);

            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            session()->forget(['cart', 'checkout.customer']);

            return view('checkout.success', compact('order'));
        } catch (Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Failed to verify payment: ' . $e->getMessage());
        }
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }
}