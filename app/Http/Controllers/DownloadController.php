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
        $this->pythonApi = env('PYTHON_API', 'https://downloader-v24x.onrender.com/');
    }

    public function showForm()
    {
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
    $url = $request->input('url');
    $formatId = $request->input('video_format_id');

    // Send POST request to Python API
    $response = Http::asForm()->post($this->pythonApi . '/download', [
        'url' => $url,
        'format_id' => $formatId,
    ]);

    // Return file response directly if Python API returns the file
    return response($response->body(), 200)
        ->header('Content-Type', $response->header('Content-Type'))
        ->header('Content-Disposition', $response->header('Content-Disposition'));
}
}
