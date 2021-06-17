<?php

namespace App\Http\Controllers;

use App\Code;
use App\Interview;
use App\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'description' => 'required',
            'project_id' => 'exists:projects,id'
        ]);
        Interview::unguard();
        $interview =  Interview::create($request->except('_token'));
        Interview::reguard();
        return response()->json($interview);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function show(Interview $interview)
    {
        $codes = Code::join('quotes', 'codes.quote_id', '=', 'quotes.id')
        ->join('interviews', 'quotes.interview_id', '=', 'interviews.id')
        ->where('quotes.interview_id', '=', $interview->id)
        ->where('codes.user_id', '=', auth()->id())
        ->select('codes.*')
        ->orderBy('codes.id','DESC')
        ->paginate(5);

        return view('app.interview.show', [
            'titulo' => $interview->name,
            'interview' => $interview,
            'codes' => $codes
        ]);
    }

    public function analise(Interview $interview){

        $codes = Code::join('quotes', 'codes.quote_id', '=', 'quotes.id')
        ->join('interviews', 'quotes.interview_id', '=', 'interviews.id')
        ->where('quotes.interview_id', '=', $interview->id)
        ->select('codes.*')
        ->orderBy('codes.id','DESC')
        ->paginate(10);

        return view('app.interview.analise', [
            'titulo' => $interview->name,
            'interview' => $interview,
            'codes' => $codes
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function edit(Interview $interview)
    {
        return response()->json($interview);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Interview $interview)
    {

        $request->validate([
            'name' => 'required|min:3',
            'description' => 'required',
        ]);

        Interview::unguard();
        $interview = Interview::find($request->id);
        $interview->update($request->except(['_token', '_method', 'project_id']));
        Interview::reguard();
        return response()->json($interview);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function destroy(Interview $interview)
    {
        $interview->destroy($interview->id);
        return response()->json($interview);
    }
}
