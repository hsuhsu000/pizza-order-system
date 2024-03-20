<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //direct change password page
    public function changePasswordPage()
    {
        return view('admin.account.changePassword');
    }

    //change password
    public function changePassword(Request $request)
    {
        $this->passwordValidationCheck($request);

        $user = User::select('password')->where('id', Auth::user()->id)->first();
        $dbHash = $user->password; //get dbhash password

        if (Hash::check($request->oldPassword, $dbHash)) {
            $data = [
                'password' => Hash::make($request->newPassword)
            ];
            User::where('id', Auth::user()->id)->update($data);
            return back()->with(['changeSuccess' => 'Password has been changed successfully']);
        }
        return back()->with(['notMatch' => 'The old password is not invalid.']);
    }

    //password validation check
    public function passwordValidationCheck($request)
    {
        Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword'
        ])->validate();
    }

    //account details page
    public function details()
    {
        return view('admin.account.details');
    }

    //direct account edit page
    public function edit()
    {
        return view('admin.account.edit');
    }

    //update account
    public function update($id, Request $request)
    {
        $this->updateAccValidationCheck($request);
        $data = $this->getUpdateData($request);

        //get dbimage
        //delete previous image if there is new image
        //update image in db

        if ($request->hasFile('image')) {
            $dbImage = User::where('id', $id)->first();
            $dbImage = $dbImage->image;

            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        }
        User::where('id', $id)->update($data);
        return redirect()->route('account#details')->with(['updateSuccess' => 'Your account information has been updated successfully']);
    }

    //account list
    public function list()
    {
        $users = User::when(request('key'), function ($query) {
            $query->orWhere('name', 'like', '%' . request('key') . '%')
                ->orWhere('email', 'like', '%' . request('key') . '%')
                ->orWhere('gender', 'like', '%' . request('key') . '%')
                ->orWhere('phone', 'like', '%' . request('key') . '%')
                ->orWhere('address', 'like', '%' . request('key') . '%');
        })->paginate(4);
        return view('admin.account.list', compact('users'));
    }

    //direct change role page
    public function changeRole($id)
    {
        $account = User::where('id', $id)->first();
        return view('admin.account.changeRole', compact('account'));
    }

    //change role
    public function change($id, Request $request)
    {
        $data = $this->getRoleData($request);
        User::where('id', $id)->update($data);
        return redirect()->route('account#list', ['id' => $id])->with(['changeSuccess' => 'Account Role has been changed successfully']);
    }

    //get change role data
    public function getRoleData($request)
    {
        return [
            'role' => $request->role
        ];
    }

    //delete account
    public function delete($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('account#list')->with(['deleteSuccess' => 'Account has been deleted successfully']);
    }

    //request user data from edit page for update account
    public function getUpdateData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'updated_at' => Carbon::now()
        ];
    }

    //update account validation check
    public function updateAccValidationCheck($request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'image' => 'mimes:png,jpg,jpeg|file',
        ])->validate();
    }
}
