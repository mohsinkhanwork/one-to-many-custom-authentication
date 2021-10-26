<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Party;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Response;


class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function can_index($id)
    {
       $party = Party::find($id);
       // dd($party);

       $candidates = Candidate::query()->with('user')->where('party_id', $id)->orderBy('name')->get();
       // dd($candidates);

          $user_candidates_only = Candidate::with('user')->where([

            'party_id' => $id,
            'user_id'=> auth()->user()->id

        ])->first();


        // dd($user_candidate_only);

         $candidate_delete_request = Candidate::with('Party')->whereNotNull('delete_request')->get()->all();
        // dd($candidate_delete_request);

         $user_vote = User::query()->with('candidate')->where('id', auth()->user()->id)->first();
         // dd($user_vote);

        return view('candidates.index', compact('party','candidates', 'candidate_delete_request', 'user_vote', 'user_candidates_only'));
    }

    public function searchCanId(Request $request) {

        $candidate_id = Candidate::with('Party')->where('name', 'LIKE', '%' . $request->q . '%')->get();
        // dd($candidate_id);

        // $partyID = Party::find($partyID);

        // dd($partyID);

        return view('candidates.searched', compact('candidate_id') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

  public function CreateCandidate($id)
    {
        $party = Party::find($id);
        // dd($party);
        return view('candidates.create', compact('party'));
    }





    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this->validator($request);

        // $data = $request->all();

        $product = Candidate::create([
        'name' => $request['name'],
        'candidate_id' => $request['candidate_id'],
        'party_id' =>$request['party_id'],
        'user_id' =>$request['user_id']
    ]);

        return redirect()->route('candidate.can_index',[$request->party_id])->with('success', 'Vote Casted successfully');      //for success message the redirect should be used



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $candidate = Candidate::find($id);

        // dd($candidate);

        return view('candidates.show', compact('candidate'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function can_edit($CanID, $PartID)
    {
        $candidate = Candidate::findOrFail($CanID);

        $party = Party::findOrFail($PartID);

        return view('candidates.edit', compact('candidate', 'party'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validator($request);

        $candidate = Candidate::findOrFail($id);
        
        $input = $request->all();
        $candidate->update($input);

        return redirect()->route('candidate.can_index',[$request->party_id])->with('success', 'candidate Updated successfully');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    
        $candidate = Candidate::findOrFail($id)->delete();

        return Response::json();
        // return redirect()->back()->with('success', 'candidate deleted successfully');

    }

    public function validator($request){

        $request->validate([
            'user_id' => 'unique:candidates',
            'candidate_id'=>'required|unique:candidates|max:20'
        ]);
    }


    public function deleteRequest($candidate_id) {

        $delet_request = Candidate::query()->where('candidate_id', $candidate_id);

        $delet_request->update([

            'delete_request' => 'Please Delete My vote with ID '. $candidate_id,
        ]);

        return back()->with('success', 'Request sent successfully');
    }


    public function deleteCandidate($id) {

        $candidate = Candidate::find($id);
        $candidate->delete();
          return response()->json();

        // return redirect()->back()->with('success', 'candidate deleted successfully');
    }
}
