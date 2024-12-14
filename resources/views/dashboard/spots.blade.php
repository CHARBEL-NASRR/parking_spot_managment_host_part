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
        @foreach($spots as $spot)
            <div class="col-12 col-sm-6 col-lg-4 mb-4">
                <div class="listing-card">
                    <div class="badge {{ $spot->status == 'in-progress' ? 'badge-in-progress' : ($spot->status == 'approved' ? 'badge-approved' : 'badge-pending') }}">
                        {{ $spot->status == 'in-progress' ? 'In progress' : ($spot->status == 'approved' ? 'Approved' : 'Pending') }}
                    </div>
                    
                    <div class="image-container">
                        <iframe src="{{ $spot->image ? $spot->image->image_url : asset('storage/default.jpg') }}" 
                             alt="{{ $spot->title }}" class="listing-image">
                            </iframe>
                    </div>

                    <!-- Details -->
                    <div class="listing-details">
                        <h5 class="listing-title">{{ $spot->title }}</h5>
                        <p class="listing-location">{{ $spot->location }}</p>
                        <p class="listing-date">{{ $spot->date_started }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

    <script>
    document.getElementById('getstarted-btn').addEventListener('click', function () {
        window.location.href = "{{ route('getstarted') }}";  // Adjust the URL to match your route
        });
    document.addEventListener('DOMContentLoaded', function () {
        const searchIcon = document.getElementById('search-icon');
        const searchBox = document.getElementById('search-box');
        const searchInput = document.getElementById('search-input');

        searchIcon.addEventListener('click', () => {
            searchBox.classList.toggle('d-none');
            searchBox.classList.toggle('d-flex');
            searchBox.classList.toggle('w-100');
            searchInput.focus(); 
        });

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
    });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
@endsection