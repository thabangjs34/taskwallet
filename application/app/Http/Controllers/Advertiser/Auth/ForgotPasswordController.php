<?php

namespace App\Http\Controllers\Advertiser\Auth;

use App\Models\Advertiser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdvertiserPasswordReset;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('advertiser.guest');
        $this->activeTemplate = activeTemplate();
    }


    public function showLinkRequestForm()
    {
        $pageTitle = "Account Recovery";
        return view($this->activeTemplate . 'advertiser.auth.passwords.email', compact('pageTitle'));
    }

    public function sendResetCodeEmail(Request $request)
    {
        $request->validate([
            'value'=>'required'
        ]);
        $fieldType = $this->findFieldType();
        $user = Advertiser::where($fieldType, $request->value)->first();

        if (!$user) {
            $notify[] = ['error', 'Couldn\'t find any account with this information'];
            return back()->withNotify($notify);
        }

        AdvertiserPasswordReset::where('email', $user->email)->delete();
        $code = verificationCode(6);
        $password = new AdvertiserPasswordReset();
        $password->email = $user->email;
        $password->token = $code;
        $password->created_at = \Carbon\Carbon::now();
        $password->save();

        $userIpInfo = getIpInfo();
        $userBrowserInfo = osBrowser();
        notify($user, 'PASS_RESET_CODE', [
            'code' => $code,
            'operating_system' => @$userBrowserInfo['os_platform'],
            'browser' => @$userBrowserInfo['browser'],
            'ip' => @$userIpInfo['ip'],
            'time' => @$userIpInfo['time']
        ],['email']);

        $email = $user->email;
        session()->put('pass_res_mail',$email);
        $notify[] = ['success', 'Password reset email sent successfully'];
        return to_route('advertiser.password.code.verify')->withNotify($notify);
    }

    public function findFieldType()
    {
        $input = request()->input('value');

        $fieldType = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $input]);
        return $fieldType;
    }

    public function codeVerify(){
        $pageTitle = 'Verify Email';
        $email = session()->get('pass_res_mail');
        if (!$email) {
            $notify[] = ['error','Oops! session expired'];
            return to_route('advertiser.password.request')->withNotify($notify);
        }
        return view($this->activeTemplate.'advertiser.auth.passwords.code_verify',compact('pageTitle','email'));
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'email' => 'required'
        ]);
        $code =  str_replace(' ', '', $request->code);

        if (AdvertiserPasswordReset::where('token', $code)->where('email', $request->email)->count() != 1) {
            $notify[] = ['error', 'Verification code doesn\'t match'];
            return to_route('advertiser.password.request')->withNotify($notify);
        }
        $notify[] = ['success', 'You can change your password.'];
        session()->flash('fpass_email', $request->email);
        return to_route('advertiser.password.reset', $code)->withNotify($notify);
    }

}
