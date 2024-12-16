<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Upload Verification Documents</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
        color: #333;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
      }

      .container {
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        text-align: center;
      }


      .logo {
        max-width: 60px;
        margin-bottom: 20px;
      }

      h1 {
        font-size: 2.4rem;
        margin-bottom: 10px;
      }

      p {
        font-size: 1.3rem;
        color: #666;
        margin-bottom: 20px;
      }

      .form-group {
        margin-bottom: 20px;
        text-align: left;
      }

      label {
        font-size: 1.3rem;
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
      }

      input[type="file"] {
        width: 100%;
        padding: 15px;
        border: 2px solid #ddd;
        border-radius: 10px;
      }

      .btn-submit {
        background-color: #18b98d;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        font-size: 1.2rem;
      }

      .btn-submit:hover {
        background-color: #16a57f;
      }
      header {
        padding: 30px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        width: 100%;
      }

      header img {
        width: 120px; /* Increased logo size */
        height: auto; /* Maintain aspect ratio */
        margin-left: 100px;
      }
      .logo-text {
        color: #16a57f;
        font-family: roboto;
        font-size: 30px;
        margin-top: 10px;

      }
    </style>
  </head>
  <body>
  <header>
      <img src="{{ asset('images/logo_parkingspot.png') }}" alt="Logo">
      <h1 class="logo-text">Chekka</h1>
    </header>
    <div class="container">
    <h1>Upload Verification Documents</h1>
    <p class="subtitle">
      Please upload the spot verification documents.
    </p>

    <form action="{{ route('upload_docs.save') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label for="verification-documents">Verification Documents*</label>
          <input
            type="file"
            id="verification-documents"
            name="VeriDocs"
            required
            accept="image/*"
          />
        </div>

      <button type="submit" class="btn-submit">Submit</button>
    </form>
    </div>
  </body>
</html>
