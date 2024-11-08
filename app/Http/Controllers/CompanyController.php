<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index()
{
    // Fetch all companies
    $companies = Company::all();
    // Pass companies to the view
    return view('admin.dashboard', compact('companies'));
}

    public function create()
    {
        return view('register_company');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'company_details' => 'required|string',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banking_details' => 'required|string',
            'number' => 'required|string',
            'email' => 'required|email',
            'payment_frequency' => 'nullable|string',
            'date' => 'nullable|date',
            'amount' => 'nullable|numeric',
            'last_payment_date' => 'nullable|date',
            'next_payment_due' => 'nullable|date',
        ]);

        // Handle the uploaded logo
        $logoPath = null; 

        if ($request->hasFile('company_logo')) {
            // Store the logo in the public/img/logos directory
            $logoPath = $request->file('company_logo')->store('logos', 'public');
        }
         // Handle the uploaded signature
         $signaturePath = null; 

         if ($request->hasFile('signature')) {
             // Store the signature in the public/img/logos directory
             $signaturePath = $request->file('signature')->store('logos', 'public');
         }

        $amount = $request->amount ?? 0;

        // Create the company
        $company = Company::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'address' => $request->address,
            'company_name' => $request->company_name,
            'company_logo' => $logoPath ? 'storage/' . $logoPath : null, 
            'company_details' => $request->company_details,
            'signature' =>  $signaturePath ? 'storage/' . $signaturePath : null, 
            'banking_details' => $request->banking_details,
            'number' => $request->number,
            'email' => $request->email,
            'payment_frequency' => $request->payment_frequency,
            'amount' => $amount,
            'last_payment_date' => $request->last_payment_date,
            'next_payment_due' => $request->next_payment_due,
        ]);

        // Redirect or return a response
        return redirect()->route('dashboard', ['companyId' => $company->id])
            ->with('success', 'Company registered successfully.');
    }

    public function show($companyId)
    {
        $company = Company::findOrFail($companyId);
        return response()->json($company);
    }

    public function getCompanyDetails(Request $request)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Fetch the company associated with the authenticated user
        $company = Company::where('user_id', Auth::id())->first();

        // Return the company details as a JSON response
        return response()->json($company);
    }
    public function edit()
    {
        $company = Auth::user()->company; // Assuming a user has a company
        return view('profile.edit', compact('company'));
    }
     

    // Update the company profile
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'company_details' => 'nullable|string',
            'number' => 'required|string|max:20',
            'banking_details' => 'nullable|string',
            'company_logo' => 'nullable|url',
            'signature' => 'nullable|string',
        ]);

        $company = Auth::user()->company;
        $company->update([
            'name' => $request->name,
            'address' => $request->address,
            'company_details' => $request->company_details,
            'number' => $request->number,
            'banking_details' => $request->banking_details,
            'company_logo' => $request->company_logo,
            'signature' => $request->signature,
        ]);

        return redirect()->route('profile.edit')->with('status', 'Company profile updated!');
    }
  
}
