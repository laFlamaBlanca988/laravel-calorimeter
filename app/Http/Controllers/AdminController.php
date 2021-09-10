<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{

    public function index()
    {
        $meals = new Meal;
        $users = new User;
        $usersAll = $users->getAllUsers();
        $userID =  Auth::user()->id;
        $userMeals = $meals->getMealsForUser($userID);
        $mealsAll = $meals->getAllMeals();
//        $totalCalories = 0;
//        foreach ($userMeals as $mealsData) {
//            $totalCalories += $mealsData->cal_num;
//        }
        return view('admin.admin', [
            'meals' => $userMeals,
            'usersAll' => $usersAll,
            'mealsAll' => $mealsAll
        ]);
    }

    public function editUser(Request $request): \Illuminate\Http\JsonResponse
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
                'errors' => $validator->messages(),
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
                    'message' => 'User edited successfully!',
                ]);
            }

            return response()->json([
                'status' => 400,
                'message' => 'Something went wrong. Please try again later.',
            ]);
        }
    }

    public function displayUserMeals(Request $request): \Illuminate\Http\JsonResponse
    {
        $meal = new Meal;
        $userID = $request->json()->get('id');
        $userMeals = $meal->getMealsForUser($userID);
        if($userMeals) {
            return response()->json([
                'status' => 200,
                'userMeals' => $userMeals
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => 'Something went wrong. Please try again later.',
        ]);
    }

    public function updateUserAccess (Request $request): \Illuminate\Http\JsonResponse
    {
        $users = new User;
        $userID = $request->json()->get('id');
        $roleID = $request->input('name');
        $user = $users->getUser($userID);
        if($user) {
            return response()->json([
                'status' => 200,
                'userMeals' => $user
            ]);
        }
    }
}
