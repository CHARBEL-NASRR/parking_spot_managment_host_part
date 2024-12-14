<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Place Selection</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
      }

      body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #f8f8f8;
        min-height: 100vh;
      }

      .container {
        width: 90%;
        max-width: 800px;
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      }

      h2 {
        font-size: 24px;
        margin-bottom: 20px;
        text-align: center;
      }

      .options-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 10px;
      }

      .option {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: white;
        text-align: center;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
      }

      .option .icon {
        font-size: 24px;
        margin-bottom: 10px;
      }

      .option:hover {
        border-color: #00c9a7;
        background-color: #f0f0f0;
      }

      .option.selected {
        border-color: black;
        background-color: #fafafa;
      }
      .option img {
        width: 100%;
        max-width: 120px;
        height: auto;
      }

      footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
      }

      .back-button {
        border: none;
        background: none;
        color: #555;
        font-size: 16px;
        cursor: pointer;
      }

      .actions {
        display: flex;
        gap: 10px;
      }

      button {
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
      }

      button.primary {
        background-color: black;
        color: white;
      }

      button.secondary {
        background-color: #f0f0f0;
        color: #555;
      }
      header {
        padding: 50px;
      }
      header {
        position: absolute;
        top: 40px;
        left: 40px;
      }

      header img {
        width: 120px;
        height: auto;
        margin-left: 70px;
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

      .btn-submit {
        align-self: flex-end;
        background-color: #18b98d;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
      }

      .btn-submit:hover {
        background-color: #16a57f;
      }
      .bottom {
        display: flex;
        width: 100%;
        justify-content: space-between;
        padding: 50px;
      }
    </style>
  </head>
  <body>
    <header>
      <img src="{{ asset('images/logo_parkingspot.png') }}" alt="Logo">
    </header>
    <h1>Vehicle Type Selection</h1>
    <div class="container">
      <form action="{{ route('carSize.save', ['spot_id' => $spot->spot_id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="spot_id" value="{{ $spot->spot_id }}">
        <input type="hidden" name="vehicle_type" id="vehicle_type" value="4wheeler"> <!-- Default to 4wheeler -->

        <main>
          <h2>Select the largest vehicle type your parking can handle:</h2>
          <div class="options-grid">
            <button type="button" class="option" data-vehicle="2wheeler">
              <img src="{{ asset('images/transport.png') }}" alt="" />
              <span>2 Wheel</span>
            </button>
            <button type="button" class="option" data-vehicle="4wheeler">
              <img src="{{ asset('images/sedan.png') }}" alt="" />
              <span>4 Wheel</span>
            </button>
            <button type="button" class="option" data-vehicle="6wheeler">
              <img src="{{ asset('images/truck.png') }}" alt="" />
              <span>6 Wheel</span>
            </button>
            <button type="button" class="option" data-vehicle="8wheeler">
              <img src="{{ asset('images/delivery-truck.png') }}" alt="" />
              <span>8 Wheel</span>
            </button>
          </div>
        </main>

        <div class="bottom">
          <button type="submit" class="btn-submit">Back</button>
          <button type="submit" class="btn-submit">Next</button>
        </div>
      </form>
    </div>

    <script>
      // JavaScript to handle the option selection and update the hidden input
      const options = document.querySelectorAll('.option');
      const vehicleTypeInput = document.getElementById('vehicle_type');

      options.forEach(option => {
        option.addEventListener('click', () => {
          // Remove selected class from all options
          options.forEach(opt => opt.classList.remove('selected'));
          // Add selected class to the clicked option
          option.classList.add('selected');
          
          // Update the hidden input with the selected vehicle type
          const vehicleType = option.getAttribute('data-vehicle');
          vehicleTypeInput.value = vehicleType;
        });
      });
    </script>
  </body>
</html>