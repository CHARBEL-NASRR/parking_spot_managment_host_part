<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Next Form</title>
</head>
<body>
    <div class="container">
        <h1>Next Form</h1>
        <p>Title from previous form: {{ $title }}</p>
        <p>Token: {{ $token }}</p>
        <form method="POST" action="{{ route('final.save') }}">
            @csrf
            <!-- Add other form fields here -->
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>