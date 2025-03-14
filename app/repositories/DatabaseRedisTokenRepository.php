<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Redis;
use Laravel\Passport\TokenRepository as BaseTokenRepository;
use Laravel\Passport\Token;
use Laravel\Passport\Passport;
use Carbon\Carbon;
use Log;

class DatabaseRedisTokenRepository extends BaseTokenRepository
{
    public function create($attributes)
    {
        log::info('attributes Token created: ' . json_encode($attributes));
        $token = Passport::token()->create($attributes);

        /*try {
            $expiresAt = Carbon::parse($token->expires_at);
            $ttl = $expiresAt->diffInSeconds(Carbon::now());
            Redis::setex('oauth:user:' . $token->user_id, $ttl, $token->id);
        } catch (\Exception $e) {
            Log::error('Redis error: ' . $e->getMessage());
        }*/

        log::info('Token created: ' . $token);

        return $token;
    }

}
