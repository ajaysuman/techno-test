<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookings;
use DB;
use DataTables;



class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       if ($request->ajax()) {
            $data = Bookings::select('*'); 
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $id = $row->id;
                         $btn = '<a href="javascript:void(0)" data-id="' . $id . '"class="edit btn btn-primary" id="edit">Edit</a>'." ".'<a href="javascript:void(0)" data-id="' . $id . '" class="delete btn btn-danger btm-sm" id="delete">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
           return view('booking.bookingindex');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $newBooking = new Bookings();
            // For Check Booking Full Day 
            // $bookingdatas = DB::table('bookings')->where('bookingdate',$request->bookingdate)->get();
            $bookingdatas = Bookings::where('bookingdate', $request->bookingdate)->get();
            foreach ($bookingdatas as $bookingdata) {
            }
            if(count($bookingdatas) == 1 ){ 
                $bookingslot = $bookingdata->bookingslot;
                if($bookingdata->bookingtype == 'fullday'){ 
                    return response()->json([
                        'status'    => 2, // For Not Available Booking
                        'message' => "Not Available Bookings"
                    ]);
                }
                if($bookingdata->bookingtype == 'halfday' ){ 
                    if($bookingslot==$request->bookingslot){  
                        return response()->json([
                            'status'    => 3, // For Half Day Booking
                            'message' => "Available Evening halfday Bookings"
                        ]);
                    } else{
                            $newBooking->name = $request->name;
                            $newBooking->email = $request->email;
                            $newBooking->bookingtype = $request->bookingtype; 
                            $newBooking->bookingdate = $request->bookingdate;
                            $newBooking->bookingslot = $request->bookingslot;
                            $newBooking->bookingtime = $request->bookingtime;
                            if($newBooking->save() == 1){
                                return response()->json([
                                  'status'    => 4,
                                  'message' => "Insert HalfDay EVning Booking..!!!!"
                                ]);
                            }
                        
                     }
                    // For Morning Booking
                     if($bookingslot == $request->bookingslot){  
                        return response()->json([
                            'status'    => 5, // For Half Day Booking
                            'message' => "Available Morning halfday Bookings "
                        ]);
                    }else{
                         
                            $newBooking->name = $request->name;
                            $newBooking->email = $request->email;
                            $newBooking->bookingtype = $request->bookingtype; 
                            $newBooking->bookingdate = $request->bookingdate;
                            $newBooking->bookingslot = $request->bookingslot;
                            $newBooking->bookingtime = $request->bookingtime;
                            if($newBooking->save() == 1){
                                return response()->json([
                                  'status'    => 6,
                                  'message' => "Insert HalfDay Morning Booking..!!!!"
                                ]);
                            }
                        
                     }
                } else{
                    
                }
            }else{
                $newBooking = new Bookings();
                $newBooking->name = $request->name;
                $newBooking->email = $request->email;
                $newBooking->bookingtype = $request->bookingtype; 
                $newBooking->bookingdate = $request->bookingdate;
                $newBooking->bookingslot = $request->bookingslot;
                $newBooking->bookingtime = $request->bookingtime;
                if($newBooking->save() == 1){
                    return response()->json([
                      'status'    => 1,
                      'message' => "Insert Booking Success..!!!!"
                    ]);
                }else{
                    return response()->json([
                      'status'    => 400,
                      'message' => "Insert Faild..!!!!"
                    ]);
                }
            }
        } catch (Exception $e) {
                 return $e->getMessage();
            }  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        try {
            $BookingData = Bookings::where('id', $id)->get();
            return $BookingData;
        }catch (Exception $e) {
             return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

       try{
            $data = Bookings::where('id', $request->id)->update(array('name' => $request->name
                , 'email' => $request->email
                , 'bookingtype' => $request->bookingtype
                , 'bookingdate' => $request->bookingdate
                , 'bookingslot' => $request->bookingslot
                , 'bookingtime' => $request->bookingtime
             ));
           
            return response()->json([
              'status'    => 200,
              'message' => "Update Data Success!!!!"
            ]);

       } catch (Exception $e) {
             return $e->getMessage();
        }
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
             Bookings::find($id)->delete();
             return response()->json([
              'status'    => 200,
              'message' => "Delete Data Success!!!!"
            ]);
       }catch (Exception $e) {
             return $e->getMessage();
        }
    }
}
