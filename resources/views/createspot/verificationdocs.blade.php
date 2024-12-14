<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Upload Verification Documents</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
        color: #333;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
      }

      .container {
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        text-align: center;
        margin-top: 60px;
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
        padding: 50px;
      }
      header {
        position: absolute; /* Changed to absolute */
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