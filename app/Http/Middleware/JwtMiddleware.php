<?php

    namespace App\Http\Middleware;

    use Closure;
    use JWTAuth;
    use Exception;
    use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

    class JwtMiddleware extends BaseMiddleware
    {

        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next)
        {
            try {
                $user = JWTAuth::parseToken()->authenticate();
            } catch (Exception $e) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                    // return response()->json(['status' => 'Token is Invalid']);
                    return response()->json([
                        'success' => false,
                        'message' =>'Token is Invalid',
                    ], 200);
                } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                    // return response()->json(['status' => 'Token is Expired']);
                    return response()->json([
                        'success' => false,
                        'message' =>'Token is Expired',
                    ], 200);
                } else {
                    // return response()->json(['status' => 'Authorization Token not found']);
                    return response()->json([
                        'success' => false,
                        'message' =>'Authorization Token not found',
                    ], 200);
                }
            }
            return $next($request);
        }
    }
