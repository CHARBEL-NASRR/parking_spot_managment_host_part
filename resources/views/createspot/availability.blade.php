<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <title>Set Availability</title>
  <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
  <style>
    .button-group {
      display: flex;
      flex-direction: column;
      gap: 10px;
      align-items: center;
    }
    body {
      display: flex;
      flex-direction: column;
      justify-content: space-between;

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

    header {
        padding: 30px 30px 0px 30px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        width: 100%;
      }


      header img {
        width: 120px; /* Increased logo size */
        height: auto; /* Maintain aspect ratio */
        margin-left: 70px;
      }

      .logo-text {
        color: #16a57f;
        font-family: roboto;
        font-size: 30px;
        margin-bottom: 0px;

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
    .bottom {
        display: flex;
        width: 100%;
        justify-content: space-between;
        padding: 0px 15px 20px 15px;
      }
      .btn-submit {
        align-self: flex-end;
        background-color: #18b98d;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1.2rem;
        margin-top: 20px;
      }

      .btn-submit:hover {
        background-color: #16a57f;
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
<header>
      <img src="{{ asset('images/logo_parkingspot.png') }}" alt="Logo">
      <h1 class="logo-text">Chekka</h1>
    </header>
  <div class="availability-container">
    <h1>Set Availability</h1>
    <p class="subtitle">
      Please specify the availability for the parking spot.
    </p>

    <form id="availabilityForm" method="POST" action="{{ route('availability.save',  $spot->spot_id) }}">
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
        <button type="button" class="btn" onclick="addAvailabilityField()">Add Another Day</button>
      </div>
    </form>
  </div>
  <div class="bottom">
        <button type="button" class="btn-submit back" onclick="history.back()">Back</button>
        <button type="submit" class="btn-submit next" form="availabilityForm">Next</button>
      </div>
</body>
</html>