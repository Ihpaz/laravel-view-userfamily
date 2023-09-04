<?php

namespace App\Http\Controllers;


use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;


class UserController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        
        $Users = json_decode($this->runExternalApi("http://localhost:8080/customer"));
        foreach($Users as $dt){
            $dt->Cst_dob_date=Date('Y-m-d',strtotime($dt->Cst_dob_date));
        }
    
        return Inertia::render('User/Index', [
            'users' => $Users
        ]);
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {

        $nationality = json_decode($this->runExternalApi("http://localhost:8080/nationality"));
        $Users =(object)[
            'nationalities' => $nationality,
            'Cst_name'     => '',
            'Cst_email'   => '',
            'Cst_dob_date' => '',
            'Cst_phoneNum' => '',
            'Nationality_id' => null
        ];

        return Inertia::render('User/Create',[
            'users' => $Users
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

        // die($request);
        //set validation
        $request->validate([
            'Cst_name'   => 'required',
            'Cst_dob_date' => 'required',
            'FamilyList' => 'required'
        ]);

        //create 
        $param = [
            'json' =>[
                'Cst_name' => $request->Cst_name,
                'Cst_email' => $request->Cst_email,
                'Cst_dob_date' => date('Y-m-d',strtotime($request->Cst_dob_date)),
                'Cst_phoneNum' => $request->Cst_phoneNum,
                'Nationality_id' => $request->Nationality_id,
                'FamilyList' => $request->FamilyList
            ]
        ];
        $user =$this->runExternalApi("http://localhost:8080/customer",$param,'POST');
        if($user) {
            return Redirect::route('users.index')->with('message', 'Data Berhasil Disimpan!');
        }
    }

    /**
     * edit
     *
     * @param  mixed $post
     * @return void
     */
    public function edit($id)
    {
      
        $nationality = json_decode($this->runExternalApi("http://localhost:8080/nationality"));
        $user = json_decode($this->runExternalApi("http://localhost:8080/customer/".$id));
        foreach($user->FamilyList as $dt){
            
            $dt->Fl_dob_date=Date('Y-m-d',strtotime($dt->Fl_dob_date));
        }
        $Users =(object)[
            'id' => $id,
            'nationalities' => $nationality,
            'Cst_name'     => $user->Cst_name,
            'Cst_email'   => $user->Cst_email,
            'Cst_dob_date' => Date('Y-m-d',strtotime($user->Cst_dob_date)),
            'Cst_phoneNum' => $user->Cst_phoneNum,
            'Nationality_id' => $user->Nationality_id,
            'FamilyList' => $user->FamilyList

        ];

        return Inertia::render('User/Edit', [
            'users' => $Users
        ]);
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, $id)
    {
       
        $request->validate([
            'Cst_name'   => 'required',
            'Cst_dob_date' => 'required',
            'FamilyList' => 'required'
        ]);

        //create 
        $param = [
            'json' =>[
                'Cst_id' => (int)$id,
                'Cst_name' => $request->Cst_name,
                'Cst_email' => $request->Cst_email,
                'Cst_dob_date' => date('Y-m-d',strtotime($request->Cst_dob_date)),
                'Cst_phoneNum' => $request->Cst_phoneNum,
                'Nationality_id' => $request->Nationality_id,
                'FamilyList' => $request->FamilyList
            ]
        ];
       
        $user =$this->runExternalApi("http://localhost:8080/customer/".$id,$param,'PUT');
        if($user) {
            return Redirect::route('users.index')->with('message', 'Data Berhasil Diupdate!');
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
       
        $param = [
            'json' =>[
                'Cst_id' => $id,
               
            ]
        ];
        $user =$this->runExternalApi("http://localhost:8080/customer/".$id,[],'DELETE');
        if($user) {
            return Redirect::route('users.index')->with('message', 'Data Berhasil Dihapus!');
        }

    }

    public function runExternalApi($url,$param = [],$action='GET')
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request($action, $url,$param);
        return $res->getBody();
    }
}
