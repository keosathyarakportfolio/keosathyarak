@extends('layouts.app')

@section('title', 'My Portfolio')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12 space-y-20">

    <!-- About Me Section -->
    <section class="bg-white dark:bg-gray-900 rounded-3xl p-10 shadow-lg">
        <h1 class="text-5xl font-extrabold text-gray-800 dark:text-white mb-12 text-center">About Me</h1>

        <div class="flex flex-col items-center gap-10">

            <!-- Profile -->
            <div x-data="{ show: false }" x-init="show = true"
                 :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-6'"
                 class="flex flex-col items-center gap-6 transition-all duration-1000">

                <img src="{{ asset('images/profile.JPG') }}" alt="Profile Image"
                     class="rounded-full w-52 h-52 object-cover shadow-lg transform hover:scale-105 transition duration-700 border-4 border-gray-200 dark:border-gray-700">

                <p class="text-gray-700 dark:text-gray-300 max-w-lg text-center text-lg leading-relaxed">
                    Hello! My name is <span class="font-semibold text-green-600">Keo Sathyarak</span>, a third-year Software Engineering student at BELTEI International University.
                    <br><br>
                    Dedicated, adaptable, and passionate about software development and technology. I specialize in computer programming and web development with strong communication skills.
                    <br><br>
                    Beyond academics, I have built several projects that showcase my technical ability, creativity, and problem-solving skills.
                </p>
            </div>

            <!-- Info Cards -->
            <div class="flex flex-wrap justify-center gap-8">
                <div class="bg-green-50 dark:bg-gray-800 shadow-md rounded-2xl p-6 text-center w-72 transition-all duration-500 hover:scale-105">
                    <h2 class="text-xl font-semibold mb-3 text-gray-800 dark:text-white">Education</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-1">2017-2019 : Chhun Chhim SvayAth Secondary School</p>
                    <p class="text-gray-700 dark:text-gray-300 mb-1">2020-2023 : Hun Sen SvayAntor High School</p>
                    <p class="text-gray-700 dark:text-gray-300">2024-Present : Software Engineering BELTEI IU</p>
                </div>

                <div class="bg-blue-50 dark:bg-gray-800 shadow-md rounded-2xl p-6 text-center w-72 transition-all duration-500 hover:scale-105">
                    <h2 class="text-xl font-semibold mb-3 text-gray-800 dark:text-white">Hometown</h2>
                    <p class="text-gray-700 dark:text-gray-300">Chrey Village, Svay Antor, Prey Veng Province</p>
                </div>

                <div class="bg-yellow-50 dark:bg-gray-800 shadow-md rounded-2xl p-6 text-center w-72 transition-all duration-500 hover:scale-105">
                    <h2 class="text-xl font-semibold mb-3 text-gray-800 dark:text-white">Description</h2>
                    <p class="text-gray-700 dark:text-gray-300">Curious, eager to learn, and love building creative solutions using code.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section>
        <h2 class="text-4xl font-bold text-gray-800 dark:text-white mb-10 text-center">My Services</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

            @php
                $services = [
                    ['icon'=>'fas fa-code', 'title'=>'Frontend Development', 'desc'=>'HTML, CSS, JS, TailwindCSS, React.js','color'=>'bg-purple-50 dark:bg-gray-800'],
                    ['icon'=>'fas fa-server', 'title'=>'Backend Development', 'desc'=>'PHP, Laravel, MySQL, REST APIs','color'=>'bg-green-50 dark:bg-gray-800'],
                    ['icon'=>'fas fa-paint-brush', 'title'=>'Graphic Design', 'desc'=>'Photoshop, Illustrator, Figma, Canva','color'=>'bg-pink-50 dark:bg-gray-800'],
                    ['icon'=>'fas fa-laptop-code', 'title'=>'Web Design', 'desc'=>'Responsive, UI/UX, Landing pages, Portfolio','color'=>'bg-yellow-50 dark:bg-gray-800'],
                ];
            @endphp

            @foreach($services as $service)
            <div class="flex flex-col items-center {{ $service['color'] }} shadow-md rounded-2xl p-8 text-center transition-all duration-500 hover:scale-105">
                <i class="{{ $service['icon'] }} text-5xl text-orange-500 mb-4"></i>
                <h3 class="text-2xl font-semibold mb-2 text-gray-800 dark:text-white">{{ $service['title'] }}</h3>
                <p class="text-gray-700 dark:text-gray-300">{{ $service['desc'] }}</p>
            </div>
            @endforeach

        </div>
    </section>

    <!-- Portfolio Section -->
    <section>
        <h2 class="text-4xl font-bold text-gray-800 dark:text-white mb-10 text-center">My Projects</h2>
        <div class="grid gap-10 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">

            @php
                $projects = [
                    ['title'=>'POS System','desc'=>'POS System managing sales & inventory','images'=>['pos.png','menu.png'],'color'=>'bg-green-50 dark:bg-gray-800'],
                    ['title'=>'Facebook Tools','desc'=>'Automation & analytics toolset using Laravel + APIs','images'=>['facebooktools.png','login.png'],'color'=>'bg-blue-50 dark:bg-gray-800'],
                    ['title'=>'POS Dashboard','desc'=>'Clean & responsive dashboard for managing POS system data','images'=>['sale.png','cm.png'],'color'=>'bg-yellow-50 dark:bg-gray-800'],
                ];
            @endphp

            @foreach($projects as $project)
            <div x-data="{ openModal:false }" class="{{ $project['color'] }} rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition duration-500">
                <img src="{{ asset('images/'.$project['images'][0]) }}" class="w-full h-56 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">{{ $project['title'] }}</h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $project['desc'] }}</p>
                    <button @click="openModal=true" class="text-orange-500 font-semibold hover:underline">View Details</button>
                </div>

                <!-- Modal -->
                <div x-show="openModal" x-transition class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-3xl w-full p-6 relative">
                        <button @click="openModal=false" class="absolute top-3 right-3 text-gray-600 dark:text-gray-300 text-2xl font-bold">✕</button>
                        <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">{{ $project['title'] }}</h2>
                        <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $project['desc'] }}</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($project['images'] as $img)
                            <img src="{{ asset('images/'.$img) }}" class="w-full h-48 object-cover rounded-lg">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </section>

    <!-- Contact Section -->
    <section>
        <h2 class="text-4xl font-bold text-gray-800 dark:text-white mb-10 text-center">Contact Me</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center">

            @php
                $contacts = [
                    ['icon'=>'fas fa-phone','title'=>'Phone','desc'=>'+855 81 451 884','link'=>'tel:+85581451884','color'=>'bg-green-50 dark:bg-gray-800'],
                    ['icon'=>'fab fa-telegram','title'=>'Telegram','desc'=>'@Keo Sathyarak','link'=>'https://t.me/keosathyarak','color'=>'bg-blue-50 dark:bg-gray-800'],
                    ['icon'=>'fab fa-facebook','title'=>'Facebook','desc'=>'facebook.com/keosathyarak.dev','link'=>'https://facebook.com/keosathyarak.dev','color'=>'bg-indigo-50 dark:bg-gray-800'],
                    ['icon'=>'fab fa-tiktok','title'=>'TikTok','desc'=>'@keosathyarak.dev','link'=>'https://www.tiktok.com/@keosathyarak.dev','color'=>'bg-pink-50 dark:bg-gray-800'],
                ];
            @endphp

            @foreach($contacts as $contact)
            <a href="{{ $contact['link'] }}" target="_blank" class="{{ $contact['color'] }} shadow-md rounded-2xl p-6 hover:shadow-lg transition duration-500 hover:scale-105">
                <i class="{{ $contact['icon'] }} text-5xl text-orange-500 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">{{ $contact['title'] }}</h3>
                <p class="text-gray-700 dark:text-gray-300">{{ $contact['desc'] }}</p>
            </a>
            @endforeach

        </div>
    </section>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush
