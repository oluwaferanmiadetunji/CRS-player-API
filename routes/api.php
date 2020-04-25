<?php

use Illuminate\Http\Request;
use App\Models\UserModel;
use Validator as validator;

Route::get('', function () {
  return response()->json([
    'success' => true,
    'message' => 'Welcome'
  ]);
});

Route::post('login', function (Request $request) {
  $email = $request->email;
  $query = UserModel::where('email', '=', $email);
  if ($query->count() > 0) {
    $data = $query->select('device_id', 'password')->first();
    return response()->json([
      'success' => true,
      'data' => $data,
      'message' => 'Login successful!'
    ], 200);
  } else {
    return response()->json([
      'success' => false,
      'message' => 'This email has not been registered'
    ], 200);
  }
});


//user registration
Route::post('register', function (Request $request) {
  $email = $request->email;
  $password = $request->password;
  $server = $request->server;
  $device_id = $request->device_id;
  $query = UserModel::where('email', '=', $email)->first()->get();
  if ($query->count() > 0) {
    return response()->json([
      'success' => false,
      'message' => 'This email has already been registered! Please, use another email address'
    ], 200);
  } else {
    $query = UserModel::where('device_id', '=', $device_id)->get();
    if ($query->count() > 0) {
      return response()->json([
        'success' => false,
        'message' => 'Error! Please, reload the page and try again'
      ], 200);
    } else {
      $user = UserModel::create($request->all());
      return response()->json([
        'success' => true,
        'message' => 'Registration successful'
      ], 201);
    }
  }
});
