<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Image\ValidateImageRequest;
use App\Models\Image;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ImageController extends Controller
{
    //
    use HttpResponses;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['userProfileImage']);
    }

    public function userProfileImage(ValidateImageRequest $request){
        
        // validating image
       $request->validated();
       $user = User::find($request->user()->id);
       $filePath = $request->file('image')->store('image/' . $request->user()->name,'public');
        
    
       $userProfile = Image::where('user_id',$user->id)->first();

       if($userProfile)
       {
        $user->profileImage()->update(['url' => $filePath]);
       }else {
        $user->profileImage()->create(['url' => $filePath]);
       }

        // $fileName = uniqid() . "_" . $file->getClientOriginalName();
        // $file->move(public_path('public/images/user' . $userName), $fileName);
        // $url = URL::to('/') . '/public/images/user/' . $userName . '/' . $fileName;
        // $user->profileImage()->create(['url' => $url]);

        return $this->success([
            "url" => $filePath
        ],"successfully upload profile picture");
    }

}
