<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserUpdateRequest;
use App\Actions\Fortify\UpdateUserPassword;

class ProfileController extends Controller
{

    public function index(Request $request)
    {

      return  $request->user()->only(['id','name','email','role','avatar']);

    }

    public function update(Request $request)
    {

        $validate = $request->validate([
            'name' => ['required','string'],
            'email' =>['required','email', Rule::unique('users')->ignore($request->user()->id)]
        ]);
        $request->user()->update($validate);

          return response()->json(['message' => 'success']);
    }

    public function upload_image(Request $request)
    {

         if($request->hasFile('profile_picture'))
         {
            $previousPath = $request->user()->getRawOriginal('avatar');

            $link = Storage::put('/photos', $request->file('profile_picture'));

            $request->user()->update(['avatar'=> $link]);

            Storage::delete($previousPath);
         }

         return response()->json(['message' => 'success']);
    }


    public function changePassword(Request $request, UpdateUserPassword $updater)
        {
            //return $request->all();
            $updater->update(auth()->user(), [

            'current_password' => $request->currentPassword,
            'password' => $request->password,
            'password_confirmation' => $request->passwordConfirmation,
           ]);

           return response()->json(['message' => 'success']);

    }

}
