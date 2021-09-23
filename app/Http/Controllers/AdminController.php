<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\JsonResponse;
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
        $usersManager = $users->getManagerUsers();
        $userID = Auth::user()->id;
        $userMeals = $meals->getMealsForUser($userID);
        $mealsAll = $meals->getAllMeals();

        return view('admin.admin', ['userMeals' => $userMeals, 'users' => $usersAll, 'usersManager' => $usersManager, 'meals' => $mealsAll]);
    }

    public function editUser(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:50'],
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

            $editedUser = $user->adminEditUser($userID, $name, $username, $email, $password);

            if ($editedUser) {
                return response()->json(['status' => 200, 'message' => 'User edited successfully!',]);
            }

            return response()->json(['status' => 400, 'message' => 'Something went wrong. Please try again later.',]);
        }
    }

    public function displayUserMeals(Request $request): JsonResponse
    {
        $meal = new Meal;
        $userID = $request->json()->get('id');
        $userMeals = $meal->getMealsForUser($userID);
        if ($userMeals) {
            return response()->json([
                'status' => 200,
                'userMeals' => $userMeals
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => 'Something went wrong. Please try again later.'
            ]);
    }

    public function updateUserAccess(Request $request): JsonResponse
    {
        $users = new User;
        $userID = $request->json()->get('id');
        $roleID = $request->json()->get('roleID');
        $dbRoleID = $users->getUser($userID)[0]->role_id;
        $accessEdit = $users->editUserAccess($userID, $roleID);
        if ($dbRoleID == $roleID) {
            return response()->json(['status' => 400, 'message' => 'User already registered with given credentials']);
        }
        if ($accessEdit) {
            return response()->json(['status' => 200, 'message' => 'User access edited successfully']);
        }

        return response()->json(['status' => 400, 'message' => 'Something went wrong. Please try again later.',]);
    }

    public function adminUserDelete(Request $request): JsonResponse
    {
        $user = new User;
        $meal = new Meal;
        $userID = $request->json()->get('id');
        $deletedMeals = $meal->deleteUserMeals($userID);
        $deletedUser = $user->deleteUser($userID);

        if ($deletedUser || $deletedMeals) {
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

    public function fetchAllMeals(Request $request): string
    {
        if($request->ajax()){
            $meal = new Meal;
            $meals = $meal->getAllMeals();
            return view('pages.adminMealsPagination', compact('meals'))->render();
        }
        return response()->json([
            'status' => 400,
            'message' => 'Something went wrong. Please try again later.'
        ]);
    }

    public function userSearch(Request $request) {
        $users = new User;
        $userName = $request->json()->get('name');
        $user = $users->searchUserByName($userName);
        if ($user) {
            return response()->json(['status' => 200, 'user' => $user]);
        }
    }
}
