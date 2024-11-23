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
            <h1>Now, let's give your spot a title</h1>
            <p class="subtitle">Short titles work best. Have fun with it—you can always change it later.</p>
            <form method="POST" action="{{ route('title.save') }}">
                @csrf
                <textarea name="title" class="title-input" placeholder="Enter your title here" required>{{ old('title', $spot->title ?? '') }}</textarea>
                <div class="char-count">
                    <span id="charCount">{{ strlen(old('title', $spot->title ?? '')) }}</span>/32
                </div>
                <footer class="footer">
                    <button type="submit" class="btn next" {{ strlen(old('title', $spot->title ?? '')) == 0 ? 'disabled' : '' }}>Next</button>
                </footer>
            </form>
        </main>
    </div>
    <script src="{{ asset('js/create_parkingspot/title_parkingspot.js') }}"></script>
</body>
</html>
