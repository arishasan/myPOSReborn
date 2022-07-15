<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HelperApiModel;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        // $this->middleware('jwt:verify', ['except' => ['login','register']]);
        $this->guard = "api";
    }

    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        //validate incoming request
        // $this->validate($request, [
        //     'username' => 'required|string|unique:users',
        //     'password' => 'required|confirmed',
        // ]);

        // try {
        //     $user = new User;
        //     $user->username= $request->input('username');
        //     $user->password = app('hash')->make($request->input('password'));
        //     $user->save();

        //     return response()->json([
        //                 'entity' => 'users',
        //                 'action' => 'create',
        //                 'result' => 'success'
        //     ], 201);
        // } catch (\Exception $e) {
        //     return response()->json([
        //                'entity' => 'users',
        //                'action' => 'create',
        //                'result' => 'failed'
        //     ], 409);
        // }
    }
    
    /**
    * Get a JWT via given credentials.
    *
    * @param  Request  $request
    * @return Response
    */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' =>'Email/Password required',
            ], 200);
        }

        $credentials = $request->only(['email', 'password']);
        //10080
        if (! $token = auth($this->guard)->setTTL(10080)->attempt($credentials)) {
            // return response()->json(['message' => 'Unauthorized'], 401);
            return response()->json([
                'success' => false,
                'message' =>'Email/password yang Anda masukkan salah',
            ], 200);
        }

        // $user = Auth::user();

        $s = HelperApiModel::arrayAksesThisUser();
        $cekAkses = HelperApiModel::allowedAccess(4, 0);

        if ($cekAkses==false) {
            return response()->json([
                'success' => false,
                'message' =>'Unauthorized access',
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' =>'login succeeded',
            'token'    => $token,
            'token_type'    => "bearer",
            // 'expires_in' => auth($this->guard)->factory()->getTTL(),
            // 'data'=>$user
        ], 200);
        // return $this->respondWithToken($token);
    }
    
    /**
    * Get user details.
    *
    * @param  Request  $request
    * @return Response
    */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth($this->guard)->logout();

        return response()->json([
            'success' => true,
            'message' =>'User successfully signed out',
        ], 200);
    }


    public function refresh()
    {
        $newToken = auth($this->guard)->setTTL(10080)->refresh();
    
        return response()->json([
            'success' => true,
            'message' =>'refresh succeeded',
            'token'    => $newToken,
            'token_type'    => "bearer",
            // 'expires_in' => auth($this->guard)->factory()->getTTL(),
            // 'data'=>$user
        ], 200);
    }

    /**
    * Get the token array structure.
    *
    * @param  string $token
    *
    * @return \Illuminate\Http\JsonResponse
    */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth($this->guard)->factory()->getTTL() * 60,
        ]);
    }

    public function getUser()
    {
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'message' =>'user data',
            'data'=>$user->only('name', 'email', 'mobile_phone', 'photo_url', 'status')
        ], 200);
        // return response()->json(auth()->user());
    }
}
