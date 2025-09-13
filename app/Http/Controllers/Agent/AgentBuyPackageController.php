<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\PackagePlan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgentBuyPackageController extends Controller
{
    public function BuyPackage()
    {

        return view('agent.package.buy_package');

    }


    public function BuyBusinessPlan()
    {

        $id = Auth::user()->id;
        $data = User::find($id);
        return view('agent.package.business_plan', compact('data'));

    }// End Method


    public function StoreBusinessPlan(Request $request)
    {

        $user_id = Auth::id();
        $user = User::findOrFail($user_id);

        PackagePlan::create([

            'user_id' => $user_id,
            'package_name' => 'Business',
            'package_credits' => '3',
            'invoice' => 'ERS' . mt_rand(10000000, 99999999),
            'package_amount' => '20',
            'created_at' => Carbon::now(),
        ]);

        $user->increment('credit', 3);

        toastr()->success('Business Plan added successfully!');

        return redirect()->route('agent.all.property');
    }


    public function BuyProfessionalPlan()
    {

        $id = Auth::user()->id;
        $data = User::find($id);
        return view('agent.package.professional_plan', compact('data'));

    }// End Method


    public function StoreProfessionalPlan(Request $request)
    {

        $user_id = Auth::user()->id;
        $user = User::findOrFail($user_id);

        PackagePlan::insert([

            'user_id' => $user_id,
            'package_name' => 'Professional',
            'package_credits' => '10',
            'invoice' => 'ERS' . mt_rand(10000000, 99999999),
            'package_amount' => '50',
            'created_at' => Carbon::now(),
        ]);

        $user->increment('credit', 10);

        toastr()->success('Professional plan added successfully!');

        return redirect()->route('agent.all.property');
    }


    public function PackageHistory()
    {
        $id = Auth::user()->id;
        $packagehistory = PackagePlan::where('user_id', $id)->get();
        return view('agent.package.package_history', compact('packagehistory'));

    }

    public function AgentPackageInvoice($id)
    {

        $packagehistory = PackagePlan::where('id', $id)->first();

        $pdf = Pdf::loadView('agent.package.package_history_invoice', compact('packagehistory'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);
        return $pdf->download('invoice.pdf');
    }

}
