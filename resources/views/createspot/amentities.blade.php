<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Select Amenities</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* Existing styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f9f9f9;
    }

    .container {
        width: 80%;
        max-width: 800px;
        text-align: center;
    }

    .logo img {
        width: 50px;
        height: 50px;
        margin: 20px 0; /* Adjusted for better positioning */
    }

    .content {
        background-color: #fff;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .amenities-list {
        margin: 20px 0;
    }

    .amenity-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .amenity-item input[type="checkbox"] {
        margin-right: 10px;
        width: 20px;
        height: 20px;
    }

    footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 10px;
    }

    footer .btn {
        background: none;
        border: 1px solid #ccc;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
    }

    footer .btn.back {
        color: #555;
    }

    footer .btn.next {
        background-color: #ddd;
        color: #aaa;
    }

    footer .btn.next.active {
        background-color: #000;
        color: #fff;
        cursor: pointer;
    }

    footer .btn:hover:not(.next:disabled) {
        background-color: #0bc2a2;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-success {
        color: #3c763d;
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }

    .alert-danger {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
    }
  </style>
</head>
<body>
  <div class="container">
    <header class="header">
      <div class="logo">
        <img src="{{ asset('images/logo_parkingspot.png') }}" alt="Logo">
      </div>
    </header>

    <div class="content">
      <h1 class="title">Which of these are available at your spot?</h1>

      <!-- Display flash messages -->
      @if (session('message'))
        <div class="alert alert-success">
          {{ session('message') }}
        </div>
      @endif

      @if (session('error'))
        <div class="alert alert-danger">
          {{ session('error') }}
        </div>
      @endif

      <form id="amenitiesForm" action="{{ route('amenities.save') }}" method="POST">
        @csrf

        <div class="amenities-list">
          <div class="amenity-item">
            <input type="checkbox" id="isCovered" name="is_covered">
            <label for="isCovered">Covered Parking</label>
          </div>
          <div class="amenity-item">
            <input type="checkbox" id="hasSecurity" name="has_security">
            <label for="hasSecurity">Security</label>
          </div>
          <div class="amenity-item">
            <input type="checkbox" id="hasEvCharging" name="has_ev_charging">
            <label for="hasEvCharging">EV Charging</label>
          </div>
          <div class="amenity-item">
            <input type="checkbox" id="isHandicapAccessible" name="is_handicap_accessible">
            <label for="isHandicapAccessible">Handicap Accessible</label>
          </div>
          <div class="amenity-item">
            <input type="checkbox" id="hasLighting" name="has_lighting">
            <label for="hasLighting">Lighting</label>
          </div>
          <div class="amenity-item">
            <input type="checkbox" id="hasCCTV" name="has_cctv">
            <label for="hasCCTV">CCTV</label>
          </div>
        </div>
        <footer>
            <button type="submit" class="btn next" id="nextButton">Next</button>
        </footer>
      </form>
    </div>
</body>
</html>