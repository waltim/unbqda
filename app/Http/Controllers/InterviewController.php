<?php

namespace App\Http\Controllers;

use App\Interview;
use Illuminate\Http\Request;

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
        return view('app.interview.show', [
            'titulo' => $interview->name,
            'interview' => $interview
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
