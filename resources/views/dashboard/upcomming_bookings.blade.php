@extends('layouts.app')

@section('title', 'Upcoming Bookings')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <style>
        .table-wrapper {
            padding: 0;
            margin: 0;
        }

        .table {
            width: 100%;
            table-layout: auto;
        }

        .content-header {
            margin-top: 20px; /* Add margin to create space between the header and navbar */
        }
    </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
       
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Upcoming Bookings</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Guest Name</th>
                                        <th>Spot Address</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="bookings-table-body">
                                    <!-- Dynamic content will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('{{ route('upcoming.bookings') }}')
            .then(response => response.json())
            .then(data => {
                const bookingsTableBody = document.getElementById('bookings-table-body');
                bookingsTableBody.innerHTML = '';

                data.bookings.forEach((booking, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${booking.guest_name}</td>
                        <td>${booking.spot_address}</td>
                        <td>${booking.start_time}</td>
                        <td>${booking.end_time}</td>
                        <td>${booking.status}</td>
                    `;
                    bookingsTableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching upcoming bookings:', error));
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

@endsection