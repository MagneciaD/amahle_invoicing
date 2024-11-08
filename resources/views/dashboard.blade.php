<x-app-layout>

    <div class="col-md-10 offset-md-2" id="main-content" style="padding: 20px; transition: margin-left 0.3s ease;">
    <div class="row mb-4 mt-35">
            <div class="col-md-6 col-12 mb-3"> <!-- Ensure proper spacing and responsiveness -->
                <div class="card" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background: linear-gradient(135deg, #f0f4f8, #dfe8ec);">
                    <div class="card-body">
                        <h5 class="card-title" style="font-family: Arial, sans-serif; color: #333;">Payment Status</h5>
                        <div style="width: 100%; height: 300px; overflow: hidden;">
                            <canvas id="paymentStatusChart" style="width: 100%; height: 100%;"></canvas> <!-- Responsive pie chart -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12 mb-3"> <!-- Ensure proper spacing and responsiveness -->
                <div class="card" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background: linear-gradient(135deg, #f0f4f8, #dfe8ec);">
                    <div class="card-body">
                        <h5 class="card-title" style="font-family: Arial, sans-serif; color: #333;">Monthly Invoices</h5>
                        <div style="width: 100%; height: 300px; overflow: hidden;">
                            <canvas id="monthlyInvoicesChart" style="width: 100%; height: 100%;"></canvas> <!-- Responsive bar chart -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second row with invoice cards -->
        <div class="row mb-4 d-flex">
            <div class="col-md-3 col-sm-6 col-12 mb-3 d-flex">
                <div class="card text-center box box1 h-100" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background: linear-gradient(135deg, #f0f4f8, #dfe8ec); flex-grow: 1;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="uil uil-files-landscapes fa-2x" style="color: #007bff;"></i>
                        <h5 class="card-title" style="font-family: Arial, sans-serif; color: #333;">Total Invoices ({{ $totalInvoices }})</h5>
                        </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12 mb-3 d-flex">
                <div class="card text-center box box2 h-100" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background: linear-gradient(135deg, #f0f4f8, #dfe8ec); flex-grow: 1;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="uil uil-times fa-2x" style="color: #dc3545;"></i>
                        <h5 class="card-title" style="font-family: Arial, sans-serif; color: #333;">Overdue ({{ $overdueInvoices }})</h5>
                        </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12 mb-3 d-flex">
                <div class="card text-center box box3 h-100" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background: linear-gradient(135deg, #f0f4f8, #dfe8ec); flex-grow: 1;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="uil uil-money-bill fa-2x" style="color: #28a745;"></i>
                        <h5 class="card-title" style="font-family: Arial, sans-serif; color: #333;">Paid ({{ $paidInvoices }})</h5>
                        </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12 mb-3 d-flex">
                <div class="card text-center box box4 h-100" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background: linear-gradient(135deg, #f0f4f8, #dfe8ec); flex-grow: 1;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="uil uil-money-bill-slash fa-2x" style="color: #ffc107;"></i>
                        <h5 class="card-title" style="font-family: Arial, sans-serif; color: #333;">Unpaid ({{ $unpaidInvoices }})</h5>
                        </div>
                </div>
            </div>
        </div>

        <div class="row mt-4 d-flex align-items-center">
            <div class="col text-center">

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createInvoiceModal" style="margin-left: auto; 
                         background-color: #43BA7F; 
                         color: white; 
                         font-size: 0.875rem;
                          padding: 8px 16px; 
                         border: none; 
                         border-radius: 5px; 
                         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
                         transition: transform 0.2s, box-shadow 0.2s;">

                    Create Invoice
                </button>
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#clientModal">
                    Add Client
                </button>
                @include('partials.modals.create_invoice') <!-- Include the invoice modal -->
                @include('partials.modals.create_client') <!-- Include the client modal -->
            </div>
            <div class="col text-center">
                <!-- Friendly Reminder Button -->
                <button class="btn" style="border: none; background: none; font-weight: bold;" data-bs-toggle="modal" data-bs-target="#paymentModal">
                    <i class="fas fa-bell" style="color: red; margin-right: 10px;"></i>
                    Friendly Reminder
                    <small class="d-block" style="font-weight: normal; font-size: 12px; color: #555;">Payment Due Soon</small>
                </button>
                @include('partials.modals.payment')
            </div>
        </div>
        <!-- Invoice Table with scrollable overflow -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Recent Invoices</h5>
                <div class="table-responsive"> <!-- Make table scrollable on smaller screens -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Invoice Details</th>
                                <th>Payment</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->client->name }}</td>
                                <td>Rs {{ number_format($invoice->amount, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('dS M, Y') }}</td>
                                <td>
                                    <span class="badge {{ $invoice->status == 'paid' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td>
                                    <!-- Share Icon -->
                                    <a href="" title="Share" class="me-2">
                                        <i class="fas fa-share-alt"></i>
                                    </a>
                                    <!-- Download Icon -->
                                    <a href="{{ route('invoices.preview', $invoice->id) }}" title="Preview" class="me-2">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <!-- Delete Icon -->
                                    <form action="" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0" title="Delete" onclick="return confirm('Are you sure you want to delete this invoice?');">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- Chart.js for rendering charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
       // Pie chart for Payment Status
const ctxPaymentStatus = document.getElementById('paymentStatusChart').getContext('2d');
const paymentStatusChart = new Chart(ctxPaymentStatus, {
    type: 'pie',
    data: {
        labels: ['Paid', 'Unpaid', 'Overdue'],
        datasets: [{
            data: [{{ $paidInvoices }}, {{ $unpaidInvoices }}, {{ $overdueInvoices }}],
            backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Bar chart for Monthly Invoices
const ctxMonthlyInvoices = document.getElementById('monthlyInvoicesChart').getContext('2d');
const monthlyInvoicesChart = new Chart(ctxMonthlyInvoices, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Invoices',
            data: [10, 20, 15, 30, 25, 35], // Replace with actual data for each month
            backgroundColor: '#007bff',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

</script>
</x-app-layout>