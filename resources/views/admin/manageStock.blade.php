<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OODS | Manage Stock</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .stock-container {
      border: 3px solid #ddd;
      border-radius: 5px;
      padding: 15px;
      background-color: #fff;
      width: 90%;
      margin: 10px;
    }
    .stock-image {
      max-width: 100px;
      max-height: 100px;
    }
    .stock-info {
      flex-grow: 1;
      padding-left: 15px;
    }
    .content-wrapper {
      margin-left: 250px;
    }
    .row {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }
    .filter-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      width: 100%;
    }
    .main-container {
      padding: 20px;
      background-color: white;
      border-radius: 5px;
    }
    .alert {
      display: none;
      position: fixed;
      top: 70px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 1000;
    }
    .wider-button {
      width: 150px; /* Adjust width as needed */
    }
    .filter-dropdown {
      width: 150px; /* Adjust width as needed */
    }
    .button-container {
      display: flex;
      gap: 10px; /* Adjust the gap as needed */
    }
    .button-container button {
      margin: auto; /* Auto margin for horizontal centering */
    }
    .add-stock-btn {
      margin-left: 10px;
      width: 150px; /* Wider button */
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
    <a href="#" class="brand-link">
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
            <a href="{{ url('#') }}" class="nav-link active">
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
            <a href="{{ url('/admin/adminOrderHistory') }}" class="nav-link">
              <i class="nav-icon fas fa-history"></i>
              <p>Order History</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper p-3">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage Stocks</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="main-container">
          <div class="filter-container">
            <button class="btn btn-success add-stock-btn" onclick="openAddStockModal()">Add New Stock</button>
            <select id="categoryFilter" class="form-control filter-dropdown" onchange="filterStocks()">
              <option value="all">All</option>
              <option value="syrup">Syrup</option>
              <option value="powder">Powder</option>
              <option value="sweetener">Sweetener</option>
              <option value="dairy">Dairy</option>
              <option value="topping">Topping</option>
            </select>
          </div>
          <div class="row" id="stockList">
            @if($stocks->isEmpty())
              <div class="col-12">
                <div class="alert alert-info">No stocks recorded.</div>
              </div>
            @else
              @foreach($stocks as $stock)
              <div class="col-md-4 stock-item" data-category="{{ $stock->category }}">
                  <div class="stock-container">
                      <h5><b>{{ $stock->stocksName }}</b></h5><br>
                      <div class="d-flex">
                          <img src="{{ asset($stock->image) }}" alt="{{ $stock->stocksName }}" class="stock-image">
                          <div class="stock-info">
                              <p><strong>Stock ID:</strong> {{ $stock->stocksID }}</p>
                              <p><strong>Warehouse Quantity:</strong> {{ $stock->warehouse->stocksQuantity ?? 'N/A' }}</p>
                              <p><strong>Price:</strong> RM {{ number_format($stock->price, 2) }}</p>
                          </div>
                      </div>
                      <div class="button-container">
                          <button class="btn btn-primary btn-block mt-3 wider-button" onclick="editStock({{ $stock->stocksID }}, '{{ $stock->stocksName }}', {{ $stock->warehouse->stocksQuantity ?? 0 }}, {{ $stock->price }}, '{{ $stock->category }}')">Edit</button>
                          <button class="btn btn-danger btn-block mt-3 wider-button" onclick="confirmDeleteStock({{ $stock->stocksID }})">Delete</button>
                      </div>
                  </div>
              </div>
              @endforeach
            @endif
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Add Stock Modal -->
  <div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="addStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStockModalLabel">Add New Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addStockForm" action="{{ route('admin.stocks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="addStockName">Stock Name</label>
                        <input type="text" class="form-control" id="addStockName" name="stocksName" maxlength="30" required>
                        <small id="addStockNameError" class="form-text text-danger" style="display:none;"></small>
                    </div>
                    <div class="form-group">
                        <label for="addWarehouseQuantity">Warehouse Quantity</label>
                        <input type="number" class="form-control" id="addWarehouseQuantity" name="warehouseQuantity" required>
                        <small id="quantityError" class="form-text text-danger" style="display:none;"></small>
                    </div>
                    <div class="form-group">
                        <label for="addStockPrice">Price (RM)</label>
                        <input type="number" step="0.01" min="1" class="form-control" id="addStockPrice" name="price" required>
                        <small id="priceError" class="form-text text-danger" style="display:none;"></small>
                    </div>
                    <div class="form-group">
                        <label for="addStockCategory">Category</label>
                        <select class="form-control" id="addStockCategory" name="category" required>
                            <option value="syrup">Syrup</option>
                            <option value="powder">Powder</option>
                            <option value="sweetener">Sweetener</option>
                            <option value="dairy">Dairy</option>
                            <option value="topping">Topping</option>
                        </select>
                    </div>
                    <!-- Stock Image Input -->
                    <div class="form-group">
                      <label for="addStockImage">Stock Image</label>
                      <input type="file" class="form-control" id="addStockImage" name="stockImage" accept="image/*" required>
                      <small id="imageError" class="form-text text-danger" style="display:none;"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Stock</button>
                </div>
            </form>
        </div>
    </div>
  </div>

  <!-- Edit Stock Modal -->
  <div class="modal fade" id="editStockModal" tabindex="-1" aria-labelledby="editStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStockModalLabel">Edit Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editStockForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editStockID" name="stocksID">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editStockName">Stock Name</label>
                        <input type="text" class="form-control" id="editStockName" name="stocksName" maxlength="30">
                        <small id="editStockNameError" class="form-text text-danger" style="display:none;"></small>
                    </div>
                    <div class="form-group">
                        <label for="editWarehouseQuantity">Warehouse Quantity</label>
                        <input type="number" class="form-control" id="editWarehouseQuantity" name="warehouseQuantity">
                        <small id="editQuantityError" class="form-text text-danger" style="display:none;"></small>
                    </div>
                    <div class="form-group">
                        <label for="editStockPrice">Price (RM)</label>
                        <input type="number" step="0.01" min="1" class="form-control" id="editStockPrice" name="price">
                        <small id="editPriceError" class="form-text text-danger" style="display:none;"></small>
                    </div>
                    <div class="form-group">
                        <label for="editStockCategory">Category</label>
                        <select class="form-control" id="editStockCategory" name="category" required>
                            <option value="syrup">Syrup</option>
                            <option value="powder">Powder</option>
                            <option value="sweetener">Sweetener</option>
                            <option value="dairy">Dairy</option>
                            <option value="topping">Topping</option>
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="editStockImage">Stock Image</label>
                      <input type="file" class="form-control" id="editStockImage" name="stockImage" accept="image/*">
                      <small id="editStockImageError" class="form-text text-danger" style="display:none;"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Stock</button>
                </div>
            </form>
        </div>
    </div>
  </div>

  <div class="modal fade" id="duplicateStockModal" tabindex="-1" aria-labelledby="duplicateStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="duplicateStockModalLabel">Duplicate Stock Alert</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Error message will be inserted dynamically here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- REQUIRED SCRIPTS -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/adminlte.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Constants
  const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB
  const MAX_CHAR_LIMIT = 30; // Character limit for Stock Name
  const MAX_QUANTITY = 100000; // Max quantity limit
  const MIN_QUANTITY = 1; // Min quantity limit
  const MAX_PRICE = 900000; // Max price limit
  const MIN_PRICE = 1; // Min price limit

  // Utility Functions
  function resetErrorMessage(selector) {
    $(selector).hide().text(''); // Reset error message by hiding the element and clearing text
  }

  function disableSubmitButton(formSelector, state) {
    $(`${formSelector} button[type="submit"]`).prop('disabled', state); // Enable or disable submit button
  }

  function validateStockName(inputSelector, errorSelector) {
    const value = $(inputSelector).val();
    if (value.length > MAX_CHAR_LIMIT) {
      $(errorSelector).show().text(`Stock name must be ${MAX_CHAR_LIMIT} characters or fewer.`);
      disableSubmitButton('#addStockForm', true); // Disable Add Stock submit button
      disableSubmitButton('#editStockForm', true); // Disable Edit Stock submit button
      return false;
    } else {
      resetErrorMessage(errorSelector); // Reset error message
      return true;
    }
  }

  function isValidPrice(price) {
    const numericPrice = parseFloat(price);
    return numericPrice > 1 && numericPrice <= 900000; // Allows decimal numbers greater than 1
  }

  function isValidQuantity(quantity) {
    return quantity >= MIN_QUANTITY && quantity <= MAX_QUANTITY && Number.isInteger(Number(quantity)); // Quantity must be between 1 and 100,000 and an integer
  }

  function handleFileValidation(fileInput, errorSelector, formSelector) {
    const file = fileInput.files[0];
    resetErrorMessage(errorSelector); // Reset previous error message
    disableSubmitButton(formSelector, false); // Enable submit button initially

    if (file) {
      const validImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
      if (!validImageTypes.includes(file.type)) {
        $(errorSelector).show().text('Invalid file type. Please upload an image (JPEG, PNG, JPG).');
        disableSubmitButton(formSelector, true);
        return false;
      }
      if (file.size > MAX_FILE_SIZE) {
        $(errorSelector).show().text('File is too large. Please upload an image smaller than 2MB.');
        disableSubmitButton(formSelector, true);
        return false;
      }
    }
    return true;
  }

  // Validation for Add Stock Form
  function validateAddStockForm() {
    const price = $('#addStockPrice').val();
    const quantity = $('#addWarehouseQuantity').val();
    let isPriceValid = true;
    let isQuantityValid = true;

    if (!isValidPrice(price)) {
      $('#priceError').show().text(`Invalid price. It must be more than 1 and less than or equal to 900,000.`);
      isPriceValid = false;
    } else {
      resetErrorMessage('#priceError');
    }

    if (!isValidQuantity(quantity)) {
      $('#quantityError').show().text(`Invalid quantity. It must be between ${MIN_QUANTITY} and ${MAX_QUANTITY}, and cannot be a decimal.`);
      isQuantityValid = false;
    } else {
      resetErrorMessage('#quantityError');
    }

    disableSubmitButton('#addStockForm', !(isPriceValid && isQuantityValid));
    return isPriceValid && isQuantityValid;
  }

  // Validation for Edit Stock Form
  function validateEditStockForm() {
    const price = $('#editStockPrice').val();
    const quantity = $('#editWarehouseQuantity').val();
    let isValid = true;

    if (!isValidPrice(price)) {
      $('#editPriceError').show().text(`Invalid price. It must be more than 1 and less than or equal to 900,000.`);
      isValid = false;
    }

    if (!isValidQuantity(quantity)) {
      $('#editQuantityError').show().text(`Invalid quantity. It must be between ${MIN_QUANTITY} and ${MAX_QUANTITY}, and cannot be a decimal.`);
      isValid = false;
    } else {
      resetErrorMessage('#editQuantityError');
    }

    disableSubmitButton('#editStockForm', !isValid);
    return isValid;
  }

  // Modal Management
  function openAddStockModal() {
    $('#addStockModal').modal('show');
    resetErrorMessage('#priceError');
    resetErrorMessage('#quantityError');
    resetErrorMessage('#imageError');
    disableSubmitButton('#addStockForm', false);
  }

  function editStock(stocksID, stockName, warehouseQuantity, stockPrice, category) {
    $('#editStockID').val(stocksID);
    $('#editStockName').val(stockName);
    $('#editWarehouseQuantity').val(warehouseQuantity);
    $('#editStockPrice').val(stockPrice);
    $('#editStockCategory').val(category);
    $('#editStockModal').modal('show');
    resetErrorMessage('#editPriceError');
    resetErrorMessage('#editQuantityError');
    disableSubmitButton('#editStockForm', false);
  }

  // Event Listeners
  $('#addWarehouseQuantity').on('input', function () {
    const quantity = $(this).val();
    if (!isValidQuantity(quantity)) {
      $('#quantityError').show().text(`Invalid quantity. It must be between ${MIN_QUANTITY} and ${MAX_QUANTITY}, and cannot be a decimal.`);
      disableSubmitButton('#addStockForm', true); // Disable button immediately
    } else {
      resetErrorMessage('#quantityError');
      const price = $('#addStockPrice').val();
      if (isValidPrice(price)) {
        disableSubmitButton('#addStockForm', false); // Enable button if both fields are valid
      }
    }
  });

  $('#addStockPrice').on('input', function () {
    const price = $(this).val();
    if (!isValidPrice(price)) {
      $('#priceError').show().text(`Invalid price. It must be more than 1 and less than or equal to 900,000.`);
      disableSubmitButton('#addStockForm', true); // Disable button immediately
    } else {
      resetErrorMessage('#priceError');
      const quantity = $('#addWarehouseQuantity').val();
      if (isValidQuantity(quantity)) {
        disableSubmitButton('#addStockForm', false); // Enable button if both fields are valid
      }
    }
    let value = $(this).val();
    // Match two decimal places using a regex
    if (!/^\d+(\.\d{0,2})?$/.test(value)) {
        $(this).val(value.slice(0, -1)); // Remove invalid input
    }
  });

  $('#addStockImage').change(function (e) {
    handleFileValidation(e.target, '#imageError', '#addStockForm');
  });

  $('#editWarehouseQuantity').on('input', function () {
    validateEditStockForm();
  });

  $('#editStockPrice').on('input', function () {
    const price = $(this).val();
    if (!isValidPrice(price)) {
      $('#editPriceError').show().text('Invalid price. It must be more than 1 and less than or equal to 900,000.');
      disableSubmitButton('#editStockForm', true);
    } else {
      resetErrorMessage('#editPriceError');
      const quantity = $('#editWarehouseQuantity').val();
      if (isValidQuantity(quantity)) {
        disableSubmitButton('#editStockForm', false);
      }
    }

    // Ensure only two decimal places
    if (!/^\d+(\.\d{0,2})?$/.test(price)) {
      $(this).val(price.slice(0, -1)); // Remove invalid input
    }
  });

  $('#editStockImage').change(function (e) {
    handleFileValidation(e.target, '#editStockImageError', '#editStockForm');
  });

  // Form Submission Handlers
  $('#addStockForm').submit(function (e) {
    e.preventDefault();
    if ($('#addStockForm button[type="submit"]').prop('disabled')) {
      Swal.fire({
        title: 'Error',
        text: 'Please fix the errors before submitting.',
        icon: 'error',
        confirmButtonText: 'OK',
      });
      return;
    }
    const formData = new FormData(this);
    $.ajax({
      url: '{{ route('admin.stocks.store') }}',
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function () {
        $('#addStockModal').modal('hide');
        Swal.fire('Success', 'Stock added successfully!', 'success').then(() => location.reload());
      },
      error: function (xhr) {
        Swal.fire('Error', xhr.responseJSON?.error || 'There was an error adding the stock.', 'error');
      },
    });
  });

  $('#editStockForm').submit(function (e) {
    e.preventDefault();
    if ($('#editStockForm button[type="submit"]').prop('disabled')) {
      Swal.fire({
        title: 'Error',
        text: 'Please fix the errors before submitting.',
        icon: 'error',
        confirmButtonText: 'OK',
      });
      return;
    }
    const formData = new FormData(this);
    const stocksID = $('#editStockID').val();
    formData.append('_method', 'PUT');
    $.ajax({
      url: '{{ route('admin.stocks.update', ':stocksID') }}'.replace(':stocksID', stocksID),
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function () {
        $('#editStockModal').modal('hide');
        Swal.fire('Success', 'Stock updated successfully!', 'success').then(() => location.reload());
      },
      error: function (xhr) {
        Swal.fire('Error', xhr.responseJSON?.error || 'There was an error updating the stock.', 'error');
      },
    });
  });

  function containsLink(text) {
    // Regex to detect common URL patterns
    const urlPattern = /(https?:\/\/[^\s]+|www\.[^\s]+|\.[a-z]{2,})/i;
    return urlPattern.test(text);
  }

  function validateStockNameForLinks(inputSelector, errorSelector, formSelector) {
      const stockName = $(inputSelector).val();

      if (containsLink(stockName)) {
          $(errorSelector).show().text('Links or URLs are not allowed in the stock name.');
          disableSubmitButton(formSelector, true);
          return false;
      } else {
          resetErrorMessage(errorSelector);
          return true;
      }
  }

  // Utility function to clear the modal fields and error messages
  function clearModalFields(modalSelector) {
      $(modalSelector).find('input[type="text"], input[type="number"], input[type="file"]').val(''); // Clear input fields
      $(modalSelector).find('small.form-text.text-danger').hide().text(''); // Clear error messages
      disableSubmitButton(modalSelector, false); // Enable the button initially
  }

  // Clear fields and reset state when Add Stock modal is closed
  $('#addStockModal').on('hidden.bs.modal', function () {
      clearModalFields('#addStockModal');
  });

  // Clear fields and reset state when Edit Stock modal is closed
  $('#editStockModal').on('hidden.bs.modal', function () {
      clearModalFields('#editStockModal');
  });

  // Revalidate the stock name field when the Add Stock modal is opened
  $('#addStockModal').on('shown.bs.modal', function () {
      validateStockNameForLinks('#addStockName', '#addStockNameError', '#addStockForm');
  });

  // Revalidate the stock name field when the Edit Stock modal is opened
  $('#editStockModal').on('shown.bs.modal', function () {
      validateStockNameForLinks('#editStockName', '#editStockNameError', '#editStockForm');
  });

  // Validate stock name input on typing
  $('#addStockName').on('input', function () {
      validateStockNameForLinks('#addStockName', '#addStockNameError', '#addStockForm');
  });

  $('#editStockName').on('input', function () {
      validateStockNameForLinks('#editStockName', '#editStockNameError', '#editStockForm');
  });

  // Stock Deletion
  function confirmDeleteStock(stockID) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '{{ route('admin.stocks.destroy', ':id') }}'.replace(':id', stockID),
          method: 'DELETE',
          data: { _token: '{{ csrf_token() }}' },
          success: function () {
            Swal.fire('Deleted!', 'Stock has been deleted.', 'success').then(() => location.reload());
          },
          error: function () {
            Swal.fire('Error', 'There was an error deleting the stock.', 'error');
          },
        });
      }
    });
  }

  // Filtering Stocks
  function filterStocks() {
    const selectedCategory = $('#categoryFilter').val();
    $('.stock-item').each(function () {
      const stockCategory = $(this).data('category');
      $(this).toggle(selectedCategory === 'all' || stockCategory === selectedCategory);
    });
  }

  // Clear Search
  function clearSearch() {
    $('input[name="query"]').val('');
    $('form').submit();
  }
</script>
</body>
</html>
