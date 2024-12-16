@extends('layouts.app')

@section('title', 'Dashboard')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
@endsection

@section('content')
<div class="content-header">
  
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3 id="income-per-month">-</h3>
            <p>Income per month</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3 id="income-per-day">-</h3>
            <p>Income per day</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3 id="deals-completed">-</h3>
            <p>Deals completed</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3 id="overall-rating">-</h3>
            <p>Overall rating /5</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-7 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-chart-pie mr-1"></i>
              Revenue
            </h3>
            <div class="card-tools">
              <ul class="nav nav-pills ml-auto">
                <li class="nav-item">
                  <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                </li>
              </ul>
            </div>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content p-0">
              <!-- Morris chart - Sales -->
              <div class="chart tab-pane active" id="revenue-chart"
                   style="position: relative; height: 300px;">
                  <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
               </div>
            </div>
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </section>
      <!-- /.Left col -->
      <!-- right col (We are only adding the ID to make the widgets sortable)-->
      <section class="col-lg-5 connectedSortable">
        <!-- Map card -->
        <div class="card bg-gradient-primary">
          <div class="card-header border-0">
            <h3 class="card-title">
              <i class="fas fa-map-marker-alt mr-1"></i>
               Last booking spots
            </h3>
            <!-- card tools -->
            <div class="card-tools">
              <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                <i class="far fa-calendar-alt"></i>
              </button>
              <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
            <!-- /.card-tools -->
          </div>
          <div class="card-body">
            <!-- Bookings will be dynamically inserted here -->
            <div id="last-bookings-container" class="list-group">
              <!-- Placeholder for bookings -->
              <p>Loading bookings...</p>
            </div>
          </div>
          <!-- /.card-body-->
          <div class="card-footer bg-transparent">
            <div class="row">
              <div class="col-4 text-center">
                <div id="sparkline-1"></div>
                <div class="text-white">Visitors</div>
              </div>
              <!-- ./col -->
              <div class="col-4 text-center">
                <div id="sparkline-2"></div>
                <div class="text-white">Online</div>
              </div>
              <!-- ./col -->
              <div class="col-4 text-center">
                <div id="sparkline-3"></div>
                <div class="text-white">Sales</div>
              </div>
              <!-- ./col -->
            </div>
            <!-- /.row -->
          </div>
        </div>
        <!-- /.card -->
      </section>
      <!-- right col -->
    </div>
    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('scripts')
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>

<script>
$(document).ready(function() {

    // Function to format date
    function formatDate(dateString) {
        return moment(dateString).format('MMMM D, YYYY h:mm A');
    }

    // Fetch last bookings
    $.ajax({
        url: '{{ route('dashboard.last-bookings') }}',
        method: 'GET',
        success: function(response) {
            // Clear any existing content
            $('#last-bookings-container').empty();

            // Check if bookings exist
            if (!response.bookings || response.bookings.length === 0) {
                $('#last-bookings-container').html('<p>No recent bookings</p>');
                return;
            }

            // Create bookings list
            response.bookings.forEach(function(booking) {
                var bookingItem = `
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">${booking.guest_name} - ${booking.spot_title}</h5>
                            <small>${formatDate(booking.created_at)}</small>
                        </div>
                        <p class="mb-1">
                            Status: ${booking.status} | 
                            Price: $${parseFloat(booking.total_price).toFixed(2)}
                        </p>
                    </div>
                `;
                $('#last-bookings-container').append(bookingItem);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching last bookings:', error);
            $('#last-bookings-container').html('<p>Error loading bookings</p>');
        }
    });

    // Revenue Chart
    $.ajax({
        url: '{{ route('dashboard.revenue-data') }}',
        method: 'GET',
        success: function(data) {
            // If no data, handle empty state
            if (data.length === 0) {
                $('#revenue-chart-canvas').html('<p>No revenue data available</p>');
                return;
            }

            // Process data to create cumulative revenue
            let cumulativeRevenue = [];
            let runningTotal = 0;
            let labels = [];

            // Sort data by date to ensure correct cumulative calculation
            data.sort((a, b) => new Date(a.date) - new Date(b.date));

            // Calculate cumulative revenue
            data.forEach(item => {
                runningTotal += parseFloat(item.total);
                labels.push(moment(item.date).format('YYYY-MM-DD'));
                cumulativeRevenue.push(runningTotal);
            });

            // Create the chart
            var ctx = document.getElementById('revenue-chart-canvas').getContext('2d');
            var revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Cumulative Revenue',
                        data: cumulativeRevenue,
                        backgroundColor: 'rgba(60,141,188,0.2)',
                        borderColor: 'rgba(60,141,188,1)',
                        borderWidth: 2,
                        fill: true,
                        pointRadius: 5,
                        pointBackgroundColor: 'rgba(60,141,188,1)',
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Cumulative Revenue ($)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toFixed(2);
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Total Revenue: $' + context.parsed.y.toFixed(2);
                                }
                            }
                        }
                    }
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching revenue data:', error);
            $('#revenue-chart-canvas').html('<p>Error loading revenue data</p>');
        }
    });

    function fetchMonthlyIncome() {
        $.ajax({
            url: '{{ route('dashboard.monthly-income') }}',
            method: 'GET',
            success: function(response) {
                $('#income-per-month').text('$' + response.toFixed(2));
            },
            error: function() {
                $('#income-per-month').text('Error');
            }
        });
    }

    // Function to fetch daily income
    function fetchDailyIncome() {
        $.ajax({
            url: '{{ route('dashboard.daily-income') }}',
            method: 'GET',
            success: function(response) {
                $('#income-per-day').text('$' + response.toFixed(2));
            },
            error: function() {
                $('#income-per-day').text('Error');
            }
        });
    }

    // Function to fetch deals completed
    function fetchDealsCompleted() {
        $.ajax({
            url: '{{ route('dashboard.deals-completed') }}',
            method: 'GET',
            success: function(response) {
                $('#deals-completed').text(response);
            },
            error: function() {
                $('#deals-completed').text('Error');
            }
        });
    }


    // Function to fetch overall rating
    function fetchOverallRating() {
        $.ajax({
            url: '{{ route('dashboard.overall-rating') }}',
            method: 'GET',
            success: function(response) {
                $('#overall-rating').text(response.toFixed(1));
            },
            error: function() {
                $('#overall-rating').text('Error');
            }
        });
    }

    // Load all stats
    fetchMonthlyIncome();
    fetchDailyIncome();
    fetchDealsCompleted();
    fetchOverallRating();
});
</script>
@endsection