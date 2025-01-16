<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class CustomRateLimiter
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  int  $maxAttempts  Maximum allowed requests
   * @param  int  $decaySeconds  Time period in seconds
   * @return mixed
   */
  public function handle(Request $request, Closure $next, $maxAttempts = 10, $decaySeconds = 60)
  {
    // Generate a unique cache key for the request
    $key = $this->resolveKey($request);

    // Increment the request count in the cache
    $currentAttempts = Cache::get($key, 0) + 1;

    // Track expiration time manually
    if (!Cache::has($key)) {
      Cache::put($key, $currentAttempts, $decaySeconds);
      Cache::put($key . ':expiration', time() + $decaySeconds, $decaySeconds);
    } else {
      Cache::increment($key);
    }

    // Retrieve the retryAfter time
    $retryAfter = Cache::get($key . ':expiration') - time();
    if($retryAfter < 0){
      $retryAfter = 0;
    }

    // Check if the user exceeded the rate limit
    if ($currentAttempts > $maxAttempts) {
      return response()->json([
        'message' => 'Too many requests from '. $request->ip() .'. Please try again later.',
        'retry_after_seconds' => $retryAfter
      ], 429);
    }

    // Allow the request to proceed
    $remainingAttempts = max(0, $maxAttempts - $currentAttempts);

    $response = $next($request);

    // Add rate-limit headers and other data
    return $response
      ->header('X-RateLimit-Limit', $maxAttempts)
      ->header('X-RateLimit-Remaining', $remainingAttempts)
      ->header('X-RateLimit-Reset', $retryAfter);
  }

  /**
   * Resolve a unique key for the request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return string
   */
  protected function resolveKey(Request $request)
  {
    return sprintf('rate_limit:%s:%s', $request->ip(), $request->route()->getName() ?? 'default');
  }
}
