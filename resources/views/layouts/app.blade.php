<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AdminLTE 3')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    @yield('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('images/logo_parkingspot.png') }}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" id="messagesDropdown">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge" id="newMessagesCount">0</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="messagesDropdownMenu">
          <!-- Messages will be dynamically loaded here -->
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" id="bookingsDropdown">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge" id="newBookingsCount">0</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="bookingsDropdownMenu">
          <!-- Bookings will be dynamically loaded here -->
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="brand-link">
      <img src="{{ asset('images/logo_parkingspot.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Host</span>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        
        <div class="info">
          <a  class="d-block">{{ auth()->user()->name }}</a>
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
            <a href="{{ route('dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('calendar') }}" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Calendar
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a  href="{{route('spots.show')}}"class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
               Listings
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a  href="{{route('profile.show')}}"class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
               Profile
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
<script>
  $(document).ready(function() {
    // Load new messages count from session storage
    var newMessagesCount = sessionStorage.getItem('newMessagesCount') || 0;
    $('#newMessagesCount').text(newMessagesCount);

    $('#messagesDropdown').on('click', function() {
      // Reset the new messages count
      $('#newMessagesCount').text('0');
      sessionStorage.setItem('newMessagesCount', 0);

      // Load the messages
      $.ajax({
        url: '{{ route('notifications.tickets') }}',
        method: 'GET',
        success: function(response) {
          var messagesDropdownMenu = $('#messagesDropdownMenu');
          messagesDropdownMenu.empty();
          response.tickets.forEach(function(ticket) {
            var messageItem = `
              <a href="#" class="dropdown-item">
                <div class="media">
                  <div class="media-body">
                    <h3 class="dropdown-item-title">
                      ${ticket.admin_first_name}
                    </h3>
                    <p class="text-sm">${ticket.response}</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> ${moment(ticket.updated_at).fromNow()}</p>
                  </div>
                </div>
              </a>
              <div class="dropdown-divider"></div>
            `;
            messagesDropdownMenu.append(messageItem);
          });
          messagesDropdownMenu.append('<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>');
        }
      });
    });

    // Fetch the new messages count periodically
    setInterval(function() {
      $.ajax({
        url: '{{ route('notifications.count') }}',
        method: 'GET',
        success: function(response) {
          $('#newMessagesCount').text(response.newMessagesCount);
          sessionStorage.setItem('newMessagesCount', response.newMessagesCount);
        }
      });
    }, 60000); // Every 60 seconds

    // Load new bookings count from session storage
    var newBookingsCount = sessionStorage.getItem('newBookingsCount') || 0;
    $('#newBookingsCount').text(newBookingsCount);

    $('#bookingsDropdown').on('click', function() {
      // Load the bookings
      $.ajax({
        url: '{{ route('bookings.requested') }}',
        method: 'GET',
        success: function(response) {
          var bookingsDropdownMenu = $('#bookingsDropdownMenu');
          bookingsDropdownMenu.empty();
          response.bookings.forEach(function(booking) {
            var bookingItem = `
              <a href="#" class="dropdown-item" data-toggle="modal" data-target="#bookingModal" data-id="${booking.booking_id}" data-guest="${booking.guest_name}" data-start="${booking.start_time}" data-end="${booking.end_time}" data-price="${booking.total_price}">
                <div class="media">
                  <div class="media-body">
                    <h3 class="dropdown-item-title">
                      ${booking.guest_name}
                    </h3>
                    <p class="text-sm">Start: ${booking.start_time}</p>
                    <p class="text-sm">End: ${booking.end_time}</p>
                    <p class="text-sm">Price: ${booking.total_price}</p>
                  </div>
                </div>
              </a>
              <div class="dropdown-divider"></div>
            `;
            bookingsDropdownMenu.append(bookingItem);
          });
          bookingsDropdownMenu.append('<a href="#" class="dropdown-item dropdown-footer">See All Bookings</a>');
        }
      });
    });

    // Handle delete booking
    $('#bookingsDropdownMenu').on('click', '.dropdown-item', function(event) {
  event.preventDefault();

  // Get booking data from the clicked item
  var guestName = $(this).data('guest');
  var startTime = $(this).data('start');
  var endTime = $(this).data('end');
  var totalPrice = $(this).data('price');
  var bookingId = $(this).data('id');

  $('#guestName').text(guestName);
  $('#startTime').text(startTime);
  $('#endTime').text(endTime);
  $('#totalPrice').text(totalPrice);

  $('#acceptBooking').data('id', bookingId);
  $('#rejectBooking').data('id', bookingId);

  $('#bookingModal').modal('show');
});

    // Handle accept booking
    $('#acceptBooking').on('click', function() {
      var bookingId = $(this).data('id');
      $.ajax({
        url: '{{ route('bookings.update', '') }}/' + bookingId,
        method: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          status: 'accepted'
        },
        success: function(response) {
          $('#bookingModal').modal('hide');
        }
      });
    });

    // Handle reject booking
    $('#rejectBooking').on('click', function() {
      var bookingId = $(this).data('id');
      $.ajax({
        url: '{{ route('bookings.update', '') }}/' + bookingId,
        method: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          status: 'rejected'
        },
        success: function(response) {
          $('#bookingModal').modal('hide');
        }
      });
    });

    // Fetch the new bookings count periodically
    setInterval(function() {
      $.ajax({
        url: '{{ route('bookings.requested') }}',
        method: 'GET',
        success: function(response) {
          $('#newBookingsCount').text(response.bookings.length);
          sessionStorage.setItem('newBookingsCount', response.bookings.length);
        }
      });
    }, 60000); // Every 60 seconds
  });


</script>

<!-- Modal for displaying full booking details -->
<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bookingModalLabel">Booking Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Guest Name:</strong> <span id="guestName"></span></p>
        <p><strong>Start Time:</strong> <span id="startTime"></span></p>
        <p><strong>End Time:</strong> <span id="endTime"></span></p>
        <p><strong>Total Price:</strong> $<span id="totalPrice"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="acceptBooking">Accept</button>
        <button type="button" class="btn btn-danger" id="rejectBooking">Reject</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


@yield('scripts')
</body>
</html>