<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OODS | Order Status</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
  <!-- Bootstrap Toasts -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <style>
    .toast-success {
      background-color: #28a745;
      color: white;
    }
    .toast-error {
      background-color: #dc3545;
      color: white;
    }
  </style>
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
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
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
            <a href="{{ url('#') }}" class="nav-link active">
              <i class="nav-icon fas fa-check"></i>
              <p>Order Status</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/supervisor/deliveryTracking') }}" class="nav-link">
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
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <div class="content-wrapper">
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>View Order Status</h1>
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
                <h3 class="card-title">Order Status</h3>
              </div>
              <div class="card-body">
                <table id="orderStatusTable" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Order ID</th>
                      <th>Total Price</th>
                      <th>Order Date</th>
                      <th>Order Status</th>
                      <th>Rejection Reason</th>
                      <th>Order Details</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($orders as $index => $order)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $order->orderID }}</td>
                      <td>RM {{ number_format($order->total, 2) }}</td>
                      <td>{{ $order->orderDate }}</td>
                      <td class="project-state">
                        <span class="badge 
                          @if($order->orderStatus == 'Pending') badge-warning 
                          @elseif($order->orderStatus == 'Approved') badge-success 
                          @else badge-danger 
                          @endif">
                          {{ $order->orderStatus }}
                        </span>
                      </td>
                      <td>
                        @if($order->orderStatus == 'Pending')
                            Not Applicable
                        @elseif($order->orderStatus == 'Rejected' && is_null($order->reason))
                            Insufficient Quantity
                        @elseif($order->orderStatus == 'Rejected')
                            <button class="btn btn-info btn-sm view-rejection-reason" data-reason="{{ $order->reason }}">
                                <i class="fas fa-eye"></i> View
                            </button>
                        @else
                            Not Applicable
                        @endif
                    </td>
                      <td>
                        <button class="btn btn-primary btn-sm view-order-details" data-orderid="{{ $order->orderID }}">
                          <i class="fas fa-folder"></i> View
                        </button>
                      </td>
                      <td>
                        <button class="btn btn-danger btn-sm cancel-order" 
                                data-orderid="{{ $order->orderID }}" 
                                @if($order->orderStatus !== 'Pending') disabled @endif>
                          <i class="fas fa-times"></i> Cancel
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
  <h5><strong>Order ID: <span id="order-id"></span></strong></h5>
  <h5>Order Quantity: <span id="order-quantity"></span></h5>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Stock Name</th>
        <th>Quantity</th>
      </tr>
    </thead>
    <tbody id="order-details-table-body">
      <!-- Item details will be injected here -->
    </tbody>
  </table>
</div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="rejectionReasonModal" tabindex="-1" role="dialog" aria-labelledby="rejectionReasonModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rejectionReasonModalLabel">Rejection Reason</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="rejection-reason-content">
        <!-- Reason will be injected here -->
      </div>
    </div>
  </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmCancelModal" tabindex="-1" role="dialog" aria-labelledby="confirmCancelModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmCancelModalLabel">Confirm Cancellation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to cancel this order? This action cannot be undone.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger" id="confirmCancelBtn">Yes, Cancel Order</button>
      </div>
    </div>
  </div>
</div>

<!-- Toast Notification -->
<div class="toast" id="toastNotification" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000" style="position: absolute; top: 20px; right: 20px;">
  <div class="toast-header">
    <strong class="mr-auto" id="toastTitle">Notification</strong>
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="toast-body" id="toastMessage"></div>
</div>

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
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
  $('.view-order-details').on('click', function() {
    var orderId = $(this).data('orderid');
    $.ajax({
      url: '/supervisor/orderStatusDetails/' + orderId,
      method: 'GET',
      success: function(response) {
        $('#order-id').text(response.order.orderID);
        $('#order-quantity').text(response.order.orderQuantity);

        var tableBody = '';
        response.orderDetails.forEach(function(detail) {
          tableBody += `<tr>
            <td>${detail.stockName}</td>
            <td>${detail.quantity}</td>
          </tr>`;
        });
        $('#order-details-table-body').html(tableBody);

        $('#orderDetailsModal').modal('show');
      },
      error: function() {
        alert('Failed to load order details.');
      }
    });
  });

  $('.view-rejection-reason').on('click', function() {
    // Get the rejection reason from the data attribute
    var reason = $(this).data('reason');

    // Set the reason in the modal body
    $('#rejection-reason-content').text(reason);

    // Show the modal
    $('#rejectionReasonModal').modal('show');
  });

  let selectedOrderId = null;

  $('.cancel-order').on('click', function() {
    selectedOrderId = $(this).data('orderid');
    $('#confirmCancelModal').modal('show');
  });

  $('#confirmCancelBtn').on('click', function() {
    if (selectedOrderId) {
      $.ajax({
        url: '/supervisor/cancelOrder/' + selectedOrderId,
        method: 'POST',
        data: {
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $('#confirmCancelModal').modal('hide');
          showToast('Success', response.message, 'toast-success');
          location.reload(); // Refresh the page to reflect the changes
        },
        error: function(xhr) {
          $('#confirmCancelModal').modal('hide');
          showToast('Error', xhr.responseJSON.message || 'Failed to cancel the order. Please try again later.', 'toast-error');
        }
      });
    }
  });
  // Initialize DataTable for the Order History table
  $('#orderStatusTable').DataTable({
    order: [[1, 'desc']], // Default sort on the "No." column
    paging: true, // Enable pagination
    pageLength: 10, // Default number of entries per page
    lengthMenu: [5, 10, 25, 50], // Options for "Show Entries"
    searching: true, // Optional: Disable search if not needed
  });

  function showToast(title, message, toastClass) {
    $('#toastNotification').removeClass('toast-success toast-error').addClass(toastClass);
    $('#toastTitle').text(title);
    $('#toastMessage').text(message);
    $('#toastNotification').toast('show');
  }
});
</script>
</body>
</html>