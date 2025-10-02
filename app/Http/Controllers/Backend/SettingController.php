<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SmtpSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function SmtpSetting()
    {

        $setting = SmtpSetting::find(1);
        return view('backend.setting.smtp_update', compact('setting'));

    }


    public function updateSmtpSetting(Request $request)
    {
        $smtpsetting_id = $request->id;

        SmtpSetting::findOrFail($smtpsetting_id)->update([
            'mailer' => $request->mailer,
            'host' => $request->host,
            'post' => $request->post,
            'username' => $request->username,
            'password' => $request->password,
            'encryption' => $request->encryption,
            'from_address' => $request->from_address,
        ]);

        toastr()->success('Smtp Setting Updated Successfully');
        return redirect()->back();
    }

}
