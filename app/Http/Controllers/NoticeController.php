<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Notice;
use Auth;
use DB;





class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $notices = Notice::all();
        // $notices = Notice::orderBy('created_at','desc')->get();

        $notices = DB::select('SELECT * from notices ORDER BY created_at DESC');
        return view('notices.index')->with('notices', $notices);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return 'ok';
       
           if(Auth::check()){
                return view('notices.create');
     
            return redirect('/login');
           }
           else{
               return redirect('/login');
           }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::check()){
            $this->validate($request,[
            'title' => 'required',
            'desc' => 'required'
        ]);

        $notice = new Notice;
        $notice->title = $request->input('title');
        $notice->desc = $request->input('desc');
        $notice->save();

        return redirect('/notice')->with('success', 'Notice posted successfully.');
        }
        else{
            return redirect('/login');
        }
        
            
        
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
            $notice = Notice::find($id);
        return view('notices.show')->with('notice', $notice);
        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::check()){

            $notice = Notice::find($id);
        return view('notices.edit')->with('notice', $notice);
        }
        else{
            return redirect('/login');
        }
  
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::check()){
            $this->validate($request,[
            'title' => 'required',
            'desc' => 'required'
        ]);

        $notice = Notice::find($id);
        $notice->title = $request->input('title');
        $notice->desc = $request->input('desc');
        $notice->save();

        return redirect('/notice')->with('success', 'Notice updated successfully.');
        }
        else{
            return redirect('/login');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::check()){
            $notice = Notice::find($id);
        $notice->delete();
        return redirect('/notice')->with('success', 'Notice deleted successfully.');
        }
        else{
            return redirect('/login');
        }
    }
}
