<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tasklist; 


class TasklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
       
    
        $tasklists = Tasklist::all();

        return view('tasklists.index', [
            'tasklists' => $tasklists,
        ]);
    

        
        
        
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasklists = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasklists' => $tasklists,
            ];
            $data += $this->counts($user);
            return view('tasklists.show', $data);
        }else {
            return view('welcome');
        }
    }
        
        
               
       
        
        
        

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $tasklist = new Tasklist;

        return view('tasklists.create', [
            'tasklist' => $tasklist,
        ]);
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
        $this->validate($request, [
            'status' => 'required|max:10',   // add
            'content' => 'required|max:191'
        ]);
        
        $tasklist = new Tasklist;
        $tasklist->status = $request->status; 
        $tasklist->content = $request->content;
        
        $user = \Auth::user();
        $tasklist->user_id= $user ->id;



        $tasklist->save();

        return redirect('/');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
     {   
        $tasklist = Tasklist::find($id);
        if(\Auth::user()->id==$tasklist->user_id){
        return view('tasklists.show', [
            'tasklist' => $tasklist,
        ]);
        }else{
        return redirect('/');
        }
        
        
        
         
    //      if (\Auth::check()) {
    //         $user = \Auth::user();
    //          $tasklist = Tasklist::find($id);
    //         $tasklists = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
    //           if (\Auth::user()->id === $tasklist->user_id) {
    //     return view('tasklists.show', [
    //         'tasklist' => $tasklist,
    //         'user'=>$user,
    //         'tasklists' => $tasklists,
    //     ]);
    //     //
    //   } else{
    //       return redirect ('/');
    //   }
    //         }else{
    //       return view ('welcome');
    //   }
        
    }

     public function edit($id)
       {
        $tasklist = Tasklist::find($id);
          if(\Auth::user()->id==$tasklist->user_id){
        return view('tasklists.edit', [
            'tasklist' => $tasklist,
        ]);
          }else{
        return redirect('/');
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
        $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:191'// add
        ]);
        
        
        $tasklist = Tasklist::find($id);
        $tasklist->status = $request->status; 
        $tasklist->content = $request->content;

    
        $tasklist->save();//
        
         return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tasklist = Tasklist::find($id);
        $tasklist->delete();

        return redirect('/');
        //
    }
}
