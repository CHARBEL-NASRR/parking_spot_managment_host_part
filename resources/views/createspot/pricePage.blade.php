<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing Adjustment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f9f9f9;
            flex-direction: column;
        }

        .container {
            width: 80%;
            max-width: 800px;
            text-align: center;
        }

        .logo {
            position: absolute;
            top: 40px;
            left: 40px;
        }

        .logo img {
            width: 100px;
            height: auto;
        }

        .content {
            background-color: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 50px;
            width: 100%;
        }

        .title {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .amenities-list {
            margin: 30px 0;
            text-align: left;
        }

        .amenity-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .amenity-item input[type="checkbox"] {
            margin-right: 10px;
            width: 20px;
            height: 20px;
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
        footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            width: 100%;
            padding: 10px;
            position: absolute;
            bottom: 50px;
            right: 100px;
        }

        footer .btn {
            background: none;
            border: 1px solid #ccc;
            padding: 20px 30px;
            border-radius: 5px;
            cursor: pointer;
        }

        footer .btn:hover {
            background-color: #0bc2a2;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }

        .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
      <img src="{{ asset('images/logo_parkingspot.png') }}" alt="Logo">
    </header>
    <div class="container">
        <div class="content">
            <div class="title">Adjust Pricing</div>
            <p>Suggested Price: <strong id="price-display">${{ $finalPrice }}</strong></p>
            <form action="{{ route('save-price', ['spot_id' => $spot->spot_id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="price-input" name="price" value="{{ $finalPrice }}">
                <div class="form-group">
                    <label for="price-slider">Adjust Price</label>
                    <input type="range" 
                           id="price-slider" 
                           name="price" 
                           value="{{ $finalPrice }}" 
                           min="{{ $basePrice - 7 }}" 
                           max="{{ $finalPrice + 10 }}" 
                           step="1" 
                           class="form-control-range">
                </div>
                <p id="price-slider-value">Adjusted Price: <strong>$<span id="price-value">{{ $finalPrice }}</span></strong></p>
                <footer>
                    <button type="submit" class="btn">Save Price</button>
                </footer>
            </form>
        </div>
    </div>
    <script>
        // Update price value dynamically as the slider moves
        $('#price-slider').on('input', function() {
            var price = $(this).val();
            $('#price-value').text(price);
            $('#price-input').val(price);
        });
    </script>
</body>
</html>
