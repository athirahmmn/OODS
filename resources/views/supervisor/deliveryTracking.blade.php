<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OODS | Delivery Tracking</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <style>
        .hiddenRow {
            padding: 0 !important;
        }
        .gap-row {
            padding: 20px;
            background-color: #f9f9f9;
        }
        .status-label.preparing { color: yellow; }
        .status-label.shipped { color: orange; }
        .status-label.out-for-delivery { color: green; }
        .status-label.delivered { color: blue; }
        .status-label.completed { color: purple; }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('/supervisor/dashboard') }}" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- User Account -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">{{ Auth::user()->userName }}</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </li>
    </ul>
  </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary">
        <!-- Brand Logo -->
        <a href="{{ url('#') }}" class="brand-link">
            <img src="{{ asset('images/smootea_logo.jpg') }}" alt="smootea logo" class="brand-image elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">SMOOTEA</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('images/profilepicture1.jpg') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->userName }}</a>
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ url('/supervisor/dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/supervisor/requestPage') }}" class="nav-link">
                            <i class="nav-icon fas fa-cubes"></i>
                            <p>View Stock</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/supervisor/cart') }}" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Cart<span id="cart-badge" class="badge badge-info right">0</span></p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('supervisor/orderStatus') }}" class="nav-link">
                            <i class="nav-icon fas fa-check"></i>
                            <p>Order Status</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('#') }}" class="nav-link active">
                            <i class="nav-icon fas fa-truck"></i>
                            <p>Delivery Tracking</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/supervisor/orderHistory') }}" class="nav-link">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Order History</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Delivery Tracking</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Your Orders</h3>
                            </div>
                            <div class="card-body">
                                <table id="deliveryTrackingTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Delivery ID</th>
                                            <th>Order ID(s)</th>
                                            <th>Delivery Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($deliveries as $index => $delivery)
                                            <tr data-toggle="collapse" data-target="#timeline{{ $index }}" class="accordion-toggle">
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $delivery->deliveryID }}</td>
                                                <td>
                                                    @foreach($delivery->orders as $order)
                                                        {{ $order->orderID }}@if(!$loop->last), @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <span class="status-label {{ str_replace(' ', '-', strtolower($delivery->deliveryStatus)) }}">
                                                        {{ $delivery->deliveryStatus == 'Delivered' && $delivery->received_date ? 'Completed' : $delivery->deliveryStatus }}
                                                    </span>
                                                </td>
                                                <td><button class="btn btn-primary" type="button">View Timeline</button></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="hiddenRow">
                                                    <div class="collapse gap-row" id="timeline{{ $index }}">
                                                        <!-- Timeline content -->
                                                        <div class="timeline">
                                                            <div class="time-label">
                                                                <span class="bg-blue">Order Date: 
                                                                    @foreach($delivery->orders as $order)
                                                                        {{ $order->orderDate }}@if(!$loop->last), @endif
                                                                    @endforeach
                                                                </span>
                                                            </div>
                                                            @if($delivery->preparing_date)
                                                                <div class="time-label">
                                                                    <span class="bg-yellow">{{ $delivery->preparing_date }}</span>
                                                                </div>
                                                                <div>
                                                                    <i class="fas fa-shipping-fast bg-yellow"></i>
                                                                    <div class="timeline-item">
                                                                        <h3 class="timeline-header"><a href="#">Your order is being prepared for delivery</a></h3>
                                                                        <div class="timeline-body">
                                                                            Your order is currently being prepared for delivery.
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($delivery->shipped_date)
                                                                <div class="time-label">
                                                                    <span class="bg-orange">{{ $delivery->shipped_date }}</span>
                                                                </div>
                                                                <div>
                                                                    <i class="fas fa-truck bg-orange"></i>
                                                                    <div class="timeline-item">
                                                                        <h3 class="timeline-header"><a href="#">Your order has been shipped</a></h3>
                                                                        <div class="timeline-body">
                                                                            Your order has been shipped and is on its way. Contact number: {{ $delivery->runnerPhoneNumber }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($delivery->out_for_delivery_date)
                                                                <div class="time-label">
                                                                    <span class="bg-green">{{ $delivery->out_for_delivery_date }}</span>
                                                                </div>
                                                                <div>
                                                                    <i class="fas fa-check bg-green"></i>
                                                                    <div class="timeline-item">
                                                                        <h3 class="timeline-header"><a href="#">Your order is out for delivery</a></h3>
                                                                        <div class="timeline-body">
                                                                            The delivery agent is currently on the way to your address.
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($delivery->delivered_date)
                                                                <div class="time-label">
                                                                    <span class="bg-blue">{{ $delivery->delivered_date }}</span>
                                                                </div>
                                                                <div>
                                                                    <i class="fas fa-check bg-blue"></i>
                                                                    <div class="timeline-item">
                                                                        <h3 class="timeline-header"><a href="#">Your order has been delivered</a></h3>
                                                                        <div class="timeline-body">
                                                                            Have you received the order?
                                                                        </div>
                                                                        @if(!$delivery->received_date)
                                                                            <div class="timeline-footer">
                                                                                <form action="{{ route('supervisor.markAsReceived', $delivery->deliveryID) }}" method="POST">
                                                                                    @csrf
                                                                                    <button type="submit" class="btn btn-success btn-sm">Order received</button>
                                                                                </form>
                                                                            </div>
                                                                        @else
                                                                            <div class="timeline-footer">
                                                                                <button class="btn btn-success btn-sm" disabled>Order received</button>
                                                                            </div>
                                                                        @endif

                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($delivery->received_date)
                                                                <div class="time-label">
                                                                    <span class="bg-purple">Completed date: {{ $delivery->received_date }}</span>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <i class="fas fa-clock bg-gray"></i>
                                                            </div>
                                                        </div>
                                                        <!-- End of timeline content -->
                                                    </div>
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
        </section>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success Delivery</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="successModalBody">
                <!-- Content will be filled by JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- jQuery UI -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>
<!-- DataTables JS -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script>
      function updateCartBadge() {
    var cart = JSON.parse(localStorage.getItem('cart')) || [];
    var totalItems = cart.length; // Change this line to count unique items
    document.getElementById('cart-badge').innerText = totalItems;
  }

  document.addEventListener('DOMContentLoaded', updateCartBadge);
$(document).ready(function() {

    function updateCartBadge() {
       var cart = JSON.parse(localStorage.getItem('cart')) || [];
       var totalItems = cart.length; // Show the count of unique items in the badge
       document.getElementById('cart-badge').innerText = totalItems;
   }

   document.addEventListener('DOMContentLoaded', updateCartBadge);

   window.addEventListener('storage', function (event) {
       if (event.key === 'cart') {
           updateCartBadge(); // Update the badge whenever the cart changes in localStorage
       }
   });
    // Initialize the DataTable for Delivery Tracking
    $('#deliveryTrackingTable').DataTable({
        responsive: true,
        autoWidth: false,
        paging: true, // Enable pagination
        pageLength: 10, // Default number of entries per page
        lengthMenu: [5, 10, 25, 50], // Options for "Show Entries"
        searching: true, // Enable search
        order: [[1, 'asc']] // Default sort on the "Delivery ID" column
    });
    $('.accordion-toggle').on('click', function() {
        var target = $(this).data('target');
        $(target).collapse('toggle');
    });

    @if(session('orderID') && session('received_date'))
        $('#successModalBody').html('Your order for {{ session('orderID') }} has been successfully delivered on {{ session('received_date') }}');
        $('#successModal').modal('show');
    @endif
});

</script>
</body>
</html>
