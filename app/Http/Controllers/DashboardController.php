<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index($companyId = null)
    {
        if (Auth::user()->hasRole('admin')) {
            return view('admin/dashboard');
        }
    
        // This will work for regular users
        $user = Auth::user()->load('company');
        $company = $companyId ? Company::find($companyId) : $user->company;
    
        if (!$company) {
            return view('admin/dashboard');        }
    
        $clients = Client::where('company_id', $company->id)->get();
        $invoices = Invoice::with('client')
            ->where('company_id', $company->id)
            ->latest()
            ->take(6)
            ->get();
    
        $totalInvoices = Invoice::where('company_id', $company->id)->count();
        $paidInvoices = Invoice::where('company_id', $company->id)->where('status', 'paid')->count();
        $unpaidInvoices = Invoice::where('company_id', $company->id)->where('status', 'unpaid')->count();
        $overdueInvoices = Invoice::where('company_id', $company->id)->where('status', 'overdue')->count();
    
        return view('dashboard', compact('company', 'clients', 'invoices', 'totalInvoices', 'paidInvoices', 'unpaidInvoices', 'overdueInvoices'));
    }
}