<?php

namespace App\Http\Controllers;

use App\Code;
use App\Interview;
use App\Quote;
use Illuminate\Http\Request;

class CodeController extends Controller
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
            'code_name' => 'required|min:3',
            'code_color' => 'required',
            'interview_id' => 'exists:interviews,id',
            'code_quote' => 'required',
            'code_memo' => 'required'
        ]);

        Quote::unguard();
        $quote = new Quote();
        $quote->description = $request->get('code_quote');
        $quote->interview_id = $request->get('interview_id');
        $quote->save();
        Quote::reguard();
        if ($quote) {
            Code::unguard();
            $code = new Code();
            $code->user_id = auth()->id();
            $code->quote_id = $quote->id;
            $code->description = $request->get('code_name');
            $code->color = $request->get('code_color');
            $code->memo = $request->get('code_memo');
            $code->save();
            Code::reguard();
            return response()->json($code);
        } else {
            return response()->json($quote);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function show(Code $code)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function edit(Code $code)
    {
        //
    }

    public function highlight(Interview $interview){
        $quotes = Code::join('quotes', 'codes.quote_id', '=', 'quotes.id')
        ->join('interviews', 'quotes.interview_id', '=', 'interviews.id')
        ->join('users', 'codes.user_id', '=', 'users.id')
        ->where('quotes.interview_id', '=', $interview->id)
        ->select('quotes.*','codes.color', 'codes.description AS code_name','users.name')
        ->get();
        return response()->json($quotes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Code $code)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function destroy(Code $code)
    {
        if($code->delete()){
            $quote = Quote::find($code->quote_id);
            $quote->delete();
            return response()->json($quote);
        }else{
            return response()->json($code);
        }
    }
}
