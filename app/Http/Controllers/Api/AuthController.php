<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
  /**
   * Get a JWT token via given credentials.
   *
   * @param  \Illuminate\Http\Request  $request
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(Request $request)
  {
      $credentials = $request->only('email', 'password');

      if ($token = auth()->attempt($credentials)) {
          return $this->respondWithToken($token, $credentials);
      }

      return response()->json(['error' => 'Unauthorized'], 401);
  }
  /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    public function me()
    {
        return response()->json(auth()->user());
    }
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }


  /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $credentials)
    {
        $verificar_email = User::select('id','name','email')->where('email','=',$credentials['email'])->first();
        
        return response()->json([
            'user' => $verificar_email,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
