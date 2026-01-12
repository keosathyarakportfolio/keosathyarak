<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'history' => 'nullable|array',
            'bot' => 'nullable|string|max:100',
        ]);

        $userMessage = $request->message;
        $botName = $request->bot ?? 'Support Bot';
        $history = $request->history ?? [];

        $apiKey = env('GEMINI_API_KEY');

        $systemPrompt = match($botName) {
            'Sales Bot' => "You are a helpful and persuasive sales assistant.",
            'AI Tutor' => "You are a patient AI tutor. Explain clearly and simply.",
            default => "You are a helpful support bot.",
        };

        $contents = [
            [
                'role' => 'user',
                'parts' => [
                    ['text' => $systemPrompt]
                ]
            ]
        ];

        foreach ($history as $msg) {
            if (isset($msg['role'], $msg['parts'])) {
                $contents[] = [
                    'role' => $msg['role'],
                    'parts' => $msg['parts']
                ];
            }
        }

        $contents[] = [
            'role' => 'user',
            'parts' => [
                ['text' => $userMessage]
            ]
        ];

        try {
            $response = Http::post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}",
                [
                    'contents' => $contents
                ]
            );

            if ($response->failed()) {
                return response()->json([
                    'reply' => 'Error from AI service.',
                ], 500);
            }

            $replyText = $response->json('candidates.0.content.parts.0.text') ?? 'No response from AI';

            return response()->json([
                'reply' => $replyText,
                'role' => 'model',
                'parts' => [['text' => $replyText]],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'reply' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
