<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\UserApiRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends BaseController
{
    /**
     * List All Users
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $users = User::all();
            return $this->sendResponse($users, 'Success!');
        } catch (\Exception $exception) {
            info('Error::Place@UserController@index - ' . $exception->getMessage());
            return $this->sendError('Error.', 'Something went wrong', 500);
        }
    }

    /**
     * @param UserApiRequest $request
     * @return JsonResponse
     */
    public function store(UserApiRequest $request)
    {
        try {
            $input = $request->only('name', 'email', 'phone', 'dob', 'password');
            User::create($input);

            return $this->sendResponse([], 'User Created Successfully!');
        } catch (\Exception $exception) {
            info('Error::Place@UserController@store - ' . $exception->getMessage());
            return $this->sendError('Error.', 'Something went wrong', 500);
        }
    }

    /**
     * Get single user details
     * @return JsonResponse
     */
    public function show(User $user)
    {
        try {
            return $this->sendResponse($user, 'Success!');
        } catch (\Exception $exception) {
            info('Error::Place@UserController@show - ' . $exception->getMessage());
            return $this->sendError('Error.', 'Something went wrong', 500);
        }
    }

    /**
     * Update single user details
     * @return JsonResponse
     */
    public function update(UserApiRequest $request, User $user)
    {
        try {
            $input = $request->only('name', 'email', 'phone', 'dob', 'password');
            $user->update($input);
            return $this->sendResponse([], 'Success!');
        } catch (\Exception $exception) {
            info('Error::Place@UserController@update - ' . $exception->getMessage());
            return $this->sendError('Error.', 'Something went wrong', 500);
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return $this->sendResponse([], 'Deleted Successfully!');
        } catch (\Exception $exception) {
            info('Error::Place@UserController@destroy - ' . $exception->getMessage());
            return $this->sendError('Error.', 'Something went wrong', 500);
        }
    }
}
