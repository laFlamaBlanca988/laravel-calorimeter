<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ManagerController extends Controller
{

    public function index()
    {
        $meals = new Meal;
        $users = new User;
        $usersAll = $users->getAllUsers();
        $usersManager = $users->getManagerUsers();
        $userID = Auth::user()->id;
        $userMeals = $meals->getMealsForUser($userID);
        $mealsAll = $meals->getAllMeals();
        return view('admin.admin', [
            'userMeals' => $userMeals,
            'usersManager' => $usersManager,
            'users' => $usersAll,
            'meals' => $mealsAll
        ]);
    }

    public function editUser(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'username' => ['required', 'max:255', 'min:3'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:4', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()->first()
            ]);
        } else {
            $user = new User;
            $userID = $request->json()->get('id');
            $name = $request->input('name');
            $username = $request->input('username');
            $email = $request->input('email');
            $password = $request->input('password');

            $editedUser = $user->editUser($userID, $name, $username, $email, $password);

            if ($editedUser) {
                return response()->json([
                    'status' => 200,
                    'message' => 'User edited successfully!'
                ]);
            }

            return response()->json([
                'status' => 400,
                'message' => 'Something went wrong. Please try again later.'
            ]);
        }
    }

    public function managerUserDelete(Request $request): JsonResponse
    {
        $user = new User;
        $meal = new Meal;
        $userID = $request->json()->get('id');
        $deletedMeals = $meal->deleteUserMeals($userID);
        $deletedUser = $user->deleteUser($userID);

        if ($deletedUser && $deletedMeals) {
            return response()->json([
                'status' => 200,
                'message' => 'User successfully deleted'
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => 'Something went wrong. Please try again later.'
        ]);

    }
}
