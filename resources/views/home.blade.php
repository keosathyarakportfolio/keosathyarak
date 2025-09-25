@extends('layouts.app')

@section('title', 'Download Video')

@section('content')
<div class="max-w-4xl mx-auto">
    <h2 class="text-3xl font-semibold mb-6 text-center">Enter a video link to download</h2>

    <form method="POST" action="{{ route('getvideo') }}" class="flex flex-col sm:flex-row gap-4 mb-6" onsubmit="showLoadingInButton(event)">
        @csrf
        <input name="videoUrl" type="url" placeholder="YouTube, Facebook, TikTok URL, Instagram" value="{{ old('videoUrl', $videoUrl ?? '') }}" class="flex-grow px-4 py-3 border rounded-md" required />
        <button id="downloadBtn" type="submit" class="bg-orange-500 text-white px-6 py-3 rounded-md flex items-center justify-center gap-2 hover:bg-orange-600 transition">
            <span id="buttonText">Get Video</span>
            <i class="fas fa-arrow-right" id="downloadIcon"></i>
            <svg id="spinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
            </svg>
        </button>
    </form>

    @if ($errors->any())
        <div class="mb-6 p-4 border border-red-400 bg-red-100 text-red-700 rounded-md">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </ul>
        </div>
    @endif

    @if(!empty($videoInfo))
    <div class="flex flex-col sm:flex-row gap-8">
        <div class="text-center sm:text-left max-w-xs">
            <img src="{{ $videoInfo['thumbnail'] }}" class="rounded-md mb-4" width="280">
            <p class="font-semibold text-gray-800">{{ $videoInfo['title'] }}</p>
            <p class="text-gray-600">Duration: {{ gmdate('i:s', $videoInfo['duration'] ?? 0) }}</p>
        </div>

        <div class="flex-1 border rounded-md shadow-sm bg-white">
            <div class="bg-orange-100 border-b px-4 py-2 flex items-center gap-2 font-semibold text-orange-600">
                <i class="fas fa-video"></i> Available Formats
            </div>
            <div class="divide-y">
                @foreach($videoInfo['formats'] as $format)
                <div class="flex justify-between items-center px-4 py-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-gray-800">{{ $format['quality'] }}p</span>
                            <span class="text-gray-600">{{ $format['ext'] }}</span>
                        </div>
                        <div class="text-gray-500 text-sm">Size: {{ $format['filesize'] ?? 'Unknown' }}</div>
                    </div>
                    <form method="GET" action="{{ route('download.video') }}" target="_blank">
    <input type="hidden" name="url" value="{{ $videoUrl }}">
    <input type="hidden" name="video_format_id" value="{{ $format['format_id'] }}">
    <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-md flex items-center gap-2 hover:bg-orange-600 transition">
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
</script>
@endpush
@endsection
