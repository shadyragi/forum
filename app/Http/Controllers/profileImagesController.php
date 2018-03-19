<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

class profileImagesController extends Controller
{
    //
    public function store(Request $request, $id)
    {
    		$user = User::findOrFail($id);

    		$this->authorize('upload-photo', $user);


    		
    		if($request->hasFile('avatar'))
    		{
    			$this->validate($request, [
    				'avatar' => 'required|image'
    			]);



	    		$file = request()->file('avatar')->move('public', 'image.' . $user->id . '.jpg' );

	    		$user->avatar_path = $file->getPathname();

	    		$user->save();

	    		return back();
    		}

            return back();

    }
}
