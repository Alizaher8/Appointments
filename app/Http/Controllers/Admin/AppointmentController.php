<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Requests\AppointmentRequest;

class AppointmentController extends Controller
{
    public function index(){

        return Appointment::query()
         ->with('client:id,first_name,last_name')
         ->when(request('status'),function ($query){

            return $query->where('status',AppointmentStatus::from(request('status')));
         })
        ->latest()
        ->paginate(settings('pagination_limit'))
        ->through(fn ($appointment)=>[
          'id' => $appointment->id,
          'start_time' => $appointment->formatted_start_time,
          'end_time' => $appointment->formatted_end_time,
          'status'  => [
            'name' => $appointment->status->name,
            'color' => $appointment->status->color(),
          ],
          'client' => $appointment->client,
        ]);
    }

    public function store(AppointmentRequest $request)
    {

        Appointment::create([

            'title' => request('title'),
            'client_id' =>request('client_id') ,
            'start_time' => request('start_time'),
            'end_time' => request('end_time'),
            'description' => request('description'),
            'status' => AppointmentStatus::SCHEDULED,
        ]);

      return response()->json(['massage' => 'success']);
    }


   public function edit(Appointment $appointment)
   {

      return $appointment;
   }

   public function update(Appointment $appointment, AppointmentRequest $request)
   {

      $appointment->update([

        'title' => request('title'),
        'client_id' =>request('client_id') ,
        'start_time' => request('start_time'),
        'end_time' => request('end_time'),
        'description' => request('description'),

      ]);

      return response()->json(['massage' => 'success']);
   }

   public function delete(Appointment $appointment)
   {

      $appointment->delete();


  return response()->json(['message' => 'success']);

   }
}
