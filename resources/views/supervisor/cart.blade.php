<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OODS | Cart</title>

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
  <style>
    .cart-table {
      width: 100%;
      margin: 20px 0;
      border-collapse: collapse;
    }
    .cart-table th, .cart-table td {
      border: 1px solid #ddd;
      padding: 8px;
    }
    .cart-table th {
      background-color: #f2f2f2;
      text-align: left;
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
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
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
            <a href="{{ url('#') }}" class="nav-link active">
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

  <div class="content-wrapper p-3">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cart</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <table class="cart-table">
          <thead>
            <tr>
              <th>Item</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="cartItems">
            <!-- Cart items will be injected here -->
          </tbody>
        </table>
        <div class="d-flex justify-content-between">
          <button class="btn btn-secondary" onclick="clearCart()">Clear Cart</button>
          <h5 id="totalPrice">Total: RM 0.00</h5>
          <button class="btn btn-primary" onclick="checkout()">Checkout</button>
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
                <h5 class="modal-title" id="successModalLabel">Checkout Successful</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Order Placed Successfully
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
      <div class="modal-body" id="errorMessage">
        Your cart is empty. Please add items before checking out.
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
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>
<script>
  function validateCart() {
    var cart = JSON.parse(localStorage.getItem('cart')) || [];
    var isValid = true;

    cart.forEach((item, index) => {
        const quantityInput = document.querySelector(`#quantity-${index}`);
        const errorText = document.querySelector(`#error-${index}`);

        const quantity = parseFloat(item.quantity); // Parse as a float to check for decimal values.

        if (!quantity || quantity <= 0) {
            errorText.innerText = "Quantity must be greater than zero.";
            errorText.style.color = "red";
            isValid = false;
        } else if (!Number.isInteger(quantity)) {
            errorText.innerText = "Quantity must be a whole number.";
            errorText.style.color = "red";
            isValid = false;
        } else if (quantity > 50) {
            errorText.innerText = "Quantity too many. Maximum allowed is 50.";
            errorText.style.color = "red";
            isValid = false;
        } else {
            errorText.innerText = ""; // Clear error message if valid.
        }
    });

    document.querySelector("button[onclick='checkout()']").disabled = !isValid;
  }

function loadCart() {
    var cart = JSON.parse(localStorage.getItem('cart')) || [];
    var cartItems = document.getElementById('cartItems');
    cartItems.innerHTML = '';
    var totalPrice = 0;

    cart.forEach((item, index) => {
        var itemTotal = item.stockPrice * item.quantity;
        totalPrice += itemTotal;

        var row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.stockName}</td>
            <td>RM ${item.stockPrice.toFixed(2)}</td>
            <td>
                <input id="quantity-${index}" type="number" min="1" value="${item.quantity}" 
                    onchange="updateQuantity(${index}, this.value)">
                <div id="error-${index}" style="font-size: 12px; color: red;"></div>
            </td>
            <td>RM ${itemTotal.toFixed(2)}</td>
            <td>
                <button class="btn btn-danger btn-sm" onclick="removeFromCart(${index})">Remove</button>
            </td>
        `;
        cartItems.appendChild(row);
    });

    document.getElementById('totalPrice').innerText = `Total: RM ${totalPrice.toFixed(2)}`;
    updateCartBadge();
    validateCart(); // Validate the cart after loading
}

function updateQuantity(index, quantity) {
    var cart = JSON.parse(localStorage.getItem('cart')) || [];
    // Update the cart with the user-provided quantity without altering invalid values
    cart[index].quantity = parseInt(quantity) || quantity; // Allow invalid inputs (empty or non-numeric) to persist
    localStorage.setItem('cart', JSON.stringify(cart));
    loadCart(); // Reload the cart to validate and reflect changes
}
function removeFromCart(index) {
    var cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    loadCart();
}
function clearCart() {
    localStorage.removeItem('cart');
    loadCart();
}

function updateCartBadge() {
    var cart = JSON.parse(localStorage.getItem('cart')) || [];
    var totalItems = cart.length; // Change this line to count unique items
    document.getElementById('cart-badge').innerText = totalItems;
}

function checkout() {
    var cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (cart.length === 0) {
        showErrorModal('Your cart is empty. Please add items before checking out.');
        return;
    }

    fetch('{{ route('checkout') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ cart: cart })
    })
        .then(response => {
            if (!response.ok) throw new Error('Failed to checkout. Please try again.');
            return response.json();
        })
        .then(data => {
            if (data.message) {
                $('#successModal').modal('show');
                localStorage.removeItem('cart');
                loadCart();
            } else if (data.error) {
                showErrorModal(data.error);
            }
        })
        .catch(error => {
            showErrorModal('An error occurred during checkout. Please try again later.');
        });
}

function showErrorModal(message) {
    document.getElementById('errorMessage').innerText = message;
    $('#errorModal').modal('show');
}

document.addEventListener('DOMContentLoaded', loadCart);
</script>

</body>
</html>
