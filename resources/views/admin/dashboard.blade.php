<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OODS | Admin Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <style>
        @media (max-width: 768px) {
            .small-box {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('/admin/dashboard') }}" class="nav-link">Home</a>
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
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <img src="{{ asset('images/smootea_logo.jpg') }}" alt="SMOOTEA Logo" class="brand-image elevation-3" style="opacity: .8">
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
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ url('/admin/dashboard') }}" class="nav-link active">
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
                        <a href="{{ url('/admin/adminOrderHistory') }}" class="nav-link">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Order History</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-12 mb-4">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $pendingOrders }}</h3>
                                <p>Pending Orders</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ url('/admin/updateOrderStatus') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 mb-4">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalStocks }}</h3>
                                <p>Total Stocks</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-cube"></i>
                            </div>
                            <a href="{{ url('/admin/manageStock') }}" class="small-box-footer">Manage Stock <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 mb-4">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $totalOutlets }}</h3>
                                <p>Registered Outlets</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">---</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-exclamation-triangle"></i> Alerts
                                </h3>
                            </div>
                            <div class="card-body">
                              @if(!empty($alerts))
                                  @foreach($alerts as $alert)
                                      @isset($alert['code'])
                                          @if($alert['code'] === 'NEW_ORDER')
                                              <div class="alert alert-info alert-dismissible fade show" role="alert">
                                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                  </button>
                                                  <h5><i class="icon fas fa-info-circle"></i> New Order!</h5>
                                                  Order ID: {{ $alert['orderId'] }} - {{ $alert['message'] }}
                                              </div>
                                          @elseif($alert['code'] === 'DELIVERY_NOT_UPDATED')
                                              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                  </button>
                                                  <h5><i class="icon fas fa-exclamation-triangle"></i> Delivery Pending Updates!</h5>
                                                  Delivery ID: {{ $alert['deliveryId'] }} - {{ $alert['message'] }}
                                              </div>
                                          @endif
                                      @endisset
                                  @endforeach
                              @else
                                  <p>No alerts to display.</p>
                              @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/adminlte.min.js') }}"></script>

<script>

  function updateCartBadge() {
    var cart = JSON.parse(localStorage.getItem('cart')) || [];
    var totalItems = cart.length; // Change this line to count unique items
    document.getElementById('cart-badge').innerText = totalItems;
  }

  document.addEventListener('DOMContentLoaded', updateCartBadge);
</script>
</body>
</html>
