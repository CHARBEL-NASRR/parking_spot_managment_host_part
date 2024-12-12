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
            <h3>150</h3>
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
            <h3>53</h3>
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
            <h3>44</h3>
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
            <h3>4</h3>
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
              <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
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
            <div id="world-map" style="height: 250px; width: 100%;"></div>
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
    // Fetch revenue data from the backend route
    $.ajax({
        url: '{{ route('dashboard.revenue-data') }}',  // This should match the route you created
        method: 'GET',
        success: function(data) {
            // Assuming the backend returns data in this structure:
            // [{ "date": "2024-12-12", "total": 150 }, ...]
            
            // Extract labels (dates) and revenue data (totals)
            var labels = data.map(function(item) {
                return item.date;
            });
            var revenues = data.map(function(item) {
                return item.total;
            });

            // Create the area chart dynamically with the fetched data
            var ctx = document.getElementById('revenue-chart-canvas').getContext('2d');
            var revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Revenue',
                        data: revenues,
                        backgroundColor: 'rgba(60,141,188,0.2)',
                        borderColor: 'rgba(60,141,188,1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'day',
                                tooltipFormat: 'll',
                                displayFormats: {
                                    day: 'MMM D'
                                }
                            },
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Revenue'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Revenue: $' + context.parsed.y;
                                }
                            }
                        }
                    }
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching revenue data:', error);
        }
    });
});
</script>

@endsection