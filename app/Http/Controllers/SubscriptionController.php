<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::latest()->get();
        return view('pages.subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        return view('pages.subscriptions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'currency' => 'required|string|size:3',
            'billing_cycle' => 'required|in:monthly,yearly',
            'next_billing_date' => 'nullable|date',
        ]);

        Subscription::create($validated);

        return redirect()->route('subscriptions.index')->with('success', 'Subscription created successfully');
    }

    public function edit(Subscription $subscription)
    {
        return view('pages.subscriptions.edit', compact('subscription'));
    }

    public function update(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'currency' => 'required|string|size:3',
            'billing_cycle' => 'required|in:monthly,yearly',
            'next_billing_date' => 'nullable|date',
        ]);

        $subscription->update($validated);

        return redirect()->route('subscriptions.index')->with('success', 'Subscription updated successfully');
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return redirect()->route('subscriptions.index')->with('success', 'Subscription deleted successfully');
    }
}
