<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\subProject;
use App\Models\detailProject;
use App\Models\Pic;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        
        $Projects = Project::latest()->get();

        return Inertia::render('Project/Index', [
            'projects' => $Projects
        ]);
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {

        $pics = Pic::latest()->get();

        $Projects =(object)[
            'pics' => $pics,
            'nama'     => '',
            'keterangan'   => '',
            'project' => []
        ];

        return Inertia::render('Project/Create',[
            'projects' => $Projects
        ]);
    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //set validation
        $request->validate([
            'nama'   => 'required',
            'keterangan' => 'required',
            'projects' => 'required'
        ]);

        //create 
        $Project = Project::create([
            'nama'     => $request->nama,
            'ketrangan'   => $request->keterangan
        ]);

      
        foreach($request->projects as $subproject){
           
            $SubProject = SubProject::create([
                'nama'     => $subproject['nama'],
                'project_id'   => $Project->id
            ]);

            foreach($subproject['details'] as $detailproject){
                $detailProject = detailProject::create([
                    'nama'     => $detailproject['nama'] ? $detailproject['nama'] :'',
                    'StartDate' => $detailproject['StartDate'] ? $detailproject['StartDate'] : date('Y-m-d H:i:s',strtotime('8/6/2023')),
                    'EndDate'   => $detailproject['EndDate'] ? $detailproject['EndDate'] : date('Y-m-d H:i:s',strtotime('8/6/2023')) ,
                    'status'   => $detailproject['Status'],
                    'pic_id'   => $detailproject['pic'] ? $detailproject['pic'] : 0,
                    'subproject_id'   => $SubProject->id
                ]);
            }
        }
       

        if($Project) {
            return Redirect::route('projects.index')->with('message', 'Data Berhasil Disimpan!');
        }
    }

    /**
     * edit
     *
     * @param  mixed $post
     * @return void
     */
    public function edit(Project $Project)
    {
      
        $pics = Pic::latest()->get();

        $project = DB::select('
            select * 
            from projects 
            where id = ?',
        [$Project->id]);

        $project=$project[0];



        $subProject = DB::select('
            select * 
            from sub_projects
            where project_id = ?',
        [$Project->id]);

        $i=0;
       foreach($subProject as $item){

            $details = DB::select('
            select 
                a.* , 
                a.status as Status,
                b.id as pic  
            from detail_projects a
            inner join pics b on a.pic_id=b.id
            where subproject_id = ?', 
            [$item->id]);

            $subProject[$i]->details=$details;
            $i++;
       }
        
      
      
        $Projects =(object)[
            'id'=> $Project->id,
            'pics' => $pics,
            'nama'     => $project->nama,
            'keterangan'   => $project->ketrangan,
            'project' => $subProject
        ];

        return Inertia::render('Project/Edit', [
            'projects' => $Projects
        ]);
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, Project $Project)
    {
       
        //set validation
        $request->validate([
            'nama'   => 'required',
            'keterangan' => 'required',
            'projects' => 'required'
        ]);

        $affected = DB::table('projects')
                    ->where('id', $Project->id)
                    ->update([
                        'nama'     => $request->nama,
                        'ketrangan'   => $request->keterangan
        ]);

      
     
        foreach($request->projects as $subproject){
           
            $subprojectid='';
            if(!isset($subproject['id'])){
                $SubProject = SubProject::create([
                    'nama'     => $subproject['nama'],
                    'project_id'   => $Project->id
                ]);

                $subprojectid=$SubProject->id;
            }else{
                $affected = DB::table('sub_projects')
                ->where('id', $subproject['id'])
                ->update([
                    'nama'     => $subproject['nama'],
                    'project_id'   => $Project->id
                ]);
                $subprojectid=$subproject['id'];
            }


            

            // $SubProject = SubProject::create([
            //     'nama'     => $subproject['nama'],
            //     'project_id'   => $Project->id
            // ]);

            foreach($subproject['details'] as $detailproject){

                if(isset($detailproject['id'])){
                    $affected = DB::table('detail_projects')
                    ->where('id', $detailproject['id'])
                    ->update([
                        'nama'     =>  $detailproject['nama'] ? $detailproject['nama'] :'',
                        'StartDate' => $detailproject['StartDate'] ? $detailproject['StartDate'] : date('Y-m-d H:i:s',strtotime('8/6/2023')),
                        'EndDate'   =>$detailproject['EndDate'] ? $detailproject['EndDate'] : date('Y-m-d H:i:s',strtotime('8/6/2023')) ,
                        'status'   => $detailproject['Status'],
                        'pic_id'   => $detailproject['pic'] ? $detailproject['pic'] : 0,
                        'subproject_id'   =>  $subprojectid
                    ]);
                }else{
                    $detailProject = detailProject::create([
                        'nama'     =>  $detailproject['nama'] ? $detailproject['nama'] :'',
                        'StartDate' => $detailproject['StartDate'] ? $detailproject['StartDate'] : date('Y-m-d H:i:s',strtotime('8/6/2023')),
                        'EndDate'   => $detailproject['EndDate'] ? $detailproject['EndDate'] : date('Y-m-d H:i:s',strtotime('8/6/2023')) ,
                        'status'   => $detailproject['Status'],
                        'pic_id'   => $detailproject['pic'] ? $detailproject['pic'] : 0,
                        'subproject_id'   =>   $subprojectid
                    ]);
                }
               

              
            }
        }

        if($Project) {
            return Redirect::route('projects.index')->with('message', 'Data Berhasil Diupdate!');
        }
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
       
        //find post by ID
        $Project = Project::findOrfail($id);

        //delete post
        $Project->delete();

        if($Project) {
            return Redirect::route('projects.index')->with('message', 'Data Berhasil Dihapus!');
        }

    }
}
