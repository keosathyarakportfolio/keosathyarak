@extends('layouts.app')

@section('title', 'My Portfolio')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-12">

        <!-- About Me Section -->
        <section class="mb-12">
            <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-8 text-center">About Me</h1>
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-8">
                <!-- Profile -->
                <div class="flex flex-col items-center sm:items-start gap-4">
                    <img src="images/profile.JPG" alt="Profile Image"
                        class="rounded-full w-48 h-48 object-cover shadow-lg mx-auto sm:mx-0">
                    <p class="text-gray-700 dark:text-gray-300 max-w-xs text-center sm:text-left">
                        Hello! My name is <span class="font-semibold">Keo Sathyarak</span>.
                        I am a third-year Software Engineering student at BELTEI International University, dedicated,
                        adaptable, and passionate about software development and technology.

                        I specialize in computer programming and web development, with strong communication skills and
                        proven teaching experience in computer applications and programming.

                        Beyond academics, I have developed several personal projects that demonstrate my technical ability,
                        creativity, and problem-solving skills.
                    </p>
                </div>
                <!-- Info Cards -->
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
                        <h2 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">Education</h2>
                        <p class="text-gray-700 dark:text-gray-300">2017-2019 : Chhun Chhim SvayAth Secondary School</p>
                        <p class="text-gray-700 dark:text-gray-300">2020-2023 : Hun Sen SvayAntor High School</p>
                        <p class="text-gray-700 dark:text-gray-300">2024-Present : Software Engineering BELTEI IU</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
                        <h2 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">Hometown</h2>
                        <p class="text-gray-700 dark:text-gray-300">Chrey Village, Svay Antor, Prey Veng Province.</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
                        <h2 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">Description</h2>
                        <p class="text-gray-700 dark:text-gray-300">Curious, eager to learn, and love building creative
                            solutions using code.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-6 text-center">My Services</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
                    <i class="fas fa-code text-4xl text-orange-500 mb-3"></i>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">Frontend Development</h3>
                    <p class="text-gray-700 dark:text-gray-300">HTML, CSS, JS, TailwindCSS, React.js</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
                    <i class="fas fa-server text-4xl text-orange-500 mb-3"></i>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">Backend Development</h3>
                    <p class="text-gray-700 dark:text-gray-300">PHP, Laravel, MySQL, REST APIs</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
                    <i class="fas fa-paint-brush text-4xl text-orange-500 mb-3"></i>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">Graphic Design</h3>
                    <p class="text-gray-700 dark:text-gray-300">Photoshop, Illustrator, Figma, Canva</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
                    <i class="fas fa-laptop-code text-4xl text-orange-500 mb-3"></i>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">Web Design</h3>
                    <p class="text-gray-700 dark:text-gray-300">Responsive, UI/UX, Landing pages, Portfolio</p>
                </div>
            </div>
        </section>

        <!-- Portfolio Projects Section -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-6 text-center">My Projects</h2>
            <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">

                <!-- POS System -->
                <div x-data="{ openModal: false }"
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="images/pos.png" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">POS System</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Description of POS System. Built with Laravel +
                            MySQL.</p>
                        <button @click="openModal = true" class="text-orange-500 font-semibold hover:underline">View
                            Details</button>
                    </div>
                    <!-- Modal -->
                    <div x-show="openModal" x-transition
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white dark:bg-gray-800 rounded-lg max-w-3xl w-full p-6 relative">
                            <button @click="openModal = false"
                                class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 text-2xl font-bold">✕</button>
                            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">POS System</h2>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">This POS system manages sales, inventory, and
                                reports.</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <img src="images/pos.png" class="w-full h-48 object-cover rounded-lg">
                                <img src="images/menu.png" class="w-full h-48 object-cover rounded-lg">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Facebook Tools -->
                <div x-data="{ openModal: false }"
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="images/tools.png" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">Facebook Tools</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Automation & analytics toolset using Laravel +
                            APIs.</p>
                        <button @click="openModal = true" class="text-orange-500 font-semibold hover:underline">View
                            Details</button>
                    </div>
                    <div x-show="openModal" x-transition
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white dark:bg-gray-800 rounded-lg max-w-3xl w-full p-6 relative">
                            <button @click="openModal = false"
                                class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 text-2xl font-bold">✕</button>
                            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Facebook Tools</h2>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">Helps manage FB pages & automate tasks.</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <img src="images/facebooktools.png" class="w-full h-48 object-cover rounded-lg">
                                <img src="images/login.png" class="w-full h-48 object-cover rounded-lg">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- POS Dashboard -->
                <div x-data="{ openModal: false }"
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="images/dashbord.png" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">POS Dashboard</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Dashboard with analytics & reports.</p>
                        <button @click="openModal = true" class="text-orange-500 font-semibold hover:underline">View
                            Details</button>
                    </div>
                    <div x-show="openModal" x-transition
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white dark:bg-gray-800 rounded-lg max-w-3xl w-full p-6 relative">
                            <button @click="openModal = false"
                                class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 text-2xl font-bold">✕</button>
                            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">POS Dashboard</h2>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">Clean & responsive dashboard for managing POS
                                system data.</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <img src="images/sale.png" class="w-full h-48 object-cover rounded-lg">
                                <img src="images/cm.png" class="w-full h-48 object-cover rounded-lg">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Contact Section -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-6 text-center">Contact Me</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                <a href="tel:+85581451884"
                    class="block bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 hover:shadow-lg transition">
                    <i class="fas fa-phone text-4xl text-orange-500 mb-3"></i>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">Phone</h3>
                    <p class="text-gray-700 dark:text-gray-300">+855 81 451 884</p>
                </a>
                <a href="https://t.me/keosathyarak" target="_blank"
                    class="block bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 hover:shadow-lg transition">
                    <i class="fab fa-telegram text-4xl text-orange-500 mb-3"></i>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">Telegram</h3>
                    <p class="text-gray-700 dark:text-gray-300">@Keo Sathyarak</p>
                </a>
                <a href="https://facebook.com/keosathyarak.dev" target="_blank"
                    class="block bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 hover:shadow-lg transition">
                    <i class="fab fa-facebook text-4xl text-orange-500 mb-3"></i>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">Facebook</h3>
                    <p class="text-gray-700 dark:text-gray-300">facebook.com/keosathyarak.dev</p>
                </a>
                <a href="https://www.tiktok.com/@keosathyarak.dev" target="_blank"
                    class="block bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 hover:shadow-lg transition">
                    <i class="fab fa-tiktok text-4xl text-orange-500 mb-3"></i>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">TikTok</h3>
                    <p class="text-gray-700 dark:text-gray-300">@keosathyarak.dev</p>
                </a>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush
