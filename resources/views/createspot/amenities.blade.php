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
        height: 120vh;
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
        position: absolute;
        top: 40px;
        left: 40px;
      }

      header img {
        width: 120px;
        height: auto;
        margin-left: 70px;
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
        padding: 50px;
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
              <input type="checkbox" name="amenities[]" value="Security" hidden>
            </div>
            <div class="option">
              <img src="{{ asset('images/ev_charging.png') }}" alt="EV Charging">
              <span>EV Charging</span>
              <input type="checkbox" name="amenities[]" value="EV Charging" hidden>
            </div>
            <div class="option">
              <img src="{{ asset('images/Handicap.png') }}" alt="Handicap">
              <span>Handicap</span>
              <input type="checkbox" name="amenities[]" value="Handicap" hidden>
            </div>
            <div class="option">
              <img src="{{ asset('images/covered.png') }}" alt="Covered">
              <span>Cover</span>
              <input type="checkbox" name="amenities[]" value="Cover" hidden>
            </div>
            <div class="option">
              <img src="{{ asset('images/gate.png') }}" alt="Gate">
              <span>Gate</span>
              <input type="checkbox" name="amenities[]" value="Gate" hidden>
            </div>
            <div class="option">
              <img src="{{ asset('images/lightended.png') }}" alt="Light">
              <span>Light</span>
              <input type="checkbox" name="amenities[]" value="Light" hidden>
            </div>
            <div class="option">
              <img src="{{ asset('images/secured.png') }}" alt="Safe">
              <span>Safe</span>
              <input type="checkbox" name="amenities[]" value="Safe" hidden>
            </div>
          </div>
        </form>
      </main>
    </div>

    <div class="bottom">
      <button type="button" class="btn-submit" onclick="history.back()">Back</button>
      <button type="submit" class="btn-submit" form="amenitiesForm">Next</button>
    </div>
  </body>
</html>
