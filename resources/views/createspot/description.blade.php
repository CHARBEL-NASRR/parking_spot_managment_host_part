<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Form</title>
    <link rel="stylesheet" href="{{ asset('css/createspot/title.css') }}">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="logo">
                <img src="{{ asset('images/logo_parkingspot.png') }}" alt="Logo">
            </div>
        </header>
        <main>
            <h1>Now, let's give your spot a description</h1>
            <p class="subtitle">Provide a detailed description. You can always change it later.</p>
            <form method="POST" action="{{ route('description.save', $spot->spot_id) }}">
                @csrf
                <textarea name="description" class="title-input" placeholder="Enter your description here" required>{{ old('description', $spot->main_description ?? '') }}</textarea>
                <div class="char-count">
                    <span id="charCount">{{ strlen(old('description', $spot->main_description ?? '')) }}</span>/255
                </div>
                <footer class="footer">
                    <a href="{{ route('title.form', $spot->spot_id) }}" class="btn back">Back</a>
                    <button type="submit" class="btn next" {{ strlen(old('description', $spot->main_description ?? '')) == 0 ? 'disabled' : '' }}>Next</button>
                </footer>
            </form>
        </main>
    </div>
    <script src="{{ asset('js/create_parkingspot/description_parkingspot.js') }}"></script>
</body>
</html>
