<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonateRequest;
use App\Http\Resources\DonateResource;
use App\Models\donate_schedual;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DonateSchedualController extends Controller
{
    public function __construct()
    {
       $this->middleware('blood_compare')->only('store');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $donate_scheduals = donate_schedual::with('user','blood_type')->get();
        return response()->json([

            // "message"=> "fetch data done",
            "message"=> trans('response.test'),
            "data"=> DonateResource ::collection($donate_scheduals)

        ],Response::HTTP_ACCEPTED);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDonateRequest $request)
    {
        $now = Carbon::now();
        $now =  $now->format('Y-M-D');
        $created_at = Auth::user()->created_at->addDay(7);
        // return $created_at;

        $compare = $created_at->gte("$now");
        if ($compare == false) {

            return response()->json(false);
        }else {
            return response()->json(true);
        }


        $donate_scheduals = donate_schedual::create([
            'user_id' => $request->user_id,
            'amount'  => $request-> amount,
            'blood_type_id' => $request-> blood_type_id,
            'verified' => false
        ]);

        operation_fun("+" ,$request-> amount);
        // $last_donate->date_format('Y-M-D');
        // $now = Carbon::now();
        // $now->format('Y-M-D');
        // if ($now->gt($last_donate->addDays("7"))) {
        //     # code...
        // }

        return response()->json([

            "message"=> "created successfuly",
            "data"=> $donate_scheduals

        ],Response::HTTP_ACCEPTED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\donate_schedual  $donate_schedual
     * @return \Illuminate\Http\Response
     */
    public function show($schedual_id)
    {
        // $request->validate([
        //     'user_id' => 'required|exists:users,id',

        // ]);
        $schedual = donate_schedual::where('id',$schedual_id)->with('user','blood_type')->get();
        // dd($schedual);
        return response()->json([

            "message"=> "Fetch data successfuly",
            "data"=> $schedual

        ],Response::HTTP_ACCEPTED);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\donate_schedual  $donate_schedual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$donate_schedual)
    {
        $request->validate([

            'amount' => 'integer',
        ]);
        $data = [];
        if ($request->amount) {
            $data['amount'] = $request->amount;
        }
        $donate_schedual = donate_schedual::where('id',$donate_schedual)->with('user','blood_type')-> update($data);
        return response()->json([

            "message"=> "update amount successfuly",

        ],Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\donate_schedual  $donate_schedual
     * @return \Illuminate\Http\Response
     */
    public function destroy($donate_schedual)
    {
        $donate_schedual = donate_schedual::where('id',$donate_schedual)->delete();
    }

    public function log(){

    }
}
