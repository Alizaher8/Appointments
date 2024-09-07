<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\PhotoUploadTrait;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {

        $users = User::query()
        ->when(request('query'), function ($query,$searchQuery){

            $query->where('name', 'like', "%{$searchQuery}%");
        })
       ->latest()
       ->paginate(settings('pagination_limit'));

        return $users;
    }
    public function add(UserRequest $request){

        //$jsonImagePaths = $this->saveImage($request->file('photo'));

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => bcrypt($request->input('password')),
            //'photo' => $jsonImagePaths
        ]);

        return response()->json(['user' => $user]);
    }

    public function update (User $user, UserUpdateRequest $request) {



        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => $request->input('password') ? bcrypt($request->input('password')) : $user->password,
            //'photo' => $request->hasFile('photo') ? $this->saveImage($request->file('photo')) : $user->photo,
        ]);

       return $user;
    }

    public function delete (User $user) {

         $user->delete();

      return response()->noContent();

  }

  public function changeRole(User $user){


      $user->update([
         'role' => request('role'),

      ]);
    return response()->json(['susses' => true]);
  }



  public function  bulkDelete(){

    User::whereIn('id', request('ids'))->delete();

   return response()->json(['message' => 'User Delete Successfully']);


  }
}
