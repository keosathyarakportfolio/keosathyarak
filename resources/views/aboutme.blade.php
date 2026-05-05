@extends('layouts.app')

@section('title', 'My Portfolio')

@section('content')

<div class="min-h-screen bg-gray-50 dark:bg-gray-950 text-gray-800 dark:text-gray-100">

    <!-- HERO SECTION -->
    <section class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <!-- Left Content -->
            <div>
                <p class="text-orange-500 font-semibold mb-3">
                    Hello, Welcome to my portfolio
                </p>

                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6">
                    I'm <span class="text-orange-500">Keo Sathyarak</span>
                </h1>

                <h2 class="text-2xl md:text-3xl font-bold text-gray-600 dark:text-gray-300 mb-6">
                    Software Engineering Student
                </h2>

                <p class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed mb-8">
                    I am a Software Engineering student.
                    I enjoy building websites, designing user interfaces, and learning new technologies.
                    I am passionate, creative, and always ready to improve my skills.
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="#contact"
                       class="bg-orange-500 text-white px-7 py-3 rounded-full font-semibold hover:bg-orange-600 transition shadow-lg">
                        Contact Me
                    </a>

                    <a href="#services"
                       class="border border-orange-500 text-orange-500 px-7 py-3 rounded-full font-semibold hover:bg-orange-500 hover:text-white transition">
                        View Services
                    </a>
                </div>
            </div>

            <!-- Right Image -->
            <div class="flex justify-center">
                <div class="relative">
                    <div class="absolute -inset-4 bg-orange-500/20 rounded-full blur-2xl"></div>

                    <img src="{{ asset('images/profile.JPG') }}"
                         alt="Profile Image"
                         class="relative w-72 h-72 md:w-96 md:h-96 object-cover rounded-full border-8 border-white dark:border-gray-800 shadow-2xl">
                </div>
            </div>

        </div>
    </section>


    <!-- ABOUT SECTION -->
    <section class="max-w-7xl mx-auto px-6 py-10">
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl p-8 md:p-12">

            <div class="text-center mb-12">
                <h2 class="text-4xl font-extrabold mb-3">About Me</h2>
                <p class="text-gray-500 dark:text-gray-400">
                    Basic information about me
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <div class="p-6 rounded-2xl bg-orange-50 dark:bg-gray-800 border border-orange-100 dark:border-gray-700">
                    <div class="text-orange-500 text-4xl mb-4">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Education</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-2">
                        2017-2019: Chhun Chhim SvayAth Secondary School
                    </p>
                    <p class="text-gray-600 dark:text-gray-400 mb-2">
                        2020-2023: Hun Sen SvayAntor High School
                    </p>
                    <p class="text-gray-600 dark:text-gray-400">
                        2024-Present: Software Engineering, BELTEI IU
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-blue-50 dark:bg-gray-800 border border-blue-100 dark:border-gray-700">
                    <div class="text-blue-500 text-4xl mb-4">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Hometown</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Chrey Village, Svay Antor, Prey Veng Province
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-green-50 dark:bg-gray-800 border border-green-100 dark:border-gray-700">
                    <div class="text-green-500 text-4xl mb-4">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Personality</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Curious, friendly, hardworking, and eager to learn new technologies.
                    </p>
                </div>

            </div>
        </div>
    </section>


    <!-- SERVICES SECTION -->
    <section id="services" class="max-w-7xl mx-auto px-6 py-16">

        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold mb-3">My Services</h2>
            <p class="text-gray-500 dark:text-gray-400">
                What I can help you build
            </p>
        </div>

        @php
            $services = [
                [
                    'icon' => 'fas fa-code',
                    'title' => 'Frontend Development',
                    'desc' => 'Build clean and responsive websites using HTML, CSS, JavaScript, TailwindCSS, and React.js.',
                    'color' => 'text-purple-500 bg-purple-50 dark:bg-gray-800'
                ],
                [
                    'icon' => 'fas fa-server',
                    'title' => 'Backend Development',
                    'desc' => 'Develop backend systems using PHP, Laravel, MySQL, and REST API.',
                    'color' => 'text-green-500 bg-green-50 dark:bg-gray-800'
                ],
                [
                    'icon' => 'fas fa-paint-brush',
                    'title' => 'Graphic Design',
                    'desc' => 'Create attractive designs using Photoshop, Illustrator, Figma, and Canva.',
                    'color' => 'text-pink-500 bg-pink-50 dark:bg-gray-800'
                ],
                [
                    'icon' => 'fas fa-laptop-code',
                    'title' => 'Web Design',
                    'desc' => 'Design modern portfolio websites, landing pages, and business websites.',
                    'color' => 'text-orange-500 bg-orange-50 dark:bg-gray-800'
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($services as $service)
                <div class="bg-white dark:bg-gray-900 rounded-3xl p-8 shadow-lg hover:shadow-2xl hover:-translate-y-2 transition duration-500 border border-gray-100 dark:border-gray-800">

                    <div class="w-16 h-16 rounded-2xl {{ $service['color'] }} flex items-center justify-center mb-6">
                        <i class="{{ $service['icon'] }} text-3xl"></i>
                    </div>

                    <h3 class="text-xl font-bold mb-3">
                        {{ $service['title'] }}
                    </h3>

                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        {{ $service['desc'] }}
                    </p>

                </div>
            @endforeach
        </div>
    </section>


    <!-- SKILLS SECTION -->
    <section class="max-w-7xl mx-auto px-6 py-10">

        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl p-8 md:p-12">
            <div class="text-center mb-10">
                <h2 class="text-4xl font-extrabold mb-3">My Skills</h2>
                <p class="text-gray-500 dark:text-gray-400">
                    Technologies and tools I use
                </p>
            </div>

            @php
                $skills = [
                    'HTML', 'CSS', 'Bootstrap', 'TailwindCSS',
                    'JavaScript', 'React.js', 'PHP', 'Laravel',
                    'MySQL', 'REST API', 'Figma', 'GitHub','Flutter'
                ];
            @endphp

            <div class="flex flex-wrap justify-center gap-4">
                @foreach($skills as $skill)
                    <span class="px-6 py-3 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-medium hover:bg-orange-500 hover:text-white transition">
                        {{ $skill }}
                    </span>
                @endforeach
            </div>
        </div>

    </section>


    <!-- CONTACT SECTION -->
    <section id="contact" class="max-w-7xl mx-auto px-6 py-16">

        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold mb-3">Contact Me</h2>
            <p class="text-gray-500 dark:text-gray-400">
                You can contact me through these platforms
            </p>
        </div>

        @php
            $contacts = [
                [
                    'icon' => 'fas fa-phone',
                    'title' => 'Phone',
                    'desc' => '+855 81 451 884',
                    'link' => 'tel:+85581451884',
                    'color' => 'text-green-500'
                ],
                [
                    'icon' => 'fab fa-telegram',
                    'title' => 'Telegram',
                    'desc' => '@keosathyarak',
                    'link' => 'https://t.me/keosathyarak',
                    'color' => 'text-blue-500'
                ],
                [
                    'icon' => 'fab fa-facebook',
                    'title' => 'Facebook',
                    'desc' => 'keosathyarak.dev',
                    'link' => 'https://facebook.com/keosathyarak.dev',
                    'color' => 'text-indigo-500'
                ],
                [
                    'icon' => 'fab fa-tiktok',
                    'title' => 'TikTok',
                    'desc' => '@keosathyarak.dev',
                    'link' => 'https://www.tiktok.com/@keosathyarak.dev',
                    'color' => 'text-pink-500'
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($contacts as $contact)
                <a href="{{ $contact['link'] }}"
                   target="_blank"
                   class="bg-white dark:bg-gray-900 rounded-3xl p-8 shadow-lg hover:shadow-2xl hover:-translate-y-2 transition duration-500 text-center border border-gray-100 dark:border-gray-800">

                    <i class="{{ $contact['icon'] }} {{ $contact['color'] }} text-5xl mb-5"></i>

                    <h3 class="text-xl font-bold mb-2">
                        {{ $contact['title'] }}
                    </h3>

                    <p class="text-gray-600 dark:text-gray-400">
                        {{ $contact['desc'] }}
                    </p>

                </a>
            @endforeach
        </div>

    </section>

</div>

@endsection