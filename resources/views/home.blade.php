@extends('layouts.app')

@section('title', 'Download Video')

@section('content')
<div class="max-w-4xl mx-auto">
    <h2 class="text-3xl font-semibold mb-4 text-center">Enter a video link to download</h2>

    <!-- 🌐 Supported Platforms -->
    <div class="flex flex-wrap justify-center gap-4 mb-6 text-center">
        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
            <i class="fab fa-youtube text-red-600 text-xl"></i> <span>YouTube</span>
        </div>
        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
            <i class="fab fa-tiktok text-black text-xl"></i> <span>TikTok</span>
        </div>
        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
            <i class="fab fa-facebook text-blue-600 text-xl"></i> <span>Facebook</span>
        </div>
        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
            <i class="fab fa-pinterest text-red-500 text-xl"></i> <span>Pinterest</span>
        </div>
        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
            <i class="fas fa-film text-purple-500 text-xl"></i> <span>DramaBox</span>
        </div>
    </div>

    <p class="text-center text-sm text-gray-500 dark:text-gray-400 mb-6">
        Supported Platforms: YouTube, Facebook, TikTok, Pinterest, and DramaBox
    </p>

    {{-- 🎥 Video URL Form --}}
    <form method="POST" action="{{ route('getvideo') }}" 
          class="flex flex-col sm:flex-row gap-4 mb-6 relative"
          onsubmit="showLoadingInButton(event)">
        @csrf

        <div class="relative flex-grow">
            <input 
                id="videoUrlInput"
                name="videoUrl" 
                type="url" 
                placeholder="Enter video link (TikTok, Facebook, YouTube, Pinterest, DramaBox)" 
                value="{{ old('videoUrl', $videoUrl ?? '') }}" 
                class="w-full px-4 py-3 pr-10 border rounded-md 
                       text-gray-800 dark:text-gray-200 
                       placeholder-gray-500 dark:placeholder-gray-400 
                       bg-white dark:bg-gray-800 
                       border-gray-300 dark:border-gray-600" 
                required 
            />
            <!-- ❌ Clear button -->
            <button type="button" id="clearInputBtn"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 hidden">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- 🔽 Submit Button -->
        <button 
            id="downloadBtn" 
            type="submit" 
            class="bg-orange-500 text-white px-6 py-3 rounded-md flex items-center justify-center gap-2 hover:bg-orange-600 transition"
        >
            <span id="buttonText">Get Video</span>
            <i class="fas fa-arrow-right" id="downloadIcon"></i>
            <svg id="spinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
            </svg>
        </button>
    </form>

    {{-- ❗ Error Display --}}
    @if ($errors->any())
        <div class="mb-6 p-4 border border-red-400 bg-red-100 text-red-700 rounded-md">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 📺 Video Info Display --}}
    @if(!empty($videoInfo))
        <div id="videoInfoSection" class="flex flex-col sm:flex-row gap-8">
            <!-- Thumbnail and Info -->
            <div class="text-center sm:text-left max-w-xs">
                <img src="{{ $videoInfo['thumbnail'] }}" class="rounded-md mb-4 w-full" alt="Thumbnail">
                <p class="font-semibold text-gray-800 dark:text-gray-200 text-lg mb-1">{{ $videoInfo['title'] }}</p>
                <p class="text-gray-600 dark:text-gray-400 mb-2">Duration: {{ gmdate('i:s', $videoInfo['duration'] ?? 0) }}</p>

                @if(!empty($videoInfo['description']))
                    <div class="text-sm text-gray-700 dark:text-gray-300 border-t border-gray-200 dark:border-gray-700 pt-2 mt-2 max-h-40 overflow-y-auto">
                        <strong class="text-orange-500">Description:</strong><br>
                        {{ Str::limit($videoInfo['description'], 500) }}
                    </div>
                @endif
            </div>

            <!-- Format List -->
            <div class="flex-1 border rounded-md shadow-sm 
                        bg-white dark:bg-gray-800 
                        border-gray-200 dark:border-gray-700">

                <!-- Header -->
                <div class="bg-orange-100 dark:bg-gray-700 
                            border-b border-gray-200 dark:border-gray-600 
                            px-4 py-2 flex items-center gap-2 
                            font-semibold text-orange-600 dark:text-orange-400">
                    <i class="fas fa-video"></i> Available Formats
                </div>

                <!-- Formats -->
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($videoInfo['formats'] as $format)
                        <div class="flex justify-between items-center px-4 py-3">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $format['quality'] }}</span>
                                    <span class="text-gray-600 dark:text-gray-400">{{ $format['ext'] }}</span>
                                </div>
                                <div class="text-gray-500 dark:text-gray-400 text-sm">
                                    Size: {{ $format['filesize'] ?? 'Unknown' }}
                                </div>
                            </div>

                            {{-- Download Button --}}
                            <form method="POST" action="{{ route('download.video') }}" target="_blank">
                                @csrf
                                <input type="hidden" name="url" value="{{ $videoUrl }}">
                                <input type="hidden" name="video_format_id" value="{{ $format['format_id'] }}">
                                <button type="submit" 
                                    class="bg-orange-500 hover:bg-orange-600 
                                           dark:bg-orange-600 dark:hover:bg-orange-700
                                           text-white px-4 py-2 rounded-md flex items-center gap-2 transition">
                                    <i class="fas fa-download"></i> Download
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

{{-- ⚙ Scripts --}}
@push('scripts')
<script>
function showLoadingInButton(event){
    const btn = document.getElementById("downloadBtn");
    const icon = document.getElementById("downloadIcon");
    const text = document.getElementById("buttonText");
    const spinner = document.getElementById("spinner");

    icon.classList.add('hidden');
    spinner.classList.remove('hidden');
    text.textContent = "Processing...";
    btn.disabled = true;
    btn.classList.add('opacity-70', 'cursor-not-allowed');
}

// ---- Clear Input ----
const videoUrlInput = document.getElementById('videoUrlInput');
const clearBtn = document.getElementById('clearInputBtn');
const videoInfoSection = document.getElementById('videoInfoSection');

function updateClearBtn() {
    clearBtn.classList.toggle('hidden', videoUrlInput.value === '');
}

videoUrlInput.addEventListener('input', updateClearBtn);

clearBtn.addEventListener('click', () => {
    videoUrlInput.value = '';
    clearBtn.classList.add('hidden');
    videoUrlInput.focus();
    if(videoInfoSection) {
        videoInfoSection.innerHTML = '';
    }
});

window.onload = function() {
    window.history.replaceState({}, '', '/');
    fetch('https://downloader-ttg5.onrender.com/hello').then(() => {
        console.log('URL cleaned');
    });
};

// Show clear button if input already has value
updateClearBtn();
</script>
@endpush
@endsection
