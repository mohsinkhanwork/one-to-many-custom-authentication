<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Party;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PartyRequest;
use App\Http\Controllers\Controller;
use File;
use Validator;
use Response;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parties = Party::with('candidate')->get();
        // dd($parties);

        $publish_parties = Party::where('publish', 1)->get();

        // dd($publish_parties);

        $candidate_delete_request_Noti = Candidate::with('Party')->whereNotNull('delete_request')->get()->all();
        // dd($candidate_delete_request_Noti);
        return view('politicalParty.index', compact('parties', 'candidate_delete_request_Noti', 'publish_parties'));
        
        // $candidate = $party->candidate;

        // dd($party);

        //  // dd($party);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('politicalParty.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {
        $validated = $request->validate([
        'name' => 'required|unique:parties',
        'party_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'party_leader' => 'required',
      ]);

        if ($validated) {
        
        $input['party_logo'] = date('YmdHis').'.'.$request->party_logo->extension();
        
        $request->party_logo->move(public_path('party_logo'), $input['party_logo']);
        
        $party = new Party;
        $party->name = $request->name;
        $party->slug = str_slug($request->name);
        $party->party_logo = $input['party_logo'];
        $party->party_leader = $request->party_leader;
        
        $party->save();

        return response()->json();

      } else {
                     
        return response()->json();

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
        $party = Party::find($id);
        // dd($party);
        return view('politicalParty.show', compact('party'));
    }

    public function search_party_name(Request $request)
    {   
      
        $party = Party::query()->where('name', $request->name)->first();

        if($party == null) {

            abort(404);
            // dd('abort');
        } else {

        return view('politicalParty.show', compact('party'));
            // dd('sucess');
        }

        // dd($party);
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)

    {   
     
        $party = Party::find($id);
        return view('politicalParty.edit', compact('party'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PartyRequest $request, $id)
    {

      
            $party = Party::find($id);
            $input = $request->all();

                                                    // file delete should not be incldued if image is not required field

         if ($image = $request->file('party_logo')) {

            $destinationPath = 'party_logo/';

            $imageName = date('YmdHis'). "." . $image->getClientOriginalExtension();

            $image->move($destinationPath, $imageName);

            $input['party_logo'] = "$imageName";

        }else{

            unset($input['party_logo']);                    // this will preserves the old input value

        }

        $party->update($input);

        return response()->json();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $party = Party::find($id); //Reports is my model

        //  $file_path = public_path('party_logo').'/'.$party->party_logo; 

        //   if(File::exists($file_path)){

        // File::delete($file_path); 
        // $party->destroy(); 

        // }

        // return response()->json();

        //  // return redirect()->back()->with('success', 'Party Deleted successfully');

    }

    public function deleteParty($id)
    
    {
        
        $party = Party::find($id); //Reports is my model

         $file_path = public_path('party_logo').'/'.$party->party_logo; 

          if(File::exists($file_path)){

        File::delete($file_path); 
        $party->delete(); 

        } else {
             $party->delete(); 
            
        return response()->json();
        }



    }

    public function publish(Request $request) {

        $user = Party::find($request->party_id);
        $user->publish = $request->publish;
        $user->save();
  
        return response()->json();
     }

        public function un_publish($id) {

        // dd($id);

        $publish = Party::where('id', $id)->update(['publish' => '0']);

        // dd($publish);

        return response()->json();
    }

    





}
