<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Pricing Adjustment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 95vh;
            background-color: #f9f9f9;
            flex-direction: column;
        }

        .container {
            width: 80%;
            max-width: 800px;
            text-align: center;
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

        header {
            padding: 30px 0px 0px 0px;
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
            margin-bottom: 0px;
            margin-top: 0px;
        }

        .bottom {
            display: flex;
            width: 100%;
            justify-content: space-between;
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

        /* Slider Styling */
        #price-slider {
            -webkit-appearance: none;
            width: 100%;
            height: 10px;
            background: white;
            border-radius: 5px;
            outline: none;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        #price-slider::-webkit-slider-runnable-track {
            background: linear-gradient(to right, #16a57f 0%, #16a57f var(--slider-value, 50%), white var(--slider-value, 50%), white 100%);
            height: 10px;
        }

        #price-slider::-moz-range-track {
            background: linear-gradient(to right, #16a57f 0%, #16a57f var(--slider-value, 50%), white var(--slider-value, 50%), white 100%);
            height: 10px;
        }

        #price-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 0;
            height: 0;
            background: #16a57f;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        #price-slider::-webkit-slider-thumb::after {
            content: '';
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 5px;
            height: 5px;
            background: #fff;
            border: 2px solid #16a57f;
            border-radius: 50%;
        }

        #price-slider::-moz-range-thumb {
            width: 0;
            height: 0;
            background: transparent;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        #price-slider::-moz-range-thumb::after {
            content: '';
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 5px;
            height: 5px;
            background: #fff;
            border: 2px solid #16a57f;
            border-radius: 50%;
        }

        .slider-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 10px; /* Add some space above the slider */
        }

        .adjusted-price {
            font-size: 24px; /* Make the adjusted price larger */
            margin-left: 20px; /* Add some space between the slider and the price */
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
      <img src="{{ asset('images/logo_parkingspot.png') }}" alt="Logo">
      <h1 class="logo-text">Chekka</h1>
</header>
<div class="container">
    <div class="content">
        <div class="title">Adjust Pricing</div>
        <p>Suggested Price: <strong id="price-display">${{ $finalPrice }}</strong></p>
        <form id="priceform" action="{{ route('save-price', ['spot_id' => $spot->spot_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="price-input" name="price" value="{{ $finalPrice }}">
            <div class="form-group">
                <label for="price-slider">Adjust Price</label>
                <div class="slider-container">
                    <input type="range" 
                           id="price-slider" 
                           name="price" 
                           value="{{ $finalPrice }}" 
                           min="{{ $finalPrice - 5 }}" 
                           max="{{ $finalPrice + 5 }}" 
                           step="1" 
                           class="form-control-range"
                           aria-label="Adjust suggested price">
                    <p id="price-slider-value" class="adjusted-price">Adjusted Price: <strong>$<span id="price-value">{{ $finalPrice }}</span></strong></p>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="bottom">
    <button type="button" class="btn-submit back" onclick="history.back()">Back</button>
    <button type="submit" class="btn-submit next" form="priceform">Next</button>
</div>
<script>
    // Update price value dynamically as the slider moves
    const slider = document.getElementById('price-slider');
    const priceValue = document.getElementById('price-value');
    const priceInput = document.getElementById('price-input');

    // Function to set slider gradient fill based on value
    function updateSliderGradient() {
        const value = slider.value;
        const percentage = ((value - slider.min) / (slider.max - slider.min)) * 100;
        slider.style.setProperty('--slider-value', `${percentage}%`);
    }

    // Set slider to default position based on suggested price
    document.addEventListener('DOMContentLoaded', function() {
        updateSliderGradient();
        priceValue.textContent = slider.value; // Display default price
        priceInput.value = slider.value;      // Update hidden input value
    });

    // Update dynamically as slider moves
    slider.addEventListener('input', function() {
        priceValue.textContent = slider.value;
        priceInput.value = slider.value;
        updateSliderGradient();
    });
</script>

</body>
</html>