<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OODS | Arrange Delivery</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <style>
        .hiddenRow {
            padding: 0 !important;
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
        <a href="{{ url('admin/dashboard') }}" class="nav-link">Home</a>
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
            <a href="{{ url('#') }}" class="nav-link active">
              <i class="nav-icon fas fa-truck"></i>
              <p>Arrange Delivery</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/admin/adminOrderHistory') }}" class="nav-link">
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
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Arrange Delivery</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->

            @if (session('success'))
            <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="successModalLabel">Update Status Success</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <strong>Delivery ID:</strong> {{ session('deliveryID') }}<br>
                            Status Updated to: {{ session('status') }}<br>
                            on {{ session('date') }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Error Modal -->
            @if (session('error'))
            <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="errorModalLabel">Error</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <strong>Error:</strong> {{ session('error') }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container">
                <!-- Card Component -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Orders List</h3>
                    </div>
                    <div class="card-body">
                        <table id="arrangeDeliveryTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Delivery ID</th>
                                    <th>Order ID(s)</th>
                                    <th>Order Status</th>
                                    <th>Delivery Status</th>
                                    <th>Outlet</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($deliveries as $index => $delivery)
                                    <tr data-toggle="collapse" data-target="#deliveryDetails{{ $index }}" class="accordion-toggle">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $delivery->deliveryID }}</td>
                                        <td>
                                            @foreach($delivery->orders as $order)
                                                {{ $order->orderID }}@if(!$loop->last), @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($delivery->orders as $order)
                                                {{ $order->orderStatus }}@if(!$loop->last), @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $delivery->deliveryStatus ?? 'Not Updated Yet' }}</td>
                                        <td>{{ $delivery->user->Name ?? 'N/A' }}</td>
                                        <td><button class="btn btn-primary" type="button">View Details</button></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="hiddenRow">
                                            <div class="collapse" id="deliveryDetails{{ $index }}">
                                                <div class="card card-body">
                                                    <!-- Display Delivery Information -->
                                                    <div class="card-body">
                                                        <dl class="row">
                                                          <dt class="col-sm-2">Delivery Address</dt>
                                                          <dd class="col-sm-9">{{ $delivery->user->outletAddress ?? 'N/A' }}</dd>
                                                          <dt class="col-sm-2">Contact Number</dt>
                                                          <dd class="col-sm-9">{{ $delivery->user->phoneNumber ?? 'N/A' }}</dd>
                                                        </dl>
                                                    </div>

                                                    <!-- Update Delivery Status Form -->
                                                    <form action="{{ route('admin.updateDeliveryStatus', $delivery->deliveryID) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="status_{{ $delivery->deliveryID }}">Delivery Status</label>
                                                            <select name="deliveryStatus" id="status_{{ $delivery->deliveryID }}" class="form-control">
                                                                <option value="Not Updated Yet"
                                                                    {{ ($delivery->deliveryStatus ?? '') == 'Not Updated Yet' ? 'selected' : '' }}
                                                                    {{ $delivery->deliveryStatus ? 'disabled' : '' }}>
                                                                    Not Updated Yet
                                                                </option>
                                                                <option value="Preparing for Delivery"
                                                                    {{ ($delivery->deliveryStatus ?? '') == 'Preparing for Delivery' ? 'selected' : '' }}
                                                                    {{ in_array($delivery->deliveryStatus, ['Shipped', 'Out for Delivery', 'Delivered']) ? 'disabled' : '' }}>
                                                                    Preparing for Delivery
                                                                </option>
                                                                <option value="Shipped"
                                                                    {{ ($delivery->deliveryStatus ?? '') == 'Shipped' ? 'selected' : '' }}
                                                                    {{ in_array($delivery->deliveryStatus, ['Out for Delivery', 'Delivered']) ? 'disabled' : '' }}>
                                                                    Shipped
                                                                </option>
                                                                <option value="Out for Delivery"
                                                                    {{ ($delivery->deliveryStatus ?? '') == 'Out for Delivery' ? 'selected' : '' }}
                                                                    {{ $delivery->deliveryStatus == 'Delivered' ? 'disabled' : '' }}>
                                                                    Out for Delivery
                                                                </option>
                                                                <option value="Delivered"
                                                                    {{ ($delivery->deliveryStatus ?? '') == 'Delivered' ? 'selected' : '' }}>
                                                                    Delivered
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group delivery-date" style="display: none;">
                                                            <label for="date_{{ $delivery->deliveryID }}">Date</label>
                                                            <input
                                                                type="date"
                                                                name="deliveryDate"
                                                                id="date_{{ $delivery->deliveryID }}"
                                                                class="form-control"
                                                                value="{{
                                                                    $delivery->deliveryStatus === 'Preparing for Delivery' ? $delivery->preparing_date :
                                                                    ($delivery->deliveryStatus === 'Shipped' ? $delivery->shipped_date :
                                                                    ($delivery->deliveryStatus === 'Out for Delivery' ? $delivery->out_for_delivery_date :
                                                                    ($delivery->deliveryStatus === 'Delivered' ? $delivery->delivered_date : '')))
                                                                }}"
                                                                min="{{ now()->toDateString() }}"
                                                                required>
                                                        </div>
                                                        <div class="form-group runner-phone-number" style="display: none;">
                                                            <label for="runner_phone_{{ $delivery->deliveryID }}">Runner Phone Number</label>
                                                            <input
                                                                type="tel"
                                                                name="runnerPhoneNumber"
                                                                id="runner_phone_{{ $delivery->deliveryID }}"
                                                                class="form-control"
                                                                pattern="^(01[0-46-9]-?\d{7,8}|0[2-9]\d{7,9})$"
                                                                value="{{ old('runnerPhoneNumber', $delivery->runnerPhoneNumber ?? '') }}"
                                                                placeholder="e.g., 0123456789">
                                                            @if ($errors->has('runnerPhoneNumber'))
                                                                <span class="text-danger">{{ $errors->first('runnerPhoneNumber') }}</span>
                                                            @endif
                                                        </div>

                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-success"
                                                                {{ ($delivery->deliveryStatus ?? '') == 'Delivered' ? 'disabled' : '' }}>
                                                                Update Status
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Update Status Success</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>Delivery ID:</strong> {{ session('deliveryID') }}<br>
                    Status Updated to: {{ session('status') }}<br>
                    on {{ session('date') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!--<strong>Delivery ID:</strong> {{ session('deliveryID') }}<br>-->
                    <strong>Error:</strong> {{ session('error') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    $(document).ready(function() {
        // Ensure that session data exists and is not null
        var preparingDate = "{{ session('statusDates')['preparingDate'] ?? '' }}";
        var shippedDate = "{{ session('statusDates')['shippedDate'] ?? '' }}";
        var outForDeliveryDate = "{{ session('statusDates')['outForDeliveryDate'] ?? '' }}";
        var deliveredDate = "{{ session('statusDates')['deliveredDate'] ?? '' }}";

        $('input[type="date"]').each(function() {
        var today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format
        $(this).attr('min', today); // Set the min attribute dynamically
        });

        // Function to calculate the minimum date based on delivery status
        function getMinDate(status) {
        switch (status) {
            case 'Preparing for Delivery':
                return preparingDate ? preparingDate : "{{ now()->toDateString() }}";
            case 'Shipped':
                return shippedDate ? shippedDate : "{{ now()->toDateString() }}";
            case 'Out for Delivery':
                return outForDeliveryDate ? outForDeliveryDate : "{{ now()->toDateString() }}";
            case 'Delivered':
                return deliveredDate ? deliveredDate : "{{ now()->toDateString() }}";
            default:
                return "{{ now()->toDateString() }}";
        }
    }


        // Show/Hide delivery date, image, and phone number input based on selected status
        $('select[name="deliveryStatus"]').on('change', function() {
            var selectedStatus = $(this).val();
            var form = $(this).closest('form');
            var dateInput = form.find('.delivery-date');
            var imageInput = form.find('.delivery-image');
            var phoneInput = form.find('.runner-phone-number');
            var currentMinDate = getMinDate(selectedStatus);

            if (selectedStatus === 'Shipped') {
                phoneInput.show();
                phoneInput.find('input').prop('required', true);
            } else {
                phoneInput.hide();
                phoneInput.find('input').prop('required', false);
            }

            // Show/Hide inputs based on the selected status
            if (selectedStatus === 'Shipped') {
                phoneInput.show();
                dateInput.show();
                imageInput.hide();
            } else if (selectedStatus === 'Preparing for Delivery' || selectedStatus === 'Out for Delivery') {
                dateInput.show();
                imageInput.hide();
                phoneInput.hide();
            } else if (selectedStatus === 'Delivered') {
                dateInput.show();
                imageInput.show();
                phoneInput.hide();
            } else {
                dateInput.hide();
                imageInput.hide();
                phoneInput.hide();
            }

            // Fetch the current date for the selected status
            var currentDate = '';
            switch (selectedStatus) {
                case 'Preparing for Delivery':
                    currentDate = form.find('input[name="deliveryDate"]').val();
                    break;
                case 'Shipped':
                    currentDate = form.find('input[name="deliveryDate"]').val();
                    break;
                case 'Out for Delivery':
                    currentDate = form.find('input[name="deliveryDate"]').val();
                    break;
                case 'Delivered':
                    currentDate = form.find('input[name="deliveryDate"]').val();
                    break;
            }

            // Apply the correct min date to the date input based on the current status
            if (currentMinDate) {
                form.find('input[type="date"]').attr('min', currentMinDate);
            }

            // Set the current date in the date input
            dateInput.val(currentDate);

        }).trigger('change');  // Trigger the change event on page load to set the initial state

        // Trigger modals based on session messages
        @if(session('status'))
            $('#successModal').modal('show');
        @endif

        @if(session('error'))
            $('#errorModal').modal('show');
        @endif
    });
</script>
</body>
</html>
