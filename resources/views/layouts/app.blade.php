<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ' New Generation')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body
    class="bg-white dark:bg-black min-h-screen flex flex-col text-black dark:text-white transition-colors duration-300">

    <header class="bg-orange-500 dark:bg-gray-900 text-white shadow-md transition-colors duration-300">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <!-- Logo -->
            <h1 class="text-2xl font-semibold flex items-center gap-2">
                <i class="fas fa-tools text-4xl"></i> KEO SATHYARAK
            </h1>

            <!-- Desktop nav -->
            <nav class="hidden md:flex items-center gap-4">
                <a href="{{ url('/') }}" class="flex items-center gap-1 hover:underline">
                    <i class="fas fa-download"></i> Download
                </a>
                <a href="{{ url('/aboutme') }}" class="flex items-center gap-1 hover:underline">
                    <i class="fas fa-user"></i> About Me
                </a>

                <!-- Dark mode toggle -->
                <button id="dark-toggle" class="ml-4 focus:outline-none">
                    <i class="fas fa-moon"></i>
                </button>
            </nav>

            <!-- Mobile hamburger button -->
            <button id="menu-btn" class="md:hidden focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>

        <!-- Mobile nav menu -->
        <nav id="mobile-menu" class="hidden flex-col px-4 pb-4 md:hidden bg-orange-600 dark:bg-gray-900">
            <a href="{{ url('/') }}"
                class="flex items-center gap-1 py-2 hover:bg-orange-500 dark:hover:bg-gray-700 rounded">
                <i class="fas fa-download"></i> Download
            </a>
            <a href="{{ url('/aboutme') }}"
                class="flex items-center gap-1 py-2 hover:bg-orange-500 dark:hover:bg-gray-700 rounded">
                <i class="fas fa-user"></i> About Me
            </a>

            <!-- Dark mode toggle mobile -->
            <button id="dark-toggle-mobile"
                class="flex items-center gap-1 py-2 bg-orange-500 hover:bg-orange-600 dark:bg-gray-700 dark:hover:bg-gray-600 rounded w-full justify-center text-white">
                <i class="fas fa-moon"></i>
            </button>

        </nav>
    </header>

    <script>
        const btn = document.getElementById('menu-btn');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // Dark mode toggle
        const darkToggle = document.getElementById('dark-toggle');
        const darkToggleMobile = document.getElementById('dark-toggle-mobile');
        const html = document.documentElement;

        function updateIcon(button) {
            const icon = button.querySelector('i');
            if (html.classList.contains('dark')) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        }

        function toggleDarkMode() {
            html.classList.toggle('dark');
            localStorage.setItem('dark-mode', html.classList.contains('dark'));
            updateIcon(darkToggle);
            updateIcon(darkToggleMobile);
        }

        // Desktop toggle
        darkToggle?.addEventListener('click', toggleDarkMode);
        // Mobile toggle
        darkToggleMobile?.addEventListener('click', toggleDarkMode);

        // Load saved mode
        if (localStorage.getItem('dark-mode') === 'true') {
            html.classList.add('dark');
        }
        updateIcon(darkToggle);
        updateIcon(darkToggleMobile);
    </script>

    <main class="flex-grow container mx-auto px-4 py-8 transition-colors duration-300">
        @yield('content')
    </main>

    <footer class="bg-orange-500 dark:bg-gray-900 text-white mt-8 transition-colors duration-300">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center text-sm">
            <span>© {{ date('Y') }} Keo Sathyarak. All rights reserved.</span>
        </div>
    </footer>


    @stack('scripts')
</body>

</html>
