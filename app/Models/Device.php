<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'device_token_hash',
        'ip_hash',
        'user_agent',
    ];

    public static function existsForRequest($request): bool
    {
        $token = $request->header('X-Device-Token');
        $ip = $request->ip();

        return self::where('device_token', $token)
                    ->orWhere('ip_address', $ip)
                    ->exists();
    }

    public static function registerFromRequest($request): self
    {
        return self::create([
            'device_token' => $request->header('X-Device-Token'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }
}
