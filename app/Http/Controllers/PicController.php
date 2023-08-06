<?php

namespace App\Http\Controllers;

use App\Models\Pic;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PicController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        
        $pics = Pic::latest()->get();

        return Inertia::render('Pic/Index', [
            'pics' => $pics
        ]);
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        return Inertia::render('Pic/Create');
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
            'email' => 'required',
        ]);

        //create post
        $Pic = Pic::create([
            'nama'     => $request->nama,
            'email'   => $request->email
        ]);

        if($Pic) {
            return Redirect::route('pics.index')->with('message', 'Data Berhasil Disimpan!');
        }
    }

    /**
     * edit
     *
     * @param  mixed $post
     * @return void
     */
    public function edit(Pic $Pic)
    {
        return Inertia::render('Pic/Edit', [
            'pic' => $Pic
        ]);
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, Pic $pic)
    {
        //set validation
        $request->validate([
            'nama'   => 'required',
            'email' => 'required',
        ]);

        //update post
        $pic->update([
            'nama'     => $request->nama,
            'email'   => $request->email
        ]);

        if($pic) {
            return Redirect::route('pics.index')->with('message', 'Data Berhasil Diupdate!');
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
        $pic = Pic::findOrfail($id);

        //delete post
        $pic->delete();

        if($pic) {
            return Redirect::route('pics.index')->with('message', 'Data Berhasil Dihapus!');
        }

    }
}
