<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
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
      }

      .container {
        width: 90%;
        max-width: 800px;
        background-color: white;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      }

      h1 {
        font-size: 30px;
        margin-bottom: 20px;
        text-align: center;
      }

      .options-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
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

      .option img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        margin-bottom: 10px;
      }

      .option:hover {
        border-color: #00c9a7;
        background-color: #f0f0f0;
      }

      .option.selected {
        border-color: black;
        background-color: #dff0d8;
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

      .btn-submit {
        align-self: flex-end;
        background-color: #18b98d;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1.2rem;
      }

      .btn-submit:hover {
        background-color: #16a57f;
      }

      .bottom {
        display: flex;
        width: 100%;
        justify-content: space-between;
        padding: 20px;
      }

      .options-grid .option:last-child {
        grid-column: 2;
        grid-row: 3;
      }
    </style>
    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const options = document.querySelectorAll(".option");

        options.forEach((option) => {
          option.addEventListener("click", () => {
            const checkbox = option.querySelector("input[type='checkbox']");
            checkbox.checked = !checkbox.checked;
            option.classList.toggle("selected", checkbox.checked);
          });
        });
      });
    </script>
  </head>
  <body>
    <header>
      <img src="{{ asset('images/logo_parkingspot.png') }}" alt="Logo">
      <h1 class="logo-text">Chekka</h1>
    </header>

    <div class="container">
      <main>
        <h1>Which of these best describes your place?</h1>
        <form id="amenitiesForm" action="{{ route('amenities.save') }}" method="POST">
          @csrf
          <input type="hidden" name="spot_id" value="{{ $spot->spot_id }}">

          <div class="options-grid">
            <div class="option">
              <img src="{{ asset('images/cctv.png') }}" alt="Security">
              <span>Security</span>
              <input type="checkbox" name="amenities[]" value="Security" {{ in_array('Security', old('amenities', [])) ? 'checked' : '' }} hidden>
            </div>
            <div class="option">
              <img src="{{ asset('images/ev_charging.png') }}" alt="EV Charging">
              <span>EV Charging</span>
              <input type="checkbox" name="amenities[]" value="EV Charging" {{ in_array('EV Charging', old('amenities', [])) ? 'checked' : '' }} hidden>
            </div>
            <div class="option">
              <img src="{{ asset('images/Handicap.png') }}" alt="Handicap">
              <span>Handicap</span>
              <input type="checkbox" name="amenities[]" value="Handicap" {{ in_array('Handicap', old('amenities', [])) ? 'checked' : '' }} hidden>
            </div>
            <div class="option">
              <img src="{{ asset('images/covered.png') }}" alt="Covered">
              <span>Cover</span>
              <input type="checkbox" name="amenities[]" value="Cover" {{ in_array('Cover', old('amenities', [])) ? 'checked' : '' }} hidden>
            </div>
            <div class="option">
              <img src="{{ asset('images/gate.png') }}" alt="Gate">
              <span>Gate</span>
              <input type="checkbox" name="amenities[]" value="Gate" {{ in_array('Gate', old('amenities', [])) ? 'checked' : '' }} hidden>
            </div>
            <div class="option">
              <img src="{{ asset('images/lightended.png') }}" alt="Light">
              <span>Light</span>
              <input type="checkbox" name="amenities[]" value="Light" {{ in_array('Light', old('amenities', [])) ? 'checked' : '' }} hidden>
            </div>
            <div class="option">
              <img src="{{ asset('images/secured.png') }}" alt="Safe">
              <span>Safe</span>
              <input type="checkbox" name="amenities[]" value="Safe" {{ in_array('Safe', old('amenities', [])) ? 'checked' : '' }} hidden>
            </div>
          </div>
        </form>
      </main>
    </div>
    
    <div class="bottom">
    <button 
        type="button" 
        class="btn-submit" 
        onclick="window.location.href='{{ route('upload_docs.updateform') }}?spot_id={{ $spot->spot_id }}'">
        Back
    </button>
</div>



      <button type="submit" class="btn-submit" form="amenitiesForm">Next</button>
    </div>
  </body>
</html>
