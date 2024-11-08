<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Invoicing System</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        /* Sidebar styling */
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            height: 100vh;
            padding-top: 80px;
            position: fixed;
            top: 0;
            left: -250px; /* Initially hidden */
            transition: left 0.3s;
            z-index: 1000;
        }
        .sidebar.active {
            left: 0; /* Show sidebar */
        }
        .sidebar h3 {
            color: #ffc107;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .sidebar a {
            color: #adb5bd;
            padding: 10px 15px;
            display: block;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .sidebar a:hover {
            background-color: #495057;
            color: white;
        }
        .main-content {
            margin-left: 0; /* Adjusted when sidebar is toggled */
            padding: 20px;
            transition: margin-left 0.3s;
        }
        .main-content.shifted {
            margin-left: 250px; /* Shift content when sidebar is visible */
        }
        .card-title, .table th {
            color: #343a40;
        }
        .status-paid {
            color: green;
            font-weight: bold;
        }
        .status-unpaid {
            color: red;
            font-weight: bold;
        }
        .table td, .table th {
            font-size: 0.9em;
            padding: 0.5em;
        }
    </style>
</head>
<body>

<!-- Sidebar Navigation -->
<div class="sidebar" id="sidebar">
    <h3>amahle invoicing</h3>
    <a href="#dashboard">Dashboard</a>
    <a href="#recent-payments">Recent Payments</a>
    <a href="#registered-businesses">Registered Businesses</a>
    <a href="#settings">Settings</a>
    <div class="mt-3 space-y-1">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-responsive-nav-link :href="('logout')"
                    onclick="event.preventDefault();
                                        this.closest('form').submit();">
                
                    {{ __('Sign Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
</div>

<!-- Toggle Button for Sidebar -->
<button class="btn btn-dark" id="sidebarToggle" style="position: absolute; top: 20px; left: 20px; z-index: 1001;">☰</button>

<!-- Main Content -->
<div class="main-content" id="mainContent">
    <h2 id="dashboard">Admin Dashboard</h2>
    
    <div class="d-flex justify-content-center align-items-center mb-4">
                <div class="d-flex align-items-center" style="position: relative; width: 300px;">
                    <!-- Search Icon -->
                    <i class="fas fa-search"
                        style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); 
                  color: #888;"></i>
                    <!-- Search Bar -->
                    <input type="text" class="form-control me-3" placeholder="Search"
                        style="border-radius: 25px; padding: 10px 20px 10px 40px; width: 100%; 
                      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border: 1px solid #ccc; 
                      transition: box-shadow 0.3s ease; outline: none;"
                        onfocus="this.style.boxShadow='0 4px 12px rgba(0, 123, 255, 0.4)';"
                        onblur="this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)';">
                </div>
                <div class="d-flex align-items-center">
                </div>
            </div>
    <!-- Recent Payments -->
    <div class="card my-2" style="width: 18rem; padding: 0.5rem;">
    <div class="card-header" style="padding: 0.5rem;">
        <h6 class="card-title" style="font-size: 1rem; margin: 0;">Recent Payments</h6>
    </div>
    <div class="card-body" style="padding: 0.5rem;">
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center" style="padding: 0.5rem; font-size: 0.9rem;">
                Business One - John Doe
                <span class="status-paid">Paid</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" style="padding: 0.5rem; font-size: 0.9rem;">
                Business Two - Jane Smith
                <span class="status-unpaid">Unpaid</span>
            </li>
        </ul>
    </div>
</div>


    <!-- Registered Businesses Table -->
    <div class="card my-4">
        <div class="card-header">
            <h5 class="card-title">Registered Businesses</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Business Name</th>
                        <th>Owner</th>
                        <th>Email</th>
                        <th>Payment Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Business One</td>
                        <td>John Doe</td>
                        <td>john@example.com</td>
                        <td><span class="status-paid">Paid</span></td>
                        <td><button class="btn btn-danger btn-sm">Delete</button></td>
                    </tr>
                    <tr>
                        <td>Business Two</td>
                        <td>Jane Smith</td>
                        <td>jane@example.com</td>
                        <td><span class="status-unpaid">Unpaid</span></td>
                        <td><button class="btn btn-danger btn-sm">Delete</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // JavaScript for sidebar toggle
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        var sidebar = document.getElementById('sidebar');
        var mainContent = document.getElementById('mainContent');
        
        // Toggle sidebar visibility
        sidebar.classList.toggle('active');
        mainContent.classList.toggle('shifted');
    });
</script>
</body>
</html>
