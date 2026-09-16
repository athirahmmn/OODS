<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OODS | Order History</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('/') }}" class="nav-link">Home</a>
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
        <a href="{{ url('/') }}" class="brand-link">
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
                        <a href="{{ url('/admin/dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/admin/manageStock') }}" class="nav-link">
                            <i class="nav-icon fas fa-cubes"></i>
                            <p>Manage Stock</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/admin/updateOrderStatus') }}" class="nav-link">
                            <i class="nav-icon fas fa-check"></i>
                            <p>Order Status</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/admin/arrangeDelivery') }}" class="nav-link">
                            <i class="nav-icon fas fa-truck"></i>
                            <p>Arrange Delivery</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('#') }}" class="nav-link active">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Order History</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order History</h1>
          </div>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Order History</h3>
              </div>
              <div class="card-body">
                <table id="orderHistoryTable" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Delivery ID</th>
                      <th>Order ID</th>
                      <th>Outlet</th>
                      <th>Delivery Date</th>
                      <th>Received Date</th>
                      <th>Order Details</th>
                      <th>Delivery Details</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($deliveries as $index => $delivery)
                      <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $delivery->deliveryID }}</td>
                        <td>
                          @foreach($delivery->orders as $order)
                            <div>{{ $order->orderID }}</div>
                          @endforeach
                        </td>
                        <td>{{ $order->user->userName ?? 'N/A' }}</td>
                        <td>{{ $delivery->shipped_date ?? 'N/A' }}</td>
                        <td>{{ $delivery->received_date ?? 'N/A' }}</td>
                        <td>
                          <button class="btn btn-primary btn-sm view-order-details" data-deliveryid="{{ $delivery->deliveryID }}">
                            <i class="fas fa-folder"></i> View
                          </button>
                        </td>
                        <td>
                          <button class="btn btn-secondary btn-sm view-delivery-details" data-deliveryid="{{ $delivery->deliveryID }}">
                            <i class="fas fa-truck"></i> View
                          </button>
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

    <!-- Modal for displaying order details -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="order-details-content">
              <!-- Order details content will be loaded here -->
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal for displaying delivery details -->
    <div class="modal fade" id="deliveryDetailsModal" tabindex="-1" role="dialog" aria-labelledby="deliveryDetailsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deliveryDetailsModalLabel">Delivery Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="delivery-details-content">
              <!-- Delivery details content will be loaded here -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
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
  
$(document).ready(function() {
  $('.view-order-details').on('click', function() {
    var deliveryId = $(this).data('deliveryid');
    $.ajax({
      url: '/supervisor/orderDetails/' + deliveryId,
      method: 'GET',
      success: function(response) {
        var orders = response.orders;
        var content = `
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Order Quantity</th>
                <th>Order Date</th>
                <th>Total Price</th>
                <th>Stock Name</th>
                <th>Quantity</th>
              </tr>
            </thead>
            <tbody>`;

        orders.forEach(function(order) {
          content += `
            <tr>
              <td rowspan="${order.orderDetails.length + 1}"><strong>${order.orderID}</td>
              <td rowspan="${order.orderDetails.length + 1}">${order.orderQuantity}</td>
              <td rowspan="${order.orderDetails.length + 1}">${order.orderDate}</td>
              <td rowspan="${order.orderDetails.length + 1}">${order.total}</td>
            </tr>`;

          order.orderDetails.forEach(function(detail) {
            content += `
              <tr>
                <td>${detail.stockName}</td>
                <td>${detail.quantity}</td>
              </tr>`;
          });
        });

        content += `
            </tbody>
          </table>`;

        $('#order-details-content').html(content);
        $('#orderDetailsModal').modal('show');
      }
    });
  });

  $('.view-delivery-details').on('click', function() {
    var deliveryId = $(this).data('deliveryid');
    $.ajax({
      url: '/supervisor/deliveryDetails/' + deliveryId,
      method: 'GET',
      success: function(response) {
        var delivery = response.delivery;

        var content = `
          <h5><strong>Delivery ID: <span id="delivery-id">${delivery.deliveryID}</span></strong></h5>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Status</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Preparing for Delivery</td>
                <td>${delivery.preparing_date || 'N/A'}</td>
              </tr>
              <tr>
                <td>Shipped</td>
                <td>${delivery.shipped_date || 'N/A'}</td>
              </tr>
              <tr>
                <td>Out for Delivery</td>
                <td>${delivery.out_for_delivery_date || 'N/A'}</td>
              </tr>
              <tr>
                <td>Delivered</td>
                <td>${delivery.delivered_date || 'N/A'}</td>
              </tr>
              <tr>
                <td>Order Received</td>
                <td>${delivery.received_date || 'N/A'}</td>
              </tr>
            </tbody>
          </table>`;

        $('#delivery-details-content').html(content);
        $('#deliveryDetailsModal').modal('show');
      }
    });
  });
  // Initialize DataTable for the Order History table
  $('#orderHistoryTable').DataTable({
    order: [[1, 'desc']], // Default sort on the "No." column
    columnDefs: [
      { orderable: true, targets: [1, 2] }, // Enable sorting for "No." and "Order ID"
      { orderable: false, targets: '_all' }, // Disable sorting for other columns
    ],
    paging: true, // Enable pagination
    pageLength: 10, // Default number of entries per page
    lengthMenu: [5, 10, 25, 50], // Options for "Show Entries"
    searching: true, // Optional: Disable search if not needed
  });
});
</script>
</body>
</html>