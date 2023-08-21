<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class UserController extends Controller
{
    // frontend
    function LoginPage()
    {
        return view('pages.auth.login-page');
    }

    function RegistrationPage()
    {
        return view('pages.auth.registration-page');
    }

    function SendOtpPage()
    {
        return view('pages.auth.send-otp-page');
    }

    function VerifyOTPPage()
    {
        return view('pages.auth.verify-otp-page');
    }

    function ResetPasswordPage()
    {
        return view('pages.auth.reset-pass-page');
    }

    function ProfilePage(): View
    {
        return view('pages.dashboard.profile-page');
    }

    //backend

    function UserRegistration(Request $request)
    {
        try {
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => $request->input('password'),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successfully'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 200);
        }
    }


    function UserLogin(Request $request)
    {
        $count = User::where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))
            ->select('id')->first();

        if ($count !== null) {
            //user login -> jwt token issue
            $token = JWTToken::CreateToken($request->input('email'), $count->id);
            return response()->json([
                'status' => 'success',
                'message' => "User Login Successfully"
            ], 200)->cookie('token', $token, 60 * 24 * 30);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized'
            ]);
        }
    }

    function SendOTPCode(Request $request)
    {
        $email = $request->input('email');
        $otp = rand(1000, 9999);
        $count = User::where('email', '=', $email)->count();
        if ($count == 1) {
            //send otp on email
            Mail::to($email)->send(new OTPMail($otp));
            //insert otp column
            User::where('email', '=', $email)->update(['otp' => $otp]);
            return response()->json([
                'status' => 'success',
                'message' => "4 Digit OTP code has been send on your email."
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => "Unauthorized"
            ]);
        }
    }

    function VerifyOTP(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email', '=', $email)
            ->where('otp', '=', $otp)->count();

        if ($count == 1) {
            // OTP update
            User::where('email', '=', $email)->update(['otp' => '0']);
            // Password reset token issue
            $token = JWTToken::CreateTokenForSetPassword($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => "OTP verification Successfully"
            ], 200)->cookie('token', $token, 60 * 24 * 30);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => "Unauthorized"
            ]);
        }
    }

    function ResetPassword(Request $request)
    {
        try {
            $email = $request->header('email');
            $password = $request->input('password');
            User::where('email', '=', $email)->update(['password' => $password]);
            return response()->json([
                'status' => 'success',
                'message' => "Password Reset Successfully"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => "Something Went Wrong"
            ]);
        }
    }

    function UserLogout()
    {
        return redirect('userLogin')->cookie('token', '', '-1');
    }

    function UserProfile(Request $request)
    {
        $email = $request->header('email');
        $user = User::where('email', '=', $email)->first();
        return response()->json([
            'status' => 'success',
            'message' => 'Request Successful',
            'data' => $user
        ], status: 200);
    }

    function UpdateProfile(Request $request)
    {
        try {
            $email = $request->header('email');
            $firstName = $request->input('firstName');
            $lastName = $request->input('lastName');
            $mobile = $request->input('mobile');
            $password = $request->input('password');
            User::where('email', '=', $email)->update([
                'firstName' => $firstName,
                'lastName' => $lastName,
                'mobile' => $mobile,
                'password' => $password
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Profile update successfully',
            ], status: 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Something went wrong',
            ], status: 200);
        }
    }
}
