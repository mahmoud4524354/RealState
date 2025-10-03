<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\SmtpSetting;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use FileUploadTrait;

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

    public function SiteSetting()
    {
        $setting = SiteSetting::find(1);
        return view('backend.setting.site_update', compact('setting'));
    }

    public function updateSiteSetting(Request $request, $id)
    {

        $logo = $this->uploadImage($request, 'logo');;

        SiteSetting::findOrFail($id)->update([
            'support_phone' => $request->support_phone,
            'company_address' => $request->company_address,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'copyright' => $request->copyright,
            'logo' => $logo,
        ]);

        toastr()->success('Site Setting Updated Successfully');
        return redirect()->back();
    }

}
