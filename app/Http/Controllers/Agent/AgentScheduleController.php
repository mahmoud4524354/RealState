<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Mail\ScheduleApprovedMail;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AgentScheduleController extends Controller
{
    public function AgentScheduleRequest()
    {

        $id = Auth::user()->id;
        $usermsg = Schedule::where('agent_id', $id)->get();
        return view('agent.schedule.schedule_request', compact('usermsg'));

    }

    public function AgentDetailsSchedule($id)
    {

        $schedule = Schedule::findOrFail($id);
        return view('agent.schedule.schedule_details', compact('schedule'));

    }


    public function AgentUpdateSchedule(Request $request)
    {

        $schedule_id = $request->id;
        $schedule_data = Schedule::findOrFail($schedule_id);

        $schedule_data->update([
            'status' => '1',
        ]);

        //// Start Send Email

        $data = [
            'tour_date' => $schedule_data->tour_date,
            'tour_time' => $schedule_data->tour_time,
        ];

        Mail::to($schedule_data->user->email)->send(new ScheduleApprovedMail($data));


        toastr()->success("Schedule Request Successfully");
        return redirect()->route('agent.schedule.request');

    }
}
