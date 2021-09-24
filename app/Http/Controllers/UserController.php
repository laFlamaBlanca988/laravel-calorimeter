<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function index()
    {
        $user = new User;
        $userID = Auth::user()->id;
        $currentUser = $user->getUser($userID);
        return view('pages.userEdit', [
            'user' => $currentUser,
        ]);
    }

    public function editUserControl(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'max:50', 'min:3'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:4', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()->first(),
            ]);
        } else {
            $user = new User;
            $userID = Auth::user()->id;
            $username = $request->input('username');
            $email = $request->input('email');
            $password = $request->input('password');

            $editedUser = $user->editUser($userID, $username, $email, $password);

            if ($editedUser) {
                return response()->json([
                    'status' => 200,
                    'message' => 'User edited successfully!',
                ]);
            }

            return response()->json([
                'status' => 400,
                'message' => 'Something went wrong. Please try again later.',
            ]);
        }
    }
}
