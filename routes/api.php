<?php

use App\Http\Resources\EmployeesResource;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/employees', function (){
  $employees=Employees::orderBy('lastname') -> get();
  return EmployeesResource::collection($employees);
});
