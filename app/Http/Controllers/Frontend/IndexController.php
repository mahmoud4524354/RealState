<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PropertyMessage;
use App\Models\PropertyType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\MultiImage;
use App\Models\Facility;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\Translation\t;

class IndexController extends Controller
{
    public function PropertyDetails($id, $slug)
    {

        $property = Property::findOrFail($id);

        $amenities = $property->amenities_id;
        $property_amen = explode(',', $amenities);


        $multiImage = MultiImage::where('property_id', $id)->get();
        $facility = Facility::where('property_id', $id)->get();

        $type_id = $property->ptype_id;
        $relatedProperty = Property::where('ptype_id', $type_id)->where('id', '!=', $id)->orderBy('id', 'DESC')->limit(3)->get();

        return view('frontend.property.property_details', compact('property', 'multiImage', 'property_amen', 'facility', 'relatedProperty'));

    }


    public function PropertyMessage(Request $request)
    {

        $pid = $request->property_id;
        $aid = $request->agent_id;

        if (Auth::check()) {

            PropertyMessage::insert([

                'user_id' => Auth::user()->id,
                'agent_id' => $aid,
                'property_id' => $pid,
                'msg_name' => $request->msg_name,
                'msg_email' => $request->msg_email,
                'msg_phone' => $request->msg_phone,
                'message' => $request->message,
                'created_at' => Carbon::now(),

            ]);

            toastr()->success('Message Send Successfully');
            return redirect()->back();

        } else {

            toastr()->warning('Please Login First');
            return redirect()->back();
        }

    }

    public function AgentDetails($id)
    {
        $agent = User::findOrFail($id);
        $property = Property::where('agent_id', $id)->get();
        $featured = Property::where('featured', '1')->limit(3)->get();

        $rentproperty = Property::where('property_status','rent')->get();
        $buyproperty = Property::where('property_status','buy')->get();

        return view('frontend.agent.agent_details', get_defined_vars());
    }

    public function AgentDetailsMessage(Request $request)
    {

        $aid = $request->agent_id;

        if (Auth::check()) {
            PropertyMessage::insert([
                'user_id' => Auth::user()->id,
                'agent_id' => $aid,
                'msg_name' => $request->msg_name,
                'msg_email' => $request->msg_email,
                'msg_phone' => $request->msg_phone,
                'message' => $request->message,
                'created_at' => Carbon::now(),
            ]);
            toastr()->success('Message Send Successfully');
            return redirect()->back();
        }
        toastr()->warning('Please Login First');
        return redirect()->back();
    }

    public function RentProperty(){

        $property = Property::where('status','1')->where('property_status','rent')->get();

        return view('frontend.property.rent_property',compact('property'));

    }


    public function BuyProperty(){

        $property = Property::where('status','1')->where('property_status','buy')->get();

        return view('frontend.property.buy_property',compact('property'));

    }


    public function PropertyType($id){

        $property = Property::where('status','1')->where('ptype_id',$id)->get();

        $pbread = PropertyType::where('id',$id)->first();

        return view('frontend.property.property_type',compact('property','pbread'));

    }


}
