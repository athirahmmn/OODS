<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OODS | Update Order Status</title>

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
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('admin/dashboard') }}" class="nav-link">Home</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
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

    <aside class="main-sidebar sidebar-dark-primary">
        <a href="{{ url('#') }}" class="brand-link">
            <img src="{{ asset('images/smootea_logo.jpg') }}" alt="smootea logo" class="brand-image elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">SMOOTEA</span>
        </a>

        <div class="sidebar">
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

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ url('/admin/dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('admin/manageStock') }}" class="nav-link">
                            <i class="nav-icon fas fa-cubes"></i>
                            <p>Manage Stock</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('#') }}" class="nav-link active">
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
                        <a href="{{ url('/admin/adminOrderHistory') }}" class="nav-link">
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
                        <h1>Update Order Status</h1>
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
                                <h3 class="card-title">Update Order Status</h3>
                                <button class="btn btn-success btn-sm float-right" id="arrangeDeliveryButton">Arrange Delivery</button>
                            </div>
                            
                            <!-- Error alert for displaying notifications -->
                            <div class="alert alert-danger alert-dismissible fade show d-none" id="errorAlert" role="alert">
                                <strong>Error:</strong> You can only select orders from the same outlet.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="card-body">
                                <table id="orderStatusTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>No.</th>
                                            <th>Order ID</th>
                                            <th>Outlet</th>
                                            <th>Order Date</th>
                                            <th>Order Status</th>
                                            <th>Update Status</th>
                                            <th>Rejection Reason</th>
                                            <th>Action</th>
                                            <th>Order Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $index => $order)
                                        <tr>
                                            <td>
                                                <input type="checkbox" 
                                                    class="orderCheckbox" 
                                                    value="{{ $order->orderID }}" 
                                                    data-outlet-id="{{ $order->user->id ?? '' }}" 
                                                @if($order->deliveryID) disabled @endif>
                                            </td>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $order->orderID }}</td>
                                            <td>{{ $order->user->Name ?? 'N/A' }}</td>
                                            <td>{{ $order->orderDate }}</td>
                                            <td class="project-state">
                                                @if($order->orderStatus == 'Pending')
                                                    <form action="{{ route('admin.updateOrderStatus.update', $order->orderID) }}" method="POST" id="form{{ $order->orderID }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <form action="{{ route('admin.updateOrderStatus.update', $order->orderID) }}" method="POST" id="form{{ $order->orderID }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <select name="orderStatus" class="form-control orderStatusDropdown" data-orderid="{{ $order->orderID }}">
                                                                <option value="Pending" @if($order->orderStatus == 'Pending') selected @endif>Pending</option>
                                                                <option value="Approved" @if($order->orderStatus == 'Approved') selected @endif>Approved</option>
                                                                <option value="Rejected" @if($order->orderStatus == 'Rejected') selected @endif>Rejected</option>
                                                            </select>
                                                        </form>
                                                    </form>
                                                @else
                                                    <span>{{ $order->orderStatus }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($order->orderStatus == 'Pending')
                                                    <span class="badge badge-danger">Not Updated Yet</span>
                                                @else
                                                    <span class="badge badge-success">Updated</span>
                                                @endif
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
                                                <button type="button" class="btn btn-success btn-sm btn-update-status" data-orderid="{{ $order->orderID }}" @if($order->orderStatus != 'Pending') disabled @endif>Update</button>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-sm view-order-details" data-orderid="{{ $order->orderID }}">
                                                    <i class="fas fa-folder"></i> View
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
                        <!-- Order details content will be loaded here -->
                        <div id="order-details-content">
                            <!-- Placeholder content, will be replaced by AJAX response -->
                            <h5>Outlet: <span id="username"></span></h5>
                            <h5><strong>Order ID: <span id="order-id"></span></strong></h5>
                            <h5>Order Quantity: <span id="order-quantity"></span></h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Stock Name</th>
                                        <th>Requested Quantity</th>
                                        <th>Available Quantity</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="order-details-table-body">
                                    <!-- Dynamic content will be loaded here -->
                                </tbody>
                            </table>
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

        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Order Status Updated</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Order ID: <strong>{{ session('orderID') }}</strong> has been <strong>{{ session('orderStatus') }}</strong>.
                    </div>
                </div>
            </div>
        </div>

        <!-- No order selected -->
        <div class="modal fade" id="noOrderSelectedModal" tabindex="-1" role="dialog" aria-labelledby="errorPendingModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="errorPendingModalLabel">Error</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Please select at least one order to arrange delivery
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Pending Modal -->
        <div class="modal fade" id="errorPendingModal" tabindex="-1" role="dialog" aria-labelledby="errorPendingModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="errorPendingModalLabel">Error</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Please update the order status to either approve or reject
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Rejected Modal -->
        <div class="modal fade" id="errorRejectedModal" tabindex="-1" role="dialog" aria-labelledby="errorPendingModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="errorPendingModalLabel">Error</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        There is an issue with the delivery arrangement. Please update order status or choose orders from the same user
                    </div>
                </div>
            </div>
        </div> 

        <!-- User Mismatch Error Modal -->
        <div class="modal fade" id="userMismatchModal" tabindex="-1" role="dialog" aria-labelledby="userMismatchModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userMismatchModalLabel">Error</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        The selected orders must belong to the same user to arrange a single delivery. Please select orders from the same user.
                    </div>
                </div>
            </div>
        </div>
        <!-- Reject Confirmation Modal -->
        <div id="confirmRejectModal" class="modal fade">
            <div class="modal-dialog">
                <form id="rejectForm" onsubmit="return false;"> <!-- Ensure onsubmit prevents default -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Rejection</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p id="rejectMessage"></p>
                            <div id="rejectReasonContainer">
                                <label for="rejectReason">Reason for Rejection</label>
                                <textarea id="rejectReason" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" id="confirmRejectButton" class="btn btn-danger">Reject</button>
                        </div>
                    </div>
                </form>
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
    let selectedOutletId = null;

    // Handle checkbox change events
    $('.orderCheckbox').on('change', function() {
        const currentOutletId = $(this).data('outlet-id');

        if ($(this).is(':checked')) {
            if (!selectedOutletId) {
                // Set selectedOutletId to the first selected outlet ID
                selectedOutletId = currentOutletId;
            } else if (selectedOutletId !== currentOutletId) {
                // Show the user mismatch error modal if different outlet is selected
                $('#userMismatchModal').modal('show');
                $(this).prop('checked', false); // Uncheck the box
            }
        } else {
            // Reset selectedOutletId if no checkboxes are checked
            if ($('.orderCheckbox:checked').length === 0) {
                selectedOutletId = null;
            }
        }
    });

    $('#confirmRejectButton').on('click', function(e) {
        e.preventDefault(); // Stop the default form or button behavior

        const orderId = $('#confirmRejectModal').data('orderid'); // Get order ID
        const rejectReason = $('#rejectReason').val().trim(); // Get reject reason

        // Ensure a reason is provided if required
        if (!$('#rejectReasonContainer').hasClass('d-none') && !rejectReason) {
            alert('Please provide a reason for rejection.');
            return;
        }

        // Send AJAX request for rejection
        $.ajax({
            url: `/admin/updateOrderStatus/${orderId}`, // Backend route
            method: 'PUT', // HTTP method
            data: {
                _token: '{{ csrf_token() }}', // Laravel CSRF protection
                orderStatus: 'Rejected', // Rejected status
                reason: rejectReason, // Reason for rejection
            },
            success: function(response) {
                if (response.status === 'success') {
                    // Hide modal and show success message
                    $('#confirmRejectModal').modal('hide');
                    $('#successModal').find('.modal-body').text(response.success_message);
                    $('#successModal').modal('show');

                    // Reload the page after a delay
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    alert(response.message || 'Failed to reject the order. Please try again.');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                if (response && response.message) {
                    alert(response.message);
                } else {
                    alert('Failed to update the order status. Please try again.');
                }
            },
        });
    });

    // Example: Approve button handler (similar structure to Reject)
    $(document).on('click', '.btn-update-status', function(e) {
        e.preventDefault(); // Stop default behavior

        const orderId = $(this).data('orderid'); // Get order ID
        const orderStatus = $(this).closest('tr').find('select[name="orderStatus"]').val();

        if (orderStatus === 'Rejected') {
            // Handle rejection logic
            // (Fetch stock availability and show modal)
            $.ajax({
                url: `/admin/checkStockAvailability/${orderId}`,
                method: 'GET',
                success: function(response) {
                    if (response.isSufficient) {
                        $('#rejectMessage').text('The stock is sufficient. Please provide a reason for rejecting this order.');
                        $('#rejectReasonContainer').removeClass('d-none');
                    } else {
                        $('#rejectMessage').text('The stock is insufficient. Confirm to reject the order.');
                        $('#rejectReasonContainer').addClass('d-none');
                    }
                    $('#confirmRejectModal').data('orderid', orderId).modal('show');
                },
                error: function() {
                    alert('Failed to check stock availability. Please try again.');
                },
            });
        } else if (orderStatus === 'Approved') {
            // Handle approval logic
            $.ajax({
                url: `/admin/updateOrderStatus/${orderId}`,
                method: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    orderStatus: 'Approved',
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $('#successModal').find('.modal-body').text(response.success_message);
                        $('#successModal').modal('show');

                        // Reload page after delay
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        alert(response.message || 'Failed to approve the order. Please try again.');
                    }
                },
                error: function() {
                    alert('Failed to update the order status. Please try again.');
                },
            });
        }
    });

    $('.view-rejection-reason').on('click', function() {
    // Get the rejection reason from the data attribute
    var reason = $(this).data('reason');

    // Set the reason in the modal body
    $('#rejection-reason-content').text(reason);

    // Show the modal
    $('#rejectionReasonModal').modal('show');
  });

    function validateStock(orderId, dropdown) {
        $.ajax({
            url: `/admin/checkStockAvailability/${orderId}`,
            method: 'GET',
            success: function (response) {
                if (!response.isSufficient) {
                    // Disable the "Approved" option if stock is insufficient
                    dropdown.find('option[value="Approved"]').prop('disabled', true);
                } else {
                    // Enable the "Approved" option if stock is sufficient
                    dropdown.find('option[value="Approved"]').prop('disabled', false);
                }
            },
            error: function () {
                console.error(`Failed to check stock availability for Order ID ${orderId}.`);
            }
        });
    }

    // Validate stock availability for all dropdowns on page load
    $('.orderStatusDropdown').each(function () {
        const dropdown = $(this);
        const orderId = dropdown.data('orderid');
        validateStock(orderId, dropdown);
    });

    // Optionally revalidate on dropdown change (if needed)
    $('.orderStatusDropdown').on('change', function () {
        const dropdown = $(this);
        const orderId = dropdown.data('orderid');
        validateStock(orderId, dropdown);
    });

    // Handle "Arrange Delivery" button click
    $('#arrangeDeliveryButton').on('click', function() {
        var selectedOrders = [];
        var hasPendingOrder = false;
        var hasRejectedOrder = false;

        let mismatch = false;

        // Collect selected orders and validate statuses
        $('.orderCheckbox:checked').each(function() {
            selectedOrders.push($(this).val());
            var orderStatus = $(this).closest('tr').find('td:nth-child(6) select').val();

            if (orderStatus === 'Pending') {
                hasPendingOrder = true;
            } else if (orderStatus === 'Rejected') {
                hasRejectedOrder = true;
            }

            // Check for outlet mismatch
            const currentOutletId = $(this).data('outlet-id');
            if (!selectedOutletId) {
                selectedOutletId = currentOutletId;
            } else if (selectedOutletId !== currentOutletId) {
                mismatch = true;
            }
        });

        // Check conditions in the correct priority order
        if (selectedOrders.length === 0) {
            // No orders selected
            $('#noOrderSelectedModal').modal('show');
            return;
        }

        if (hasRejectedOrder) {
            // Rejected order selected
            $('#errorRejectedModal').modal('show');
            return;
        }

        if (hasPendingOrder) {
            // Pending order selected
            $('#errorPendingModal').modal('show');
            return;
        }

        if (mismatch) {
            // User mismatch detected
            $('#userMismatchModal').modal('show');
            return;
        }

        // If no issues, proceed with arrange delivery
        $.ajax({
            url: '{{ route('admin.createDelivery') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                orderIDs: selectedOrders
            },
            success: function(response) {
                if (response.status === 'success') {
                    window.location.href = '{{ route('admin.arrangeDelivery') }}';
                } else if (response.status === 'error') {
                    // Show appropriate error modal
                    $('#errorRejectedModal').modal('show');
                }
            }
        });
    });

    $('.view-order-details').on('click', function() {
        var orderId = $(this).data('orderid');
        $.ajax({
            url: '/admin/orderDetails/' + orderId,
            method: 'GET',
            success: function(response) {
                $('#username').text(response.username);
                $('#order-id').text(response.order.orderID);
                $('#order-quantity').text(response.order.orderQuantity);

                var tableBody = '';
                response.orderDetails.forEach(function(detail) {
                    var statusIcon = detail.requestedQuantity <= detail.availableQuantity ? '✔' : '✖';
                    var statusClass = detail.requestedQuantity <= detail.availableQuantity ? 'badge-success' : 'badge-danger';
                    tableBody += `
                        <tr>
                            <td>${detail.stockName}</td>
                            <td>${detail.requestedQuantity}</td>
                            <td>${detail.availableQuantity}</td>
                            <td><span class="badge ${statusClass}">${statusIcon}</span></td>
                        </tr>
                    `;
                });
                $('#order-details-table-body').html(tableBody);

                $('#orderDetailsModal').modal('show');
            }
        });
    });

    $('#orderStatusTable').DataTable({
        order: [[1, 'desc']], // Default sort on the "No." column
        paging: true, // Enable pagination
        pageLength: 10, // Default number of entries per page
        lengthMenu: [5, 10, 25, 50], // Options for "Show Entries"
        searching: true, // Optional: Disable search if not needed
    });

    @if(session('status') === 'success')
        $('#successModal').modal('show');
    @elseif(session('status') === 'error')
        $('#errorPendingModal').modal('show');
    @endif

    // Handle modal confirmation
    $('#confirmRejectButton').on('click', function () {
        const orderId = $('#confirmRejectModal').data('orderid');
        $(`#form${orderId}`);
    });
});
</script>
</body>
</html>