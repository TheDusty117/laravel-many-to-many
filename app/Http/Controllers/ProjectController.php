<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use App\Models\Technology;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
// importo le categorie



class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $trashed= $request->input('trashed');

        if ($trashed){
            $projects = Project::onlyTrashed()->get();
        } else {
            $projects = Project::all();
        }

        $num_of_trashed = Project::onlyTrashed()->count();

        return view('projects.index',compact('projects','num_of_trashed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name','asc')->get();
        $technologies = Technology::orderBy('name','asc')->get();

        return view('projects.create', compact('categories','technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {

        $data = $request->validated();

        $data['slug'] = Str::slug( $data['title'] );

        $project = Project::create($data);

        //attach che passa array di tecnologie
        //con controllo se ci sia
        if (isset($data['technologies'])){
            $project->technologies()->attach($data['technologies']);
        }

        return to_route('projects.show', $project);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view ('projects.show',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {

        $categories = Category::orderBy('name','asc')->get();
        $technologies = Technology::orderBy('name','asc')->get();


        return view('projects.edit',compact('project','categories','technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        // dd($data);

        if($data['title'] !== $project->title){
            $data['slug'] = Str::slug($data['title']);
        }

        $project->update($data);

        //controllo se preesistono dei technologies checkati
        if (isset($data['technologies'])){

            $project->technologies()->sync($data['technologies']);

        }


        return to_route('projects.show', $project);

    }

    public function restore(Project $project){


        if ($project->trashed()) {
            $project->restore();
        }

        return back();


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {

        if ($project->trashed()) {
            $project->forceDelete(); // eliminazione def
        } else {
            $project->delete(); //eliminazione soft
        }


        return to_route('projects.index');
    }
}
