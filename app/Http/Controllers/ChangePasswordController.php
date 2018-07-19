<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePassword;

/**
 * Class ChangePasswordController
 */
class ChangePasswordController extends Controller
{
    private $data;

    /**
     * ChangePasswordController constructor.
     *
     */
    public function __construct()
    {
        $this->data = [
            'pageTitle' => __('Change Password'),
            'pageHeader' => __('Change Password'),
            'pageSubHeader' => __('Change your password here')
        ];
    }

    public function show()
    {
        $this->data['user'] = auth()->user();
        return view('dashboard.change-password', $this->data);
    }

    public function update(ChangePassword $request)
    {
        $data = $request->all();

        $user = auth()->user();
        $user->password = bcrypt($data['new_password']);
        $user->save();

        return response()->json([
            'message' => __('Your password is successfully updated!')
        ]);
    }
}
