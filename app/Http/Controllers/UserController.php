<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
  public function singup(Request $request)
  {

    $userconfirm = $request->validate([
      "name" => ["required", "string", "min:2", "max:255"],
      "email" => ["required", "email", "unique:users,email"],
      "password" => ["required", "string", "min:8", "max:30", "confirmed"]
    ]);

    $users = User::create([
      "name" => $userconfirm["name"],
      "email" => $userconfirm["email"],
      "password" => bcrypt($userconfirm["password"])
    ]);

    $token = $users->createToken("SECRET_KEY")->plainTextToken;
    return response([
      "user" => $users,
      "token" => $token
    ], 200);
  }


  public function login(Request $request)
  {
    $userconfirm = $request->validate([
      "email" => ["required", "email",],
      "password" => ["required", "string", "min:8", "max:30"]
    ]);
    $user = User::where("email", $userconfirm["email"])->first();
    if (!$user) return response(['message' => "Aucun utilisateur de trouver avec l'email suivant $userconfirm[email]"], 401);
    if (!Hash::check($userconfirm["password"], $user->password)) {
      return response(['message' => "Aucun utilisateur de trouver avec ce mot de passe"], 401);
    }

    $token = $user->createToken("SECRET_KEY")->plainTextToken;
    return response([
      "user" => $user,
      "token" => $token
    ], 200);
  }

  public function logout(Request $request)
  {
    $accessToken = $request->bearerToken();
    $token = PersonalAccessToken::findToken($accessToken);
    $token->delete();
    return response()->json([
      "status" => true,
      "message" => "Logout successful",
    ]);
  }



  public function GetAuthUser(Request $request)
  {
    $user = $request->user();
    if ($user) {
      return $user;
    } else {
      return response()->json(
        [
          'authenticated' => false
        ]
      );
    }
  }
}
