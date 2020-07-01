<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;    // 追加

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
        
            $user = \Auth::user();
            
            $tasks = $user->tasks;

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }
        return view('tasks.index', $data);
    }
     
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;

        
        return view('tasks.create', [
            'task' => $task,
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
        // バリデーション
        $this->validate($request, [
            
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:255',
            
        ]);

        
        $task = new Task;
        
        $task->user_id = \Auth::id();
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        
        if (\Auth::id() === $task->user_id) {
            
            return view('tasks.show', [
                'task' => $task,
                
            ]);
        }else{
            return redirect('/');
        }
        
        

       
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        
        if (\Auth::id() === $task->user_id) {
            // メッセージ編集ビューでそれを表示
            return view('tasks.edit', [
                'task' => $task,
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
        if (\Auth::id() === $task->user_id) {
            $this->validate($request, [
                'status' => 'required|max:10',   // 追加
                'content' => 'required|max:255',
            ]);
            
            $task = Task::findOrFail($id);
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();
    
            // トップページへリダイレクトさせる
            return redirect('/');
        }else{
            return redirect('/');
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
        $task = Task::findOrFail($id);
        
        
        if (\Auth::id() === $task->user_id) {
            
            $task->delete();
            
            
            return redirect('/');
        }else{
            return redirect('/');
        }
    }
}
