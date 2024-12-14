<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Set Availability</title>
  <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
  <style>
    .button-group {
      display: flex;
      flex-direction: column;
      gap: 10px;
      align-items: center;
    }

    .availability-container {
      max-width: 450px;
      margin: 0 auto;
      padding: 30px;
      background-color: #ffffff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 15px;
    }

    h1 {
      text-align: center;
      font-size: 24px;
      margin-bottom: 20px;
    }

    .logo {
      position: absolute; /* Position the logo absolutely */
      top: 40px; /* Adjust as needed */
      left: 40px; /* Adjust as needed */
    }

    .logo img {
      width: 100px; /* Increased logo size */
      height: auto; /* Maintain aspect ratio */
    }

    .form-group label {
      font-weight: bold;
    }

    .form-control {
      width: 100%;
      padding: 12px;
      border-radius: 4px;
      border: 1px solid #ccc;
      margin-bottom: 15px;
      font-size: 16px;
    }

    .btn {
      flex: 1;
      padding: 12px;
      background: #0bc2a2;
      color: white;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.2s;
      width: 100%;
    }

    .btn:hover {
      background: #00b396;
    }

    .add-button {
      background: #f0ad4e;
      color: white;
    }

    .add-button:hover {
      background: #ec971f;
    }

    .login-link {
      margin-top: 24px;
      font-size: 14px;
      color: #666;
      text-align: center;
    }

    .login-link a {
      color: #0bc2a2;
      text-decoration: none;
    }

    .login-link a:hover {
      text-decoration: underline;
    }

    .subtitle {
      font-size: 20px; /* Increase font size */
      text-align: center; /* Center the text */
      margin-bottom: 20px; /* Add some space below */
      color: #333; /* Optional: change text color */
    }
  </style>
  <script>
    function addAvailabilityField() {
      const container = document.getElementById('availability-fields');
      const newField = document.createElement('div');
      newField.classList.add('availability-field');
      newField.innerHTML = `
        <div class="form-group">
          <label for="day">Day:</label>
          <input type="text" class="form-control" name="day[]" required>
        </div>
        <div class="form-group">
          <label for="start_time_availability">Start Time:</label>
          <input type="time" class="form-control" name="start_time_availability[]" required>
        </div>
        <div class="form-group">
          <label for="end_time_availability">End Time:</label>
          <input type="time" class="form-control" name="end_time_availability[]" required>
        </div>
      `;
      container.appendChild(newField);
    }
  </script>
</head>
<body>
  <div class="logo">
    <img src="{{ asset('images/logo_parkingspot.png') }}" alt="Logo">
  </div>
  <div class="availability-container">
    <h1>Set Availability</h1>
    <p class="subtitle">
      Please specify the availability for the parking spot.
    </p>

    <form method="POST" action="{{ route('availability.save',  $spot->spot_id) }}">
        @csrf
        <input type="hidden" name="spot_id" value="{{ $spot->spot_id }}">

      <div id="availability-fields">
        <div class="availability-field">
          <div class="form-group">
            <label for="day">Day :</label>
            <input type="text" class="form-control" name="day[]" required>
          </div>
          <div class="form-group">
            <label for="start_time_availability">Start Time:</label>
            <input type="time" class="form-control" name="start_time_availability[]" required>
          </div>
          <div class="form-group">
            <label for="end_time_availability">End Time:</label>
            <input type="time" class="form-control" name="end_time_availability[]" required>
          </div>
        </div>
      </div>
      <div class="button-group">
        <button type="button" class="add-button" onclick="addAvailabilityField()">Add Another Day</button>
        <button type="submit" class="btn">Submit</button>
      </div>
    </form>
  </div>
</body>
</html>