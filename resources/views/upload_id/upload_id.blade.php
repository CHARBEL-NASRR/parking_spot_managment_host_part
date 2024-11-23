<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Upload ID Card</title>
  <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
  <style>
    .button-group {
      display: flex;
      flex-direction: column;
      gap: 10px;
      align-items: center;
    }

    .upload-id-container {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
      background-color: #ffffff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    h1 {
      text-align: center;
      font-size: 24px;
      margin-bottom: 20px;
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

    /* Updated subtitle styling */
    .subtitle {
      font-size: 20px; /* Increase font size */
      text-align: center; /* Center the text */
      margin-bottom: 20px; /* Add some space below */
      color: #333; /* Optional: change text color */
    }
  </style>
  <script>
   

    function handleCancel() {
      window.location.href = "{{ url('/home') }}"; // Redirect to home page
    }
  </script>
</head>
<body>
  <div class="upload-id-container">
    <h1>Upload ID Card</h1>
    <p class="subtitle">
      Please upload your ID card below.
    </p>

    <form id="uploadForm" action="{{ route('upload_id.save') }}" method="POST" enctype="multipart/form-data">
        @csrf
      <div class="form-group">
        <label for="idCard">ID Card*</label>
        <input type="file" class="form-control" required name="idCard" accept="image/*">
      </div>

      <div class="button-group">
        <button type="submit" class="btn">Submit</button>
        <button type="button" class="btn" onclick="handleCancel()">Cancel for now</button>
      </div>
    </form>

    <div class="login-link">
      <a href="{{ url('/host/login') }}">Go back to Login</a>
    </div>
  </div> 

  <!-- jQuery -->
</body>
</html>
