<?php

namespace App\Http\Controllers;

use App\Agreement;
use App\Category;
use App\Code;
use App\CodeQuote;
use App\Interview;
use App\Observation;
use App\Project;
use App\Quote;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

    public function options_code(Interview $interview)
    {
        $codes = Code::join('projects', 'codes.project_id', '=', 'projects.id')
            ->where('codes.project_id', '=', $interview->project_id)
            ->select('codes.*')
            ->orderBy('codes.description', 'ASC')
            ->pluck("description", "id")
            ->toArray();

        return response()->json($codes);
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
            'code_memo' => 'required',
        ]);

        $project = Interview::find($request->get('interview_id'));

        $quote = '';
        if (Quote::where('description', '=', $request->get('code_quote'))->count() < 1) {
            Quote::unguard();
            $quote = new Quote();
            $quote->description = $request->get('code_quote');
            $quote->interview_id = $request->get('interview_id');
            $quote->save();
            Quote::reguard();
        } else {
            $quote = Quote::where('description', '=', $request->get('code_quote'))->get();
            $quote = Quote::find($quote[0]->id);
        }
        if ($quote != '') {
            if(Code::where('description', '=', $request->get('code_name'))->where('project_id', $project->project_id)->count() < 1){
                Code::unguard();
                $code = new Code();
                $code->user_id = auth()->id();
                $code->description = $request->get('code_name');
                $code->color = $request->get('code_color');
                $code->memo = $request->get('code_memo');
                $code->project_id = $project->project_id;
                $code->save();
                Code::reguard();
                if ($code) {
                    $code_quote = $code->quotes()->attach($quote->id, ["user_id" => auth()->id()]);
                    return response()->json($code_quote);
                } else {
                    return response()->json($code);
                }
            }else{
                $codes = Code::where('description', '=', $request->get('code_name'))->where('project_id', $project->project_id)->pluck('id');
                $code_quote = $quote->codes()->attach($codes, ["user_id" => auth()->id()]);
                return response()->json($code_quote);
            }
        } else {
            return response()->json($quote);
        }
    }

    public function store_code_selected(Request $request)
    {
        $request->validate([
            'interview_id' => 'exists:interviews,id',
            'code_quote' => 'required',
            'code_id' => 'required'
        ]);

        $quote = '';
        if (Quote::where('description', '=', $request->get('code_quote'))->count() < 1) {
            Quote::unguard();
            $quote = new Quote();
            $quote->description = $request->get('code_quote');
            $quote->interview_id = $request->get('interview_id');
            $quote->save();
            Quote::reguard();
        } else {
            $quote = Quote::where('description', '=', $request->get('code_quote'))->get();
            $quote = Quote::find($quote[0]->id);
        }
        if ($quote != '') {
            $code_quote = $quote->codes()->attach($request->get('code_id'), ["user_id" => auth()->id()]);
            return response()->json($code_quote);
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

    public function remove_code_quote(Request $request){
        $request->validate([
            'quote_id' => 'required|exists:quotes,id',
            'code_id' => 'required|exists:codes,id',
        ]);

        // $code_quote = CodeQuote::where('code_id',$request->get('code_id'))
        // ->where('quote_id',$request->get('quote_id'))
        // ->delete();

        $code_quote = Code::find($request->get('code_id'));
        $code_quote->quotes()->detach($request->get('quote_id'));

        return response()->json($code_quote);
    }

    public function highlight(Interview $interview)
    {
        $quotes = Code::join('code_quote', 'code_quote.code_id', '=', 'codes.id')
            ->join('quotes', 'code_quote.quote_id', '=', 'quotes.id')
            ->join('interviews', 'quotes.interview_id', '=', 'interviews.id')
            ->join('users', 'codes.user_id', '=', 'users.id')
            ->where('quotes.interview_id', '=', $interview->id)
            ->select('quotes.*', 'code_quote.user_id AS highlighter' ,  'codes.color', 'codes.id AS code_id', 'codes.description AS code_name', 'users.name')
            ->get();

        return response()->json($quotes);
    }

    public function highlighter($user){
        $highlighter = User::where("id", $user)->get();
        if($highlighter){
            return response()->json($highlighter);
        }else{
            return response()->json($user);
        }
    }

    public function save_observation(Request $request){
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'code_id' => 'required|exists:codes,id',
            'interview_id' => 'required|exists:interviews,id',
            'observation' => 'required'
        ]);

        Observation::unguard();
        $observation = new Observation();
        $observation->user_id = $request->get('user_id');
        $observation->code_id = $request->get('code_id');
        $observation->interview_id = $request->get('interview_id');
        $observation->description = $request->get('observation');
        $observation->save();
        Observation::reguard();

        return response()->json($observation);
    }

    public function analise(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'code_id' => 'required|exists:codes,id',
            'scale' => 'required'
        ]);

        Agreement::unguard();
        $agree = new Agreement();
        $agree->user_id = $request->get('user_id');
        $agree->code_id = $request->get('code_id');
        $agree->scale = $request->get('scale');
        $agree->save();
        Agreement::reguard();

        if ($agree && $request->get('observation') != '') {
            Observation::unguard();
            $observation = new Observation();
            $observation->user_id = auth()->id();
            $observation->code_id = $request->get('code_id');
            $observation->interview_id = $request->get('interview_id');
            $observation->description = $request->get('observation');
            $observation->save();
            Observation::reguard();
            return response()->json($observation);
        } else {
            return response()->json($agree);
        }
    }

    public function analise_delete(Agreement $agreement)
    {
        $agreement->delete();
        return response()->json($agreement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'description' => 'required|min:3',
            'color' => 'required',
            'memo' => 'required',
            'project_id' => 'required',
            'id' => 'required'
        ]);

        Code::unguard();
        $codeupdated = Code::find($request->id);
        $codeupdated->update($request->except(['_token', '_method', 'project_id']));
        Code::reguard();
        return response()->json($codeupdated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function destroy(Code $code)
    {
        $code->categories()->detach();
        $code->agreements()->delete();
        $code->quotes()->detach();
        $code->delete();
        return response()->json($code);
    }
}
