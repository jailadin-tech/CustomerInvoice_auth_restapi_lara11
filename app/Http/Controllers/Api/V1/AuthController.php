<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\Api\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'hello'
        ]);
    }
    public function register(RegisterRequest $request): JsonResponse
    {

        try {
            $user = User::create(
                [
                    'name' => $request->name,
                    'phone_no' => $request->phone_no,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]
            );
            if ($user) {
                return ResponseHelper::success(message: 'User registerd successfuly!', data: $user, statusCode: 201);
            }
            return ResponseHelper::error(message: 'User registeration Failed!', statusCode: 400);
        } catch (Exception $e) {
            Log::error('Failed to register user ' . $e->getMessage());
            return ResponseHelper::error(message: 'User registeration Failed!' . $e->getMessage(), statusCode: 400);
        }
    }
    /**
     * Function : User login
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {

            if (!Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
                return ResponseHelper::error(message: 'Login Failed! Invalid Credentials', statusCode: 400);
            }
            $user = Auth::user();
            if ($user) {
                $adminToken = $user->createToken('adminToken', ['create', 'Update', 'Delete'])->plainTextToken;
                $updateToken = $user->createToken('updateToken', ['create', 'Update', 'Delete'])->plainTextToken;
                $basicToken = $user->createToken('basicToken', ['none'])->plainTextToken;
                $tokens = ['adminToken' => $adminToken, 'updateToken' => $updateToken, 'basicToken' => $basicToken];
                $authData = ['user' => $user, 'auth_tokens' => $tokens];

                return ResponseHelper::success(message: 'User Logged successfuly!', data: $authData, statusCode: 200);
            }
            return ResponseHelper::error(message: 'User registeration Failed!', statusCode: 400);
        } catch (Exception $e) {
            Log::error('Failed to login ' . $e->getMessage());
            return ResponseHelper::error(message: 'Failed! Invalid Credentials' . $e->getMessage(), statusCode: 400);
        }
    }
    /**
     * Function : User logout
     * @param NA
     * @return JsonResponse
     */
    public function userProfile(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user) {
                return ResponseHelper::success(message: 'User Details fetched successfully!', data: $user, statusCode: 200);
            }
            return ResponseHelper::error(message: 'No User Data not fetched!', statusCode: 400);
        } catch (Exception $e) {
            Log::error('Failed to fetched user data ' . $e->getMessage());
            return ResponseHelper::error(message: 'Failed! User Profile not fetched' . $e->getMessage(), statusCode: 400);
        }
    }

    /**
     * Function : User logout
     * @param NA
     * @return JsonResponse
     */
    public function userLogout(): JsonResponse
    {
        try {
            $user = Auth::user();
            if ($user) {
                $user->currentAccessToken()->delete();
                return ResponseHelper::success(message: 'Logout successfully!',  statusCode: 200);
            }
            return ResponseHelper::error(message: 'Unable to logout due to invalid token ', statusCode: 400);
        } catch (Exception $e) {
            Log::error('Unable to logout due to exception ' . $e->getMessage());
            return ResponseHelper::error(message: 'Unable to logout due to exception' . $e->getMessage(), statusCode: 400);
        }
    }
}
