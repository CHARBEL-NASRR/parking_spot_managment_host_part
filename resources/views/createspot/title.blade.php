<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Enter PIN</title>
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
        height: 100vh;
        background-color: #f8f8f8;
      }

      .container {
        text-align: center;
        background-color: white;
        border-radius: 8px;
        padding: 40px 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 90%;
        max-width: 600px;
        margin-bottom: 20px; /* Adjust space for the buttons outside */
      }

      .logo {
        height: 40px;
        margin-bottom: 20px;
      }

      h1 {
        font-size: 30px;
        margin-bottom: 10px;
        color: #333;
      }

      p {
        font-size: 15px;
        color: #666;
        margin-bottom: 20px;
      }

      .pin-input {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        position: relative;
      }

      input {
        font-size: 18px;
        text-align: center;
        width: 100%;
        max-width: 300px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
      }

      .pin-counter {
        position: absolute;
        right: 15px;
        bottom: 12px;
        font-size: 12px;
        color: #666;
      }

      .actions {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
      }

      button {
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
      }

      .back {
        background-color: #f0f0f0;
        color: #555;
      }

      .next {
        background-color: #ccc;
        color: white;
        cursor: not-allowed;
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

      /* Updated button styles similar to amenities page */
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
        padding: 0 50px 50px; /* Keep padding only for bottom */
      }

      .bottom button {
        width: 48%; /* Adjust width for both buttons */
      }
    </style>
  </head>
  <body>
    <header>
      <img src="{{ asset('images/logo_parkingspot.png') }}" alt="Logo">
    </header>

    <div class="container">
      <h1>Now, let's give your spot a title</h1>
      <p>Short titles work best. Have fun with it—you can always change it later</p>
      
      <!-- Start of the form -->
      <form id="titleForm" method="POST" action="{{ route('title.save') }}">
        @csrf
        <input type="hidden" name="spot_id" value="{{ $spot->spot_id }}">

        <div class="pin-input">
          <input type="text" name="title" placeholder="Enter your title" maxlength="4" required />
        </div>
      </form>
      <!-- End of the form -->
    </div>

    <!-- Bottom buttons outside of the container -->
    <div class="bottom">
      <button type="button" class="btn-submit" onclick="history.back()">Back</button>
      <button type="submit" class="btn-submit" form="titleForm">Next</button>
    </div>

  </body>
</html>
