<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message',
            'bot' => 'nullable|string|max:100',
        ]);

        $userMessage = $request->message;
        $botName = $request->bot ?? 'Support Bot';

        $apiKey = env('GEMINI_API_KEY'); // Add your key in .env

        // Add personality depending on bot
        $prompt = match($botName) {
            'Sales Bot' => "You are a helpful and persuasive sales assistant.\nUser: $userMessage",
            'AI Tutor' => "You are a patient AI tutor. Explain clearly and simply.\nUser: $userMessage",
            default => "You are a helpful support bot.\nUser: $userMessage",
        };

        try {
            $response = Http::post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ]
                ]
            );

            if ($response->failed()) {
                return response()->json([
                    'reply' => 'Error from AI service: ',
                ], 500);
            }

            $reply = $response->json('candidates.0.content.parts.0.text') ?? 'No response from AI';

            return response()->json([
                'reply' => $reply,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'reply' => 'abc: ' . $e->getMessage(),
            ], 500);
        }
    }
}
