<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEventRequest;
use App\Models\Admin\Event;
use App\Models\Admin\EventImage;
use App\Models\Admin\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class EventController extends Controller
{
    //
    public $langs;
    public function __construct()
    {
        $this->langs = Lang::all();
    }

    public function index(Request $request){
        $search = $request->input('search');
        $eventsQuery = Event::with('images');

        if ($search) {
            $eventsQuery->whereHas('translations', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        // Paginate the results
        $events = $eventsQuery->paginate(10); // 10 items per page
        return view('admin.events.index', [
            'events' => $events,
            'langs' => $this->langs,
            'search' => $search
        ]);
    }

    public function create(){

        return view('admin.events.add' , ['langs'=>$this->langs]);
    }

    public function store(StoreEventRequest $request){
        try{

            DB::beginTransaction();
            $event = Event::create([
                'date' => $request->date,
            ]);
            foreach ($this->langs as $lang){
                $event->{'name:'.$lang->code}  = $request->name[$lang->code];
                $event->{'des:'.$lang->code}  = $request->des[$lang->code];

            }

            $event->save();
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $image_name = $image->getClientOriginalName();
                    $image->move(public_path('uploads/images/events'), $image_name);

                    // Save image details in the database
                    EventImage::create([
                        'event_id' => $event->id,
                        'image' => $image_name,
                    ]);
                }
            }
            DB::commit();
            Alert::success('Success', 'Event Added Successfully !');
            return redirect()->route('admin.events.index');

        }catch (\Exception $e){

            dd($e->getMessage() , $e->getLine());
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.events.index');

        }

    } // end store function

    public function edit($id){
        $event = Event::findOrFail($id);
        return view('admin.events.update' , ['event' => $event ,'langs'=>$this->langs]);
    }




    // delete
    public function delete($id){
        $event = Event::findOrFail($id);

        $images = EventImage::where('event_id', $event->id)->get();

        foreach ($images as $image) {
            $imagePath = public_path('uploads/images/events/' . $image->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $image->delete();
        }

        $event->delete();

        Alert::success('Success', 'Event Deleted Successfully !');
        return redirect()->route('admin.events.index');



    }


    public function delete_image($id , $image_id){

        $event = Event::findOrFail($id);
        $image = EventImage::where('id' , $image_id)->where('event_id', $id)->first();
        if(isset($image)){
            $imagePath = public_path('uploads/images/events/' . $image->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $image->delete();

        }

        Alert::success('Success', 'Image Deleted Successfully !');
        return redirect()->back();


    }


    public function update(StoreEventRequest $request , $id){
        $event = Event::findOrFail($id);
        $event->date = $request->date;
        foreach ($this->langs as $lang){
            $event->{'name:'.$lang->code}  = $request->name[$lang->code];
            $event->{'des:'.$lang->code}  = $request->des[$lang->code];

        }

        $event->save();
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $image_name = $image->getClientOriginalName();
                $image->move(public_path('uploads/images/events'), $image_name);

                // Save image details in the database
                EventImage::create([
                    'event_id' => $event->id,
                    'image' => $image_name,
                ]);
            }
        }

        Alert::success('Success', 'Event Updated Successfully !');
        return redirect()->route('admin.events.index');

    }







}
