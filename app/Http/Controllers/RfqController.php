<?php

namespace App\Http\Controllers;

use App\Models\RfqRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RfqController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'company_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'target_quantity' => 'required|integer|min:1',
            'target_unit_price' => 'required|numeric|min:0.01',
            'delivery_deadline' => 'nullable|date',
            'packaging_specs' => 'nullable|string|max:1000',
        ]);

        $rfq = RfqRequest::create([
            ...$validated,
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your custom RFQ bulk price negotiation has been submitted to the supplier!');
    }
}
