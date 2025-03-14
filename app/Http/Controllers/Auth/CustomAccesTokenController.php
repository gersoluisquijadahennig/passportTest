<?php

namespace App\Http\Controllers\Auth;

use Laravel\Passport\Http\Controllers\AccessTokenController;

use Psr\Http\Message\ServerRequestInterface;

class CustomAccesTokenController extends AccessTokenController
{
    public function issueToken(ServerRequestInterface $request)
    {
        try {

            $response = parent::issueToken($request);


            \Log::info('CustomAccesTokenController '. $response);

            $content = json_decode($response->getContent(), true);

            $content['custom_data'] = [
                'issued_at' => now()->toIso8601String(),
                'client_ip' => request()->ip()
            ];

            return response()->json($content, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'invalid_request',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}