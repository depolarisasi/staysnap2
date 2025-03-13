<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch;

use Spatie\Permission\Models\Role;

use App\Http\Requests\UserRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Traits\HandlesImageUploads;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{ 
    use HandlesImageUploads; 

    protected $imageDirectory = 'profile_pictures';
    protected $imageWidth = 5000;
    protected $imageHeight = 5000;
    protected $imageQuality = 80;
    protected $imageFieldName = 'profile_picture';
    
    public function index(){
        $users = User::with('branch')->get();
        $roles = Role::all();
        $branches = Branch::all();
        return view('users.index', compact('users', 'roles', 'branches')); 
    }

    public function edit($id){
        $user = User::find($id);
        $roles = Role::all();
        $branches = Branch::all();
        return view('users.edit', compact('user', 'branches','roles'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'branch_id' => 'nullable', 
            'role' => 'required|string|exists:roles,name',
            'phone_number' => 'nullable|string|max:20', 
            $this->imageFieldName => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048|dimensions:max_width=2000,max_height=2000'
        ]);
    
        // Check validation
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            $errorMessage = implode('<br>', $errorMessages);
            alert()->error('Validation Error', $errorMessage);
            return redirect()->back();
        }
        $data = $request->all();
        if ($request->hasFile($this->imageFieldName)) {
            $data[$this->imageFieldName] = $this->processAndStoreImage(
                $request->file($this->imageFieldName)
            );
        }
        try {
            // Create user
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'branch_id' => $data['branch_id'],
                'role' => $data['role'],
                'phone_number' => $data['phone_number'],
                'profile_picture' => $data[$this->imageFieldName] ?? null
            ]);
    
            // Assign roles by name
            $user->syncRoles($data['role']);
        } catch (\Exception $e) {
            alert()->error('Error', $e->getMessage());
            return redirect('management/user');
        } 

        alert()->success('Success','Added Successfully');
        return redirect('management/user');
    }

    public function update(Request $request, User $user){ 
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id . ',id',
            'password' => 'nullable',
            'branch_id' => 'nullable|exists:branches,id', // Added exists validation
            'role' => 'required|string|exists:roles,name',
            'phone_number' => 'nullable|string|max:20',
            $this->imageFieldName => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048|dimensions:max_width=2000,max_height=2000'
        ]);
        
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            $errorMessage = implode('<br>', $errorMessages);
            alert()->error('Validation Error', $errorMessage);
            return $validator->errors()->all();
        }

        $data = $request->all(); 
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile($this->imageFieldName)) {
            $this->deleteOldImage($user->{$this->imageFieldName});
            $data[$this->imageFieldName] = $this->processAndStoreImage(
                $request->file($this->imageFieldName)
            );
        }

        try { 
        $user->update($data);
        $user->syncRoles([$data['role']]);
        } catch (\Exception $e) {
            alert()->error('Error', $e->getMessage());
            return $e;
        }
 

        alert()->success('Success','Updated Successfully');
        return redirect('management/user'); 
    }

    public function destroy($id){
        $user = User::find($id);

        try { 
            $user->delete(); 
        } catch (\Exception $e) {
            alert()->error('Error', $e->getMessage());
            return redirect()->back();
        }
 

        alert()->success('Success','Deleted Successfully');
        return redirect('management/user');
 
    }

    private function imageValidationRules()
    {
        return 'nullable|image|mimes:jpeg,png,webp|max:2048|dimensions:max_width=2000,max_height=2000';
    }

    
}
