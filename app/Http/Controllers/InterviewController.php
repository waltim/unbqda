<?php

namespace App\Http\Controllers;

use App\Agreement;
use App\Code;
use App\Interview;
use App\Quote;
use App\Comment;
use App\CodingLevel;
use App\User;
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

    public function level(Request $request){
        $request->validate([
            'level' => 'required',
            'interview_id' => 'exists:interviews,id'
        ]);
        CodingLevel::unguard();
        $codingLevel =  CodingLevel::create($request->except('_token'));
        CodingLevel::reguard();
        return response()->json($codingLevel);
    }

    public function comments(Interview $interview){
        $comments = Comment::join('interviews', 'interviews.id', 'comments.interview_id')
        ->join('users', 'users.id', 'comments.user_id')
        ->where('comments.interview_id',  $interview->id)
        ->where('comments.deleted_at', null)
        ->select('comments.*', 'users.name', 'users.email')
        ->orderBy('comments.id', 'DESC')
        ->get();

        return view('app.interview.comment', [
            'titulo' => 'Comments',
            'interview' => $interview,
            'comments' => $comments
        ]);
    }

    public function observations(Code $code, Interview $interview)
    {
        $observations = Code::join('observations', 'observations.code_id', 'codes.id')
            ->join('users', 'observations.user_id', 'users.id')
            ->where('observations.code_id',  $code->id)
            ->where('observations.deleted_at', null)
            ->select('observations.*', 'users.name', 'users.id AS userId', 'users.email', 'codes.memo', 'codes.description AS code_name')
            ->orderBy('observations.id', 'DESC')
            ->get();

        return view('app.interview.observation', [
            'titulo' => 'Observations',
            'interview' => $interview,
            'observations' => $observations,
            'code' => $code
        ]);
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


    public function comment(Request $request){
        $request->validate([
            'description' => 'required',
            'interview_id' => 'exists:interviews,id',
            'user_id' => 'exists:users,id'
        ]);

        Comment::unguard();
        $comment =  Comment::create($request->except('_token'));
        Comment::reguard();
        return response()->json($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function show(Interview $interview)
    {
        $codes = Code::whereHas('quotes', function ($q) use ($interview) {
            $q->where('codes.user_id', auth()->id());
            $q->where('quotes.interview_id', '=', $interview->id);
        })
        ->orderBy('codes.id', 'DESC')
        ->paginate(5);

        $codememo = Code::where("project_id", '=', $interview->project_id)->get();

        return view('app.interview.show', [
            'titulo' => $interview->name,
            'interview' => $interview,
            'codes' => $codes,
            'codememo' => $codememo
        ]);
    }

    public function analise(Interview $interview)
    {
        $codes = Code::whereHas('quotes', function ($q) use ($interview) {
            $q->where('quotes.interview_id', '=', $interview->id);
        })
        ->orderBy('codes.id', 'DESC')
        ->paginate(10);


        $codesCount = Code::whereHas('quotes', function ($q) use ($interview) {
            $q->where('quotes.interview_id', '=', $interview->id);
        })->get();

        $unities = $codesCount->count();
        $usersAgreeCount = array();

        $i = 0;
        foreach($codesCount as $cc){
            $agreements = Agreement::where('agreements.code_id', $cc->id)->get();
            foreach($agreements as $aa){
                $usersAgreeCount[$i] = $aa->user_id;
                $i++;
            }
        }
        $ratersCount = array_unique($usersAgreeCount);
        $ratersCount = sizeof($ratersCount);


        $matrixParent = array();

        for ($y=0; $y < $unities; $y++) {
            $matrixChild = array(0,0,0,0,0);
            $matrixParent[] = $matrixChild;
        }
        // dd(json_encode($matrixParent));

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
