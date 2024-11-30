@extends('layouts.app')

@section('title', 'Calendar')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="stylesheet" href="{{ asset('dist/fullcalendar/calander.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard/calander.css') }}">
@endsection

@section('content')
<div id="calendar-container">
    <div id="calendar"></div>
    <div id="small-calendar-container">
        <h5>Exception Dates</h5>
        <div id="small-calendar"></div>
    </div>
    <div id="dropdown-container">
        <h5>Select Spot</h5>
        <form method="GET" action="{{ route('calendar') }}">
            <select class="form-select" name="spot_id" onchange="this.form.submit()">
                @foreach($spots as $spot)
                    <option value="{{ $spot->spot_id }}" {{ $selected_spot_id == $spot->spot_id ? 'selected' : '' }}>
                        {{ $spot->title }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Booking Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeModalBtn"></button>
            </div>
            <div class="modal-body">
                <form id="bookingForm" method="POST" action="{{ route('calendar.save') }}">
                    @csrf
                    <input type="hidden" name="spot_id" id="spot-id" value="{{ $selected_spot_id }}">
                    <input type="hidden" name="id" id="availability-id">
                    <input type="hidden" name="start_time_availability" id="start-time">
                    <input type="hidden" name="end_time_availability" id="end-time">
                    <input type="hidden" name="day" id="day"> <!-- Hidden input for the day -->
                    <div class="mb-3">
                        <label for="start-time-display" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="start-time-display" required>
                    </div>
                    <div class="mb-3">
                        <label for="end-time-display" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="end-time-display" required>
                    </div>
                </form>
                <form id="deleteForm" method="POST" action="{{ route('calendar.delete') }}">
                    @csrf
                    <input type="hidden" name="id" id="delete-id">
                    <input type="hidden" name="spot_id" id="delete-spot-id" value="{{ $selected_spot_id }}">
                </form>
                <form id="updateForm" method="POST" action="{{ route('calendar.update') }}">
                    @csrf
                    <input type="hidden" name="spot_id" id="update-spot-id" value="{{ $selected_spot_id }}">
                    <input type="hidden" name="id" id="update-id">
                    <input type="hidden" name="start_time_availability" id="update-start-time">
                    <input type="hidden" name="end_time_availability" id="update-end-time">
                    <input type="hidden" name="day" id="update-day">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
                <button type="button" id="deleteBtn" class="btn btn-danger">Delete</button>
                <button type="button" id="saveBtn" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            var selectedSpotId = @json($selected_spot_id);
            var events = @json($events) || []; // Ensure events is an array even if empty

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'agendaWeek',
                },
                defaultView: 'agendaWeek',
                firstDay: 1, 
                columnFormat: 'ddd', // Display only day names (Mon, Tue, etc.)
                events: events,
                selectable: true,
                selectHelper: true,
                select: function(start, end, allDay) {
                    $('#start-time').val(start.format('HH:mm:ss'));
                    $('#end-time').val(end.format('HH:mm:ss'));
                    $('#start-time-display').val(start.format('HH:mm'));
                    $('#end-time-display').val(end.format('HH:mm'));
                    $('#availability-id').val('');
                    $('#day').val(start.format('YYYY-MM-DD'));
                    $('#bookingForm').attr('action', '{{ route('calendar.save') }}');
                    $('#bookingModal').modal('show');
                },
                editable: true,
                eventClick: function(event) {
                    $('#start-time').val(moment(event.start).format('HH:mm:ss'));
                    $('#end-time').val(moment(event.end).format('HH:mm:ss'));
                    $('#start-time-display').val(moment(event.start).format('HH:mm'));
                    $('#end-time-display').val(moment(event.end).format('HH:mm'));
                    $('#availability-id').val(event.id);
                    $('#day').val(moment(event.start).format('YYYY-MM-DD'));
                    $('#updateForm').attr('action', '{{ route('calendar.update') }}');
                    $('#update-id').val(event.id);
                    $('#update-start-time').val(moment(event.start).format('HH:mm:ss'));
                    $('#update-end-time').val(moment(event.end).format('HH:mm:ss'));
                    $('#update-day').val(moment(event.start).format('YYYY-MM-DD'));

                    $('#bookingModal').modal('show');
                },
                selectAllow: function(selectInfo) {
                    return true; // Allow selection of past dates
                },
                dayRender: function(date, cell) {
                    if (moment().diff(date, 'days') > 0) {
                        cell.addClass('fc-past');
                    }
                }
            });

            // Initialize the small calendar
            $("#small-calendar").datepicker();

            $("#deleteBtn").on('click', function() {
                $('#delete-id').val($('#availability-id').val());
                $('#deleteForm').submit();
            });

            $("#saveBtn").on('click', function() {
                // Format the time inputs before submitting the form
                var startTime = $('#start-time-display').val();
                var endTime = $('#end-time-display').val();

                // Check if end time is earlier than start time
                if (endTime <= startTime) {
                    alert("End time must be later than start time.");
                    return;
                }

                $('#start-time').val(startTime + ':00');
                $('#end-time').val(endTime + ':00');

                if ($('#availability-id').val()) {
                    $('#updateForm').submit();
                } else {
                    $('#bookingForm').submit();
                }
            });

            // Ensure the modal closes when the "X" or "Cancel" button is pressed
            $('#closeModalBtn, #cancelBtn').on('click', function() {
                $('#bookingModal').modal('hide');
            });

            $('#bookingModal').on('hidden.bs.modal', function () {
                $('#bookingForm')[0].reset();
                $('#updateForm')[0].reset();
                $('#deleteForm')[0].reset();
            });

            $('.fc-event').css('font-size', '13px');
            $('.fc-event').css('width', '100%'); 
            $('.fc-event').css('border-radius', '0'); 

            // Handle spot selection change
            $('#spotSelector').on('change', function() {
                var spotId = $(this).val();
                window.location.href = '{{ route('calendar') }}?spot_id=' + spotId;
            });
        });
    </script>
@endsection