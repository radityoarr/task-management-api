<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserDetailResource;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        // return response()->json(['data'=>$post]);
        return UserResource::collection($users);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return new UserDetailResource($user);
        
    }
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name'        => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 422);
        }

        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());


        $user = User::create([
            'name'     => $request->name,
            'email'   => $request->email,
            'password'   => $request->password,
            'image'     => $image->hashName()
        ]);

        return new UserDetailResource($user);

    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'string',
            'email'       => [ 'email', Rule::unique('users', 'email')->ignore($request->id),],
            'password' => 'string',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        if ($validated->fails()) {
            return response()->json($validated->errors(), 422);
        }
    
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }
    
        $data = $request->only(['name', 'email', 'password']);
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/users', $image->hashName());
    
            Storage::delete('public/users/' . basename($user->image));
    
            $data['image'] = $image->hashName();
        }
    
        $user->update($data);
    
        return new UserDetailResource($user);
    }
    

    public function destroy($id)
    {
        $user = user::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
