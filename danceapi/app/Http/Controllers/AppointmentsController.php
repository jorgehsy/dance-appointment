<?php

namespace App\Http\Controllers;

use App\Appointments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentsController extends Controller
{
    
    public function showAll()
    {
        return response()->json(Appointments::all()
          ->sortBy("dancedate"));
    }

    public function showAppointment($id)
    {
        return response()->json(Appointments::find($id));
    }

    public function create(Request $request)
    {
        //validate requires and format
        $this->validate($request, [
            'email' => 'required|email',
            'dancedate' => 'required|date',
        ]);
        
        //validate date after current time
        if (($request->dancedate . $request->dancetime) < date("Y-m-dH:i:s")){
            return response()->json(['status' => 10, 'message' => "Pick another date, we cannot travel to the pass... yet"], 400);
        }

        //validate if dates collapse
        $datesTaken = DB::table('appointments')
            ->select('dancetime')
            ->where('dancedate', $request->dancedate)
            ->get();
        foreach ($datesTaken as $dateTaken){
            $endTimeReq = date('H:i:s',strtotime('+1 hour',strtotime($request->dancetime)));
            $endTimeTkn = date('H:i:s',strtotime('+1 hour',strtotime($dateTaken->dancetime)));
            if($endTimeReq >= $dateTaken->dancetime && $endTimeReq <= $endTimeTkn){
                return response()->json(['status' => 20, 'message' => "There is an appoinment within this hours, sorry"], 400);
            }
        }

        $appointment = Appointments::create($request->all());
        return response()->json(['status' => 1], 201);
    }

    public function update($id, Request $request)
    {
        $appointment = Appointments::findOrFail($id);
        $this->validate($request, [
            'dancedate' => 'required|date|unique:appointments'
        ]);
        $appointment->update($request->all());

        return response()->json($appointment, 200);
    }

    public function delete($id)
    {
        Appointments::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }

}