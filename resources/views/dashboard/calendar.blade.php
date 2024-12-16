@extends('layouts.app')

@section('title', 'Weekly Schedule')

@section('styles')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <style>
    #calendar {
      height: 100vh;
      width: 100%;
    }
  </style>
@endsection

@section('content')
<div class="container">
    <!-- Dropdown to select spot -->
    <div class="form-group">
        <label for="spotDropdown">Select Parking Spot</label>
        <select id="spotDropdown" class="form-control">
            @foreach($spots as $spot)
                <option value="{{ $spot->spot_id }}" @if($spot->spot_id == $defaultSpot->spot_id) selected @endif>
                    {{ $spot->title }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Calendar -->
    <div id="calendar"></div>

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
  <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="eventForm">
                    <div class="mb-3">
                        <label for="eventDay" class="form-label">Day</label>
                        <input type="text" id="eventDay" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="startTime" class="form-label">Start Time</label>
                        <input type="time" id="startTime" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="endTime" class="form-label">End Time</label>
                        <input type="time" id="endTime" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="deleteEvent" class="btn btn-danger">Delete</button>
                <button type="button" id="saveEvent" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>


</div>


@endsection

@section('scripts')
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/moment/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar;

    // Get the initial spot ID (default spot)
    var initialSpotId = @json($defaultSpot->spot_id);  // Ensure this is correct
    console.log('Initial Spot ID:', initialSpotId); // Debugging

    // Fetch availability for the default spot and configure the calendar
    fetchAvailability(initialSpotId).then(function(availability) {
        console.log('Initial Availability:', availability); // Debugging
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek', // Weekly schedule
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: '' // Remove other view buttons
            },
            themeSystem: 'bootstrap',
            events: mapAvailabilityToEvents(availability),  // Ensure events array is provided, even if empty
            editable: true,
            dateClick: function(info) {
                // Open modal to create a new event
                openModal(info.dateStr, null);
            },
            eventClick: function(info) {
                console.log('Event ID:', info.event.id); // Check if ID is properly fetched
                openModal(info.event.startStr, info.event);
            }
        });

        calendar.render();

        // Update availability when a new spot is selected
        document.getElementById('spotDropdown').addEventListener('change', function () {
            var selectedSpotId = this.value;
            console.log('Selected Spot ID:', selectedSpotId); // Debugging
            fetchAvailability(selectedSpotId).then(function(availability) {
                console.log('Availability Data:', availability);
                calendar.removeAllEvents();
                calendar.addEventSource(mapAvailabilityToEvents(availability));  // Ensure events array is provided
                console.log('Added Events:', mapAvailabilityToEvents(availability));  // Verify the events are properly added
            });
        });
    });

    // Function to fetch availability for a spot
    function fetchAvailability(spotId) {
        console.log('Fetching availability for Spot ID:', spotId); // Debugging
        return fetch(`get-spot-availability/${spotId}`)
            .then(response => response.json())
            .then(data => {
                console.log('Fetched Data:', data); // Debugging
                return data;
            })
            .catch(error => {
                console.error('Error fetching availability:', error); // Debugging
                return [];  // Return empty array if there's an error
            });
    }

    // Function to map availability to FullCalendar events
    function mapAvailabilityToEvents(availability) {
        console.log('Mapping Availability to Events:', availability); // Debugging
        return availability.map(item => {
            // Adjust the start and end times based on the day of the week
            const eventStart = formatEventDate(item.start_time, item.day);
            const eventEnd = formatEventDate(item.end_time, item.day);

            return {
                id: item.availability_id,  // Ensure the event has an ID
                title: 'Available',  // Set the event title
                start: eventStart,   // Set the start date/time
                end: eventEnd,       // Set the end date/time
                backgroundColor: '#0bc2a2',
                borderColor: '#0bc2a2',
                textColor: 'white',  // Make sure the text is readable
            };
        });
    }

    // Function to format the start and end times based on the day of the week
    function formatEventDate(time, dayOfWeek) {
        const now = new Date();
        const dayOffset = dayOfWeek - now.getDay(); // Adjust to the correct day of the week
        now.setDate(now.getDate() + dayOffset); // Adjust the date to match the day of the week

        const eventDate = new Date(now.setHours(time.split(':')[0], time.split(':')[1]));  // Set the hours and minutes based on time
        return eventDate.toISOString();  // FullCalendar expects ISO 8601 format
    }

    // Function to open the modal with event details
    function openModal(dateStr, event) {
        $('#eventModal').modal('show');
        document.getElementById('eventDay').value = new Date(dateStr).toLocaleDateString('en-US', { weekday: 'long' });
        document.getElementById('startTime').value = event ? event.start.toISOString().substring(11, 16) : '';
        document.getElementById('endTime').value = event ? event.end.toISOString().substring(11, 16) : '';

        // Handle save button click
        document.getElementById('saveEvent').onclick = function() {
            var startTime = document.getElementById('startTime').value;
            var endTime = document.getElementById('endTime').value;
            var day = new Date(dateStr).getDay();
            var spotId = document.getElementById('spotDropdown').value;

            if (event) {
                updateAvailability(event.id, spotId, day, startTime, endTime);
            } else {
                // Save new event
                saveAvailability(spotId, day, startTime, endTime);
            }

            $('#eventModal').modal('hide');
        };

        // Handle delete button click
        document.getElementById('deleteEvent').onclick = function() {
            if (event) {
                deleteAvailability(event.id, event.extendedProps.spot_id);
                console.log('Deleted Event:', event.id); 
                $('#eventModal').modal('hide');
            }
        };
    }

    // Function to save new availability
    function saveAvailability(spotId, day, startTime, endTime) {
        fetch('save-availability', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                spot_id: spotId,
                day: day,
                start_time: startTime,
                end_time: endTime
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Saved Data:', data); // Debugging
            calendar.addEvent({
                id: data.availability_id,
                title: 'Available',
                start: formatEventDate(startTime, day),
                end: formatEventDate(endTime, day),
                backgroundColor: '#0bc2a2',
                borderColor: '#0bc2a2',
                textColor: 'white'
            });
        })
        .catch(error => console.error('Error saving availability:', error));
    }

    // Function to update existing availability
    function updateAvailability(id, spotId, day, startTime, endTime) {
        console.log('Updating Availability:', id, spotId, day, startTime, endTime); // Debugging
        fetch('update-availability', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                availability_id: parseInt(id, 10),
                spot_id: spotId,
                day: day,
                start_time: startTime,
                end_time: endTime
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text) });
            }
            return response.json();
        })
        .then(data => {
            console.log('Updated Data:', data); // Debugging
            var event = calendar.getEventById(id);
            event.setStart(formatEventDate(startTime, day));
            event.setEnd(formatEventDate(endTime, day));
        })
        .catch(error => console.error('Error updating availability:', error));
    }

    // Function to delete existing availability
    function deleteAvailability(id, spotId) {
    console.log('Deleting Availability:', id, spotId); // Debugging
    fetch('delete-availability', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            availability_id: parseInt(id, 10),
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => { throw new Error(text) });
        }
        return response.json();
    })
    .then(data => {
        console.log('Deleted Data:', data); 
        var event = calendar.getEventById(id);
        event.remove();
    })
    .catch(error => console.error('Error deleting availability:', error));
}
});

</script>
@endsection