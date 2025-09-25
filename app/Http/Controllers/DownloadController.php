<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class DownloadController extends Controller
{
    private $pythonApi;

    public function __construct()
    {
        // Read from environment variable
        $this->pythonApi = env('PYTHON_API', 'https://backend-4ix7.onrender.com');
    }

    public function showForm()
    {
        dd($this->pythonApi);
        return view('home', [
            'videoUrl' => '',
            'videoInfo' => null
        ]);
    }

    public function getVideo(Request $request)
    {
        $request->validate(['videoUrl' => 'required|url']);
        $url = $request->input('videoUrl');

        try {
            $response = Http::timeout(30)->get($this->pythonApi . "/get-video", ['url' => $url]);

            if ($response->failed()) {
                return back()->withErrors(['videoUrl' => 'បរាជ័យក្នុងការទាញព័ត៌មានវីដេអូ']);
            }

            $videoInfo = $response->json();
            return view('home', ['videoUrl' => $url, 'videoInfo' => $videoInfo]);

        } catch (\Exception $e) {
            return back()->withErrors(['videoUrl' => $e->getMessage()]);
        }
    }

    public function downloadVideo(Request $request)
    {
        $url = $request->query('url');
        $formatId = $request->query('video_format_id');

        $downloadUrl = $this->pythonApi . "/download-video?url=" . urlencode($url) . "&video_format_id=" . urlencode($formatId);
        return redirect()->away($downloadUrl);
    }
}
