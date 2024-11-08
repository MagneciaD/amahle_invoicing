<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Company;
use App\Models\Client; // Assuming you have a Client model
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;



class InvoiceController extends Controller
{
    public function index()
    {
        // Fetch invoices with company and client relations, limited to the latest 6
        $invoices = Invoice::with('company', 'client')->latest()->take(6)->get();

        // Calculate monthly invoice count
        $monthlyInvoices = Invoice::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Ensure months with no invoices are represented as 0
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = $monthlyInvoices[$i] ?? 0;
        }

        // Assuming you fetch all clients
        $clients = Client::all();

        // Fetch the company associated with the first invoice, or set it to null if no invoices exist
        $company = $invoices->first()->company ?? null;

        // Pass data to the view
        return view('dashboard', compact('invoices', 'company', 'clients', 'monthlyData'));
    }


    public function create()
    {
        $clients = Client::all(); // Fetch clients for the dropdown
        return view('invoices.create', compact('clients'));
    }
    public function store(Request $request)
    {   
        

        // Validate the main invoice fields
        $validatedData = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'client_id' => 'required|exists:clients,id',
            'invoice_type' => 'required|string',
            'bill_to' => 'required|string',
            'ship_to' => 'required|string',
            'date' => 'required|date',
            'due_date' => 'required|date',
            'amount' => 'nullable|numeric',
            'subtotal' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'total_amount' => 'required|numeric',
            'signature' => 'nullable|string|max:5000',
            'terms_and_conditions' => 'nullable|string|max:5000',
        ]);

        // Additional validation for the items array
        $validatedData = array_merge($validatedData, $request->validate([
            'description.*' => 'nullable|string',
            'unit_price.*' => 'nullable|numeric',
            'qty.*' => 'nullable|integer',
        ]));

        // Prepare item details as JSON arrays
        $itemDetails = [
            'description' => json_encode($request->input('description')),
            'unit_price' => json_encode($request->input('unit_price')),
            'qty' => json_encode($request->input('qty'))
        ];

        // Generate a unique invoice number
        $validatedData['invoice_number'] = $this->generateUniqueInvoiceNumber();

        // Merge item details into validated data
        $validatedData = array_merge($validatedData, $itemDetails);

        // Save the invoice with the items
        $invoice = Invoice::create($validatedData);

        // Redirect to chooseTemplate with success message
        return redirect()->route('invoices.chooseTemplate', ['invoiceId' => $invoice->id])
            ->with('success', 'Invoice created successfully!');
    }
    private function generateUniqueInvoiceNumber()
{
    do {
        // Generate a random invoice number (e.g., inv123)
        $invoiceNumber = 'inv' . rand(100, 999); // Generates a random number between 100 and 999
    } while (Invoice::where('invoice_number', $invoiceNumber)->exists());

    return $invoiceNumber;
}



    public function show(Invoice $invoice)

    {
        $company = Company::where('user_id', Auth::id())->first();

        // If no company is found, redirect with an error message
        if (!$company) {
            return redirect()->route('some.route')->with('error', 'No company found.');
        }

        // Fetch clients related to the company
        $clients = Client::where('company_id', $company->id)->get();

        // Fetch the latest 6 invoices based on the company ID
        $invoices = Invoice::with('client')
            ->where('company_id', $company->id)
            ->latest()
            ->take(6)
            ->get();

        // Fetch counts of invoices with different statuses
        $totalInvoices = Invoice::where('company_id', $company->id)->count();
        $paidInvoices = Invoice::where('company_id', $company->id)
            ->where('status', 'paid')
            ->count();
        $unpaidInvoices = Invoice::where('company_id', $company->id)
            ->where('status', 'unpaid')
            ->count();
        $overdueInvoices = Invoice::where('company_id', $company->id)
            ->where('status', 'overdue')
            ->count();

        // Pass the data to the view
        return view('invoices', [
            'company' => $company,
            'clients' => $clients,
            'invoices' => $invoices,
            'totalInvoices' => $totalInvoices,
            'paidInvoices' => $paidInvoices,
            'unpaidInvoices' => $unpaidInvoices,
            'overdueInvoices' => $overdueInvoices,
        ]);
    

        return view('invoices', compact('invoice', 'invoices', 'totalInvoices', 'paidInvoices', 'unpaidInvoices', 'overdueInvoices')); // Include overdueInvoices
    }


    public function updateStatus(Request $request)
    {
        $invoice = Invoice::find($request->id);

        if ($invoice) {
            // Toggle status between unpaid and paid
            $invoice->status = ($invoice->status == 'unpaid') ? 'paid' : 'unpaid';
            $invoice->save();

            return response()->json(['status' => $invoice->status]);
        }

        return response()->json(['error' => 'Invoice not found'], 404);
    }




    public function edit(Invoice $invoice)
    {
        $clients = Client::all();
        return view('invoices.edit', compact('invoice', 'clients'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:paid,pending,overdue',
            // Add other fields as necessary for updating
        ]);

        $invoice->update($validatedData);
        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function share($invoiceId)
    {
        // Logic to share the invoice
    }

    // Method for choosing a template for the invoice
    public function chooseTemplate($invoiceId)
    {
        // Find the invoice by its ID
        $invoice = Invoice::findOrFail($invoiceId);

        // Return a view to select a template for the invoice
        return view('invoices.choose_template', compact('invoice'));
    }

    public function generatePdf(Request $request, $invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);
        $company = Company::find($invoice->company_id); // Assuming you have a Company model

        $template = $request->input('template');

        // Load the selected template view and pass the company details
        $pdf = PDF::loadView("invoices.templates.$template", compact('invoice', 'company'));

        // Display the PDF in the browser
        return $pdf->stream("invoice_$invoiceId.pdf"); // Use `stream()` instead of `download()`
    }
    public function preview($invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);
        $company = Company::find($invoice->company_id);
        $templates = ['template1', 'template2', 'template3']; // List of available templates

        return view('invoices.preview', compact('invoice', 'company', 'templates'));
    }
    public function updateInvoiceType(Request $request, $id)
    {
        $request->validate([
            'invoice_type' => 'required|string',
        ]);

        $invoice = Invoice::find($id);

        if ($invoice) {
            $invoice->invoice_type = $request->invoice_type;
            $invoice->save();

            // Redirect to the choose template page after updating the invoice type
            return redirect()->route('invoices.chooseTemplate', ['invoiceId' => $invoice->id])
                ->with('success', 'Invoice type updated successfully! Please choose a template.');
        }

        return back()->withErrors(['message' => 'Invoice not found.']);
    }


    public function destroy(Invoice $invoice)
{
    // Delete the invoice
    $invoice->delete();
     // Fetch the company for the authenticated user

    $clients = Client::where('company_id', $company->id)->get();


    // After deletion, fetch updated counts and invoices
    $totalInvoices = Invoice::count();
    $paidInvoices = Invoice::where('status', 'paid')->count();
    $unpaidInvoices = Invoice::where('status', 'unpaid')->count();
    $overdueInvoices = Invoice::where('status', 'overdue')->count();
    $invoices = Invoice::with('company', 'client')->get();

    return view('invoices', compact('invoices', 'totalInvoices', 'paidInvoices', 'unpaidInvoices', 'overdueInvoices'))
        ->with('success', 'Invoice deleted successfully.');
}

}
