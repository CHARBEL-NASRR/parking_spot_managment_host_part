<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Getting Started</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
        color: #333;
       
      }

      .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 50px;
      }

      .content {
        flex: 1;
      }

      .content h1 {
        font-size: 50px;
        margin-bottom: 1.3rem;
      }

      .steps {
        display: flex;
        flex-direction: column;
        gap: 30px;
      }

      .step {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 30px;
        margin-bottom: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .step h3 {
        margin: 0 0 5px;
        font-size: 1.7rem;
      }

      .step p {
        margin: 0;
        font-size: 1.2rem;
        color: #666;
      }

      .btn-get-started {
        background-color: #18b98d;
        color: #fff;
        text-align: center;
        padding: 20px 30px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        font-size: 20px;
        margin-top: 20px;
      }

      .btn-get-started:hover {
        background-color: #16a57f;
      }
      header {
        padding: 90px;
      }
      header {
        top: 40px; /* Adjust as needed */
        left: 40px; /* Adjust as needed */
      }

      header img {
        width: 120px; /* Increased logo size */
        height: auto; /* Maintain aspect ratio */
        margin-left: 70px;
      }
    </style>
  </head>
  <body>
    <header>
      <img src="{{ asset('images/logo_parkingspot.png') }}" alt="Logo">
    </header>
    <div class="container">
      <div class="content">
        <h1>It's easy to get started on our Website</h1>
        <a href="{{ route('upload_docs.form') }}" class="btn-get-started">Get Started</a>
      </div>
      <div class="steps">
        <div class="step">
          <h3>Tell us about your spot</h3>
          <p>
            Share some basic info, like where it is and how many guests can
            park.
          </p>
        </div>
        <div class="step">
          <h3>Make it stand out</h3>
          <p>
            Add 5 or more photos plus a title and description - we'll help you
            out.
          </p>
        </div>
        <div class="step">
          <h3>Finish up and publish</h3>
          <p>
            Choose a starting price, verify a few details, then publish your
            listing.
          </p>
        </div>
      </div>
    </div>
  </body>
</html>