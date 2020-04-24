<?php

use Illuminate\Http\Request;
use App\Models\UserModel;
use Validator as validator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('', function () {
  return response()->json([
    'success' => true,
    'message' => 'Welcome'
  ]);
});

Route::post('login', function (Request $request) {
  $email = $request->email;
  $user = UserModel::select('device_id', 'password')->where('email', '=', $email)->get();
  return response()->json([
    'data' => $user
  ]);
});
// user login
// Route::post('login', function (Request $request) {
//   $device_id = $request->device_id;
//   $email = $request->email;
//   $password = $request->password;
//   $questions = UserModel::select('email', 'password', 'server', 'device_id')->where('email', '=', $email)->get();
//   return response()->json([
//     'data'->$questions
//   ]);
//   if ($query->count() > 0) {
//   $user_device_id = $query->select('device_id')->first();
//   $user_password = $query->select('password')->first();
//   if ($user_device_id != $device_id) {
//     return response()->json([
//       'message' => 'Please login with the device you registered with!',
//       'error' => true
//     ], 403);
//   } else {
//     if ($user_password != $password) {
//       return response()->json([
//         'message' => 'Incorrect credentials. Check your details again',
//         'error' => true
//       ], 403);
//     } else {
//       return response()->json([
//         'message' => 'Login successful',
//         'error' => false
//       ], 200);
//     }
//   }
//   } else {
//     return response()->json([
//       'message' => 'User not found',
//       'error' => true
//     ], 404);
//   }
// });


//user registration
Route::post('register', function (Request $request) {
  $rules = [
    'password' => 'required',
    'email' => 'required|unique:desktop_users',
    'server' => 'required',
    'device_id' => 'required|unique:desktop_users',
  ];
  $validator = validator::make($request->all(), $rules);
  if ($validator->fails()) {
    return response()->json([
      $validator->errors(),
      'success' => 'false',
    ], 400);
  }
  $user = UserModel::create($request->all());
  return response()->json([
    'data' => $user,
    'success' => true,
    'message' => 'Successfully registered'
  ], 201);
});
