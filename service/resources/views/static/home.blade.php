@extends('components.layouts.app')

@section('title', 'トップページ')

@section('content')
<!-- Main Content Area -->
<main class="flex-1">
    <!-- Hero Slideshow Section -->
    <div class="relative rounded-lg shadow-lg mb-1 overflow-hidden">
        <div class="slideshow-container relative w-full h-96">
            <div class="slide active relative w-full h-full">
                <img src="{{ asset('image/001.jpg') }}" alt="スライド1" class="w-full h-full object-cover">
            </div>
            <div class="slide relative w-full h-full">
                <img src="{{ asset('image/002.jpg') }}" alt="スライド2" class="w-full h-full object-cover">
            </div>
            <div class="slide relative w-full h-full">
                <img src="{{ asset('image/003.jpg') }}" alt="スライド3" class="w-full h-full object-cover">
            </div>
            <div class="slide relative w-full h-full">
                <img src="{{ asset('image/004.jpg') }}" alt="スライド4" class="w-full h-full object-cover">
            </div>

            <!-- Navigation arrows -->
            <button class="prev-btn absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 text-gray-800 w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button class="next-btn absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 text-gray-800 w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Dots indicator -->
            <div class="dots-container absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                <span class="dot active w-3 h-3 bg-white rounded-full cursor-pointer transition-all duration-300" data-slide="0"></span>
                <span class="dot w-3 h-3 bg-white bg-opacity-60 rounded-full cursor-pointer transition-all duration-300" data-slide="1"></span>
                <span class="dot w-3 h-3 bg-white bg-opacity-60 rounded-full cursor-pointer transition-all duration-300" data-slide="2"></span>
                <span class="dot w-3 h-3 bg-white bg-opacity-60 rounded-full cursor-pointer transition-all duration-300" data-slide="3"></span>
            </div>
        </div>
    </div>

    <style>
        .slideshow-container {
            position: relative;
        }

        .slide {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transition: opacity 0.5s ease-in-out;
        }

        .slide.active {
            display: block;
        }

        .slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .dot.active {
            background-color: white !important;
        }

        .prev-btn:hover, .next-btn:hover {
            transform: translateY(-50%) scale(1.1);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentSlide = 0;
            const slides = document.querySelectorAll('.slide');
            const dots = document.querySelectorAll('.dot');
            const totalSlides = slides.length;

            function showSlide(index) {
                // Remove active class from all slides and dots
                slides.forEach(slide => slide.classList.remove('active'));
                dots.forEach(dot => dot.classList.remove('active'));

                // Add active class to current slide and dot
                slides[index].classList.add('active');
                dots[index].classList.add('active');
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                showSlide(currentSlide);
            }

            function prevSlide() {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                showSlide(currentSlide);
            }

            // Auto-play slideshow
            let autoPlay = setInterval(nextSlide, 5000); // Change slide every 5 seconds

            // Navigation buttons
            document.querySelector('.next-btn').addEventListener('click', function() {
                clearInterval(autoPlay);
                nextSlide();
                autoPlay = setInterval(nextSlide, 5000); // Restart auto-play
            });

            document.querySelector('.prev-btn').addEventListener('click', function() {
                clearInterval(autoPlay);
                prevSlide();
                autoPlay = setInterval(nextSlide, 5000); // Restart auto-play
            });

            // Dot navigation
            dots.forEach((dot, index) => {
                dot.addEventListener('click', function() {
                    clearInterval(autoPlay);
                    currentSlide = index;
                    showSlide(currentSlide);
                    autoPlay = setInterval(nextSlide, 5000); // Restart auto-play
                });
            });

            // Pause auto-play on hover
            const slideshowContainer = document.querySelector('.slideshow-container');
            slideshowContainer.addEventListener('mouseenter', function() {
                clearInterval(autoPlay);
            });

            slideshowContainer.addEventListener('mouseleave', function() {
                autoPlay = setInterval(nextSlide, 5000);
            });
        });
    </script>

    <!-- News Section -->
    <div class="bg-white mt-4 rounded-lg shadow-md overflow-hidden">
        <div class="bg-green-600 text-white p-4">
            <h3 class="text-xl font-bold flex items-center">
                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                最新情報
            </h3>
        </div>
        <div class="p-6">
            <dl class="space-y-4">
                <div class="flex">
                    <dt class="w-24 text-sm text-gray-600 font-semibold">2011.11.17</dt>
                    <dd class="flex-1 text-gray-800">各コンテンツの内容を整理しました。</dd>
                </div>
                <div class="flex">
                    <dt class="w-24 text-sm text-gray-600 font-semibold">2011.11.16</dt>
                    <dd class="flex-1 text-gray-800">HP開設しました。</dd>
                </div>
            </dl>
        </div>
    </div>
</main>
@endsection
