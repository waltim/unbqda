<?php

namespace App\Http\Controllers;

use App\Category;
use App\CodeCategory;
use App\Code;
use App\Interview;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = Project::orderBy('id', 'DESC')->paginate(5);
        return view('app.project.index', ['titulo' => 'Projects list', 'projects' => $projects, 'request' => $request->all()]);
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

    public function theory(){
        return view('app.project.theory');
    }

    public function theory_codes()
    {
        $codes = Code::all();
        return response()->json(json_encode($codes));
    }

    public function theory_categories()
    {
        $categories = Category::all();
        return response()->json(json_encode($categories));
    }

    public function theory_codeCategories()
    {
        $codeCategories = CodeCategory::all();
        return response()->json(json_encode($codeCategories));
    }


    public function advanced_stage(Project $project){

        $codes = Code::whereHas('quotes', function ($q) use ($project) {
            $q->join('interviews', 'quotes.interview_id', '=', 'interviews.id');
            $q->where('interviews.project_id', '=', $project->id);
        })
        ->orderBy('codes.id', 'DESC')
        ->paginate(5,["*"], "codes");

        $categories = Category::join('users', 'categories.user_id', '=', 'users.id')
        ->where('categories.project_id', $project->id)
        ->select('categories.*','users.name AS user')
        ->orderBy('categories.id','DESC')
        ->paginate(5,["*"], "categories");

        return view('app.code.index',[
            'titulo'=>'Codes and Categories',
            'codes' => $codes,
            'categories' => $categories,
            'project' => $project
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
            'description' => 'required|max:2000',
            'user_id' => 'exists:users,id'
        ]);
        Project::unguard();
        $project =  Project::create($request->except('_token'));
        Project::reguard();
        return response()->json($project);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $interviews = Interview::where('project_id','=',$project->id);
        $interviews = $interviews->orderBy('id','DESC')->paginate(10);
        // dd($interviews);
        return view('app.project.show', [
            'titulo' => $project->name,
            'project' => $project,
            'interviews' => $interviews,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return response()->json($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $request->validate([
            'name' => 'required|min:3',
            'description' => 'required',
        ]);

        Project::unguard();
        $project = Project::find($request->id);
        $project->update($request->except(['_token', '_method', 'user_id']));
        Project::reguard();
        return response()->json($project);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json($project);
    }
}
