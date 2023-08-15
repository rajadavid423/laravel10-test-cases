<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends BaseController
{
    /**
     * Register api
     *
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50'],
            'password' => ['required', 'string', 'min:8', 'max:16'],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $user = User::create($request->all());

        return $this->sendResponse($user, 'User registered successfully!', 201);
    }

    /**
     * Login api
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'max:50'],
            'password' => ['required', 'string', 'min:8', 'max:16'],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['token_type'] = 'Bearer';
            $success['user'] = $user;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Invalid Login Details'], 401);
        }
    }

    /**
     * Logout api
     *
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->sendResponse(null, 'You have been successfully logged out!');
    }

    /**
     * Profile api
     *
     * @return JsonResponse
     */
    public function profile(Request $request)
    {
        return $this->sendResponse(Auth::user(), 'Success!');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => ['required', 'string', 'max:16'],
            'password' => ['required', 'string', 'min:8', 'max:16'],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $user = Auth::user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->update(["password" => $request->password]);
            return $this->sendResponse(null, 'Password Changed Successfully!');
        }
        return $this->sendError('ERROR', ['error' => 'Invalid Old Password'], 422);
    }

    /**
     * Profile Update
     *
     * @return JsonResponse
     */
    public function profileUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100|string',
            'phone' => 'required|integer|digits:10',
            'dob' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $user = Auth::user();
        $input = $request->only('name', 'phone', 'dob', 'email');
        $user->update($input);
        return $this->sendResponse([], 'User Details Updated!');
    }
}
