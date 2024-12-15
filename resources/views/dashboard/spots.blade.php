@extends('layouts.app')

@section('title', 'Spots')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard/spots.css') }}">
@endsection

@section('content')
<div class="container mt-5">
    <!-- Icons Section -->
    <div class="iconss-bar d-flex justify-content-end mb-3">
        <button class="icons-btn" id="search-icon">
            <i class="fas fa-search"></i>
        </button>
        <button class="icons-btn" id="getstarted-btn">
            <i class="fas fa-plus"></i>
        </button>
    </div>
    
    <div id="search-box" class="search-box d-none">
        <input type="text" id="search-input" class="form-control" placeholder="Search for a spot..." />
    </div>

    <div class="row">
        @forelse($spots as $spot)
            <div class="col-12 col-sm-6 col-lg-4 mb-4">
                <div class="listing-card">
                    <!-- Status Badge -->
                    <div class="badge {{ $spot->status == 'in-progress' ? 'badge-in-progress' : ($spot->status == 'approved' ? 'badge-approved' : 'badge-pending') }}">
                        {{ $spot->status == 'in-progress' ? 'In progress' : ($spot->status == 'approved' ? 'Approved' : 'Pending') }}
                    </div>
                    
                    <!-- Image Container -->
                    <div class="image-container">
                        <iframe 
                            src="{{ $spot->image_url }}" 
                            width="100%" 
                            height="100%" 
                            frameborder="0" 
                            allowfullscreen
                            onerror="this.onerror=null; this.src='{{ asset('storage/default.jpg') }}'; console.error('Image failed to load:', this.src);"
                        >
                            Your browser does not support iframes.
                        </iframe>
                        
                        <!-- Debug Information -->
                        <div class="image-debug">
                            <small>Original Image URL: {{ $spot->original_image_url ?? 'No image' }}</small>
                            <small>Processed Image URL: {{ $spot->image_url }}</small>
                        </div>
                    </div>

                    <!-- Spot Details -->
                    <div class="listing-details">
                        <h5 class="listing-title">{{ $spot->title }}</h5>
                        <p class="listing-location">
                            {{ $spot->location ? $spot->location->city . ', ' . $spot->location->district : 'Location Not Available' }}
                        </p>
                        <p class="listing-price">{{ number_format($spot->price_per_hour, 2) }} $</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No spots available. Click the "+" button to add a new spot.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get Started Button
        document.getElementById('getstarted-btn').addEventListener('click', function () {
            window.location.href = "{{ route('getstarted') }}";
        });

        // Search Functionality
        const searchIcon = document.getElementById('search-icon');
        const searchBox = document.getElementById('search-box');
        const searchInput = document.getElementById('search-input');

        searchIcon.addEventListener('click', () => {
            searchBox.classList.toggle('d-none');
            searchBox.classList.toggle('d-flex');
            searchBox.classList.toggle('w-100');
            searchInput.focus(); 
        });

        // Search Input Filtering
        searchInput.addEventListener('input', function () {
            const query = searchInput.value.toLowerCase();
            const cards = document.querySelectorAll('.listing-card');
            
            cards.forEach(card => {
                const title = card.querySelector('.listing-title').textContent.toLowerCase();
                const location = card.querySelector('.listing-location').textContent.toLowerCase();
                
                if (title.includes(query) || location.includes(query)) {
                    card.parentElement.style.display = 'block'; 
                } else {
                    card.parentElement.style.display = 'none'; 
                }
            });
        });

        // Image Loading Verification
        const images = document.querySelectorAll('.listing-image');
        
        images.forEach(img => {
            fetch(img.src)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                })
                .catch(error => {
                    console.error('Image fetch error:', error);
                    img.src = "{{ asset('storage/default.jpg') }}";
                    img.alt = "Image not available";
                });
        });
    });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
@endsection