<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>OODS | View Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

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
    .quantity-input {
      display: flex;
      align-items: center;
    }
    .quantity-input input {
      text-align: center;
      max-width: 60px;
      margin: 0 5px;
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
      margin-bottom: 20px;
      width: 200px;
      margin-right: 700px;
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
    .button-group {
      display: flex;
      justify-content: space-between;
      gap: 3px;
    }
    .update-stock-btn {
      background-color: #28a745;
      border-color: #28a745;
      color: white;
    }
  </style>
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
        <a href="{{ url('/supervisor/dashboard') }}" class="nav-link">Home</a>
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
          <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </li>
    </ul>
  </nav>

  <!-- Sidebar -->
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
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
          <li class="nav-item">
            <a href="{{ url('/supervisor/dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('#') }}" class="nav-link active">
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
            <a href="{{ url('/supervisor/orderStatus') }}" class="nav-link">
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
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper p-3">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>View Stocks</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="main-container">
          <div class="filter-container">
            <select id="categoryFilter" class="form-control" onchange="filterStocks()">
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
              @php
                // Get the first outlet quantity (if any)
                $outletQuantity = $stock->outlets->first()->stocksQuantity ?? 0;

                // Check if the stock is considered "new" (quantity is 0)
                $isNew = $outletQuantity == 0;
              @endphp

              <div class="col-md-4 stock-item" data-category="{{ $stock->category }}">
                <div class="stock-container">
                  <h5>
                    <b>{{ $stock->stocksName }}</b>
                    @if($isNew)
                      <span class="badge badge-warning">New</span>
                    @endif
                  </h5>
                  <div class="d-flex">
                    <img src="{{ asset($stock->image) }}" alt="{{ $stock->stocksName }}" class="stock-image">
                    <div class="stock-info">
                      <p><strong>Stock ID:</strong> {{ $stock->stocksID }}</p>
                      <p><strong>Outlet Quantity:</strong> {{ $outletQuantity }}</p>
                      <p><strong>Price:</strong> RM {{ number_format($stock->price, 2) }}</p>
                    </div>
                  </div>

                  <div class="quantity-input mt-3">
                    <button class="btn btn-outline-secondary btn-sm" onclick="this.nextElementSibling.stepDown()">-</button>
                    <input type="number" min="1" value="1">
                    <button class="btn btn-outline-secondary btn-sm" onclick="this.previousElementSibling.stepUp()">+</button>
                  </div><br>

                  <div class="button-group mt-8">
                    <button class="btn btn-primary" 
                      onclick="addToCart(this, {{ $stock->stocksID }}, '{{ $stock->stocksName }}', {{ $stock->price }}, {{ $outletQuantity }})">
                      Add to Cart
                    </button>

                    <!-- Disable the Update Quantity button if the stock is new (quantity is 0) -->
                    <button class="btn btn-success update-stock-btn" 
                      @if($isNew) disabled @endif
                      onclick="openUpdateStockModal('{{ $stock->stocksID }}', '{{ $stock->stocksName }}', {{ $outletQuantity }})">
                      Update Quantity
                    </button>
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

  <!-- Update Stock Modal -->
  <div class="modal fade" id="updateStockModal" tabindex="-1" role="dialog" aria-labelledby="updateStockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateStockModalLabel">Update Stock Quantity</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="updateStockForm">
            @csrf
            <input type="hidden" id="stockID" name="stockID">
            <div class="form-group">
              <label for="stockName">Stock Name</label>
              <input type="text" class="form-control" id="stockName" name="stockName" readonly>
            </div>
            <div class="form-group">
              <label for="stockQuantity">Stock Quantity</label>
              <input type="number" class="form-control" id="stockQuantity" name="stockQuantity" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Notification Alert -->
  <div class="alert alert-success" id="itemAddedAlert" role="alert">
    Item Added!
  </div>

  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('js/adminlte.min.js') }}"></script>
  <!-- SweetAlert2 -->
  <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

  <!-- Page specific script -->
  <script>
    function filterStocks() {
      var category = document.getElementById('categoryFilter').value;
      var items = document.getElementsByClassName('stock-item');
      for (var i = 0; i < items.length; i++) {
        if (category == 'all' || items[i].getAttribute('data-category') == category) {
          items[i].style.display = 'block';
        } else {
          items[i].style.display = 'none';
        }
      }
    }

    function openUpdateStockModal(stockID, stockName, stockQuantity) {
      $('#stockID').val(stockID);
      $('#stockName').val(stockName);
      $('#stockQuantity').val(stockQuantity);
      $('#updateStockModal').modal('show');
    }

    // Submit the update stock form
    $('#updateStockForm').on('submit', function(e) {
      e.preventDefault();
      var form = $(this);

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        url: '{{ route('supervisor.updateStocks') }}',
        method: 'POST',
        data: form.serialize(),
        success: function(response) {
          $('#updateStockModal').modal('hide');
          Swal.fire({
            icon: 'success',
            title: 'Stock Updated',
            text: response.message
          }).then(function() {
            location.reload(); // Reload the page to reflect changes
          });
        },
        error: function(response) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'There was an error updating the stock.'
          });
        }
      });
    });

    function addToCart(button, stockID, stockName, stockPrice, stockQuantity) {
      // Get the quantity input related to this button
      var quantityInput = button.closest('.stock-container').querySelector('input[type="number"]');
      var quantity = parseInt(quantityInput.value);

      // Check if quantity is invalid (empty, negative, or greater than 50)
      if (isNaN(quantity) || quantity <= 0 || quantity > 50) {
        // Show error message
        const errorText = document.createElement('p');
        errorText.classList.add('text-danger', 'quantity-error');
        errorText.innerText = isNaN(quantity)
          ? 'Please enter a valid quantity!'
          : quantity <= 0
          ? 'Quantity must be a positive number!'
          : 'Quantity too many! Maximum allowed is 50.';
        
        // Check if the error message is already displayed
        const stockContainer = button.closest('.stock-container');
        if (!stockContainer.querySelector('.quantity-error')) {
          stockContainer.appendChild(errorText);
        }
        
        // Disable the Add to Cart button
        button.disabled = true;
        return;
      }

      // If valid quantity, remove any existing error messages and enable the button
      const errorText = button.closest('.stock-container').querySelector('.quantity-error');
      if (errorText) errorText.remove();
      button.disabled = false;

      // Get cart from localStorage or initialize an empty array if it doesn't exist
      var cart = JSON.parse(localStorage.getItem('cart')) || [];

      // Check if the item already exists in the cart
      var existingItem = cart.find(item => item.stockID === stockID);

      if (existingItem) {
        existingItem.quantity += quantity; // If item exists, update the quantity
      } else {
        cart.push({ stockID, stockName, stockPrice, quantity, stockQuantity }); // If new item, add it to cart
      }

      // Save updated cart back to localStorage
      localStorage.setItem('cart', JSON.stringify(cart));

      // Update the cart badge (assuming you have a function to handle that)
      updateCartBadge();

      // Show an alert for feedback to the user
      var alert = document.getElementById('itemAddedAlert');
      if (alert) {
        alert.style.display = 'block';
        setTimeout(function() {
          alert.style.display = 'none';
        }, 2000);
      }
    }

    // Event listener to update button state and error message dynamically
    document.addEventListener('input', function(e) {
      if (e.target && e.target.type === 'number') {
        const quantity = parseInt(e.target.value);
        const stockContainer = e.target.closest('.stock-container');
        const addButton = stockContainer.querySelector('button.btn-primary');
        const errorText = stockContainer.querySelector('.quantity-error');

        if (isNaN(quantity) || quantity <= 0 || quantity > 50) {
          // Show error and disable button
          if (!errorText) {
            const errorMessage = document.createElement('p');
            errorMessage.classList.add('text-danger', 'quantity-error');
            errorMessage.innerText = isNaN(quantity)
              ? 'Please enter a valid quantity!'
              : quantity <= 0
              ? 'Quantity must be a positive number!'
              : 'Quantity too many! Maximum allowed is 50.';
            stockContainer.appendChild(errorMessage);
          }
          addButton.disabled = true;
        } else {
          // Remove error and enable button
          if (errorText) errorText.remove();
          addButton.disabled = false;
        }
      }
    });

    function updateCartBadge() {
    var cart = JSON.parse(localStorage.getItem('cart')) || [];
    var totalItems = cart.length; // Change this line to count unique items
    document.getElementById('cart-badge').innerText = totalItems;
  }

    document.addEventListener('DOMContentLoaded', updateCartBadge);

    function clearSearch() {
        const searchInput = document.querySelector('input[name="query"]');
        searchInput.value = '';
        searchInput.closest('form').submit(); // Reload the page with all stocks
    }
  </script>
</body>
</html>
