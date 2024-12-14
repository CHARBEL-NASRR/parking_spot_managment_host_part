<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
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
        justify-content: space-between;
        align-items: center;
        background-color: #f8f8f8;
        gap: 100px;
        height: 97vh;
      }
      textarea {
        font-size: 18px;
        text-align: left;
        width: 100%;
        max-width: 500px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        resize: both;
      }
      form {
        display: flex;
        flex-direction: column;
        width: 100%;
        justify-content: center;
        align-items: center;
      }

      .container {
        text-align: center;
        background-color: white;
        border-radius: 8px;
        padding: 40px 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 90%;
        max-width: 600px;
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
        margin-top: 20px;
      }

      .btn-submit:hover {
        background-color: #16a57f;
      }

      .bottom {
        display: flex;
        width: 100%;
        justify-content: space-between;
        padding: 160px 15px 0px 15px;
      }
    </style>
  </head>
  <body>
  <header>
      <img src="{{ asset('images/logo_parkingspot.png') }}" alt="Logo">
      <h1 class="logo-text">Chekka</h1>
    </header>
    <form method="POST" action="{{ route('description.save', $spot->spot_id) }}">
    @csrf
      <input type="hidden" name="spot_id" value="{{ $spot->spot_id }}"> <!-- Hidden spot_id -->
      <div class="container">
      <h1>Now, let's give your spot a description</h1>
        <p>
          Provide a detailed description. Remember, you can always change it later
          in settings.
        </p>
        <div class="pin-input">
          <textarea name="description" id="description" placeholder="Enter your description"></textarea>
        </div>
      </div>
      <div class="bottom">
        <button type="button" class="btn-submit back" onclick="history.back()">Back</button>     
        <button type="submit" class="btn-submit next">Next</button>
      </div>
    </form>
  </body>
</html>
