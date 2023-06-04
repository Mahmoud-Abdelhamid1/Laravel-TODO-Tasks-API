<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TasksResource;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TasksResource::collection(
            Task::where('user_id' , Auth::id())->get());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $request->validated($request->all);

        $task = Task::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'piriorty' => $request->piriorty,
            'user_id' => Auth::id()

        ]);
        return new TasksResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return $this->isNotAuthorized($task) ? $this->isNotAuthorized($task) : new TasksResource($task);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request,Task $task)
    {
        if (Auth::id() !== $task->user_id) {
            return $this->error('' , 'You are not authorized' , 403);
        }
        $request->validated($request->all);
        $task->update([
            'name' => $request->input('name'),
            'desc' => $request->input('desc'),
            'piriorty' => $request->input('piriorty')
        ]);

        return new TasksResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if (Auth::id() !== $task->user_id) {
            return $this->error('' , 'You are not authorized' , 403);
        }
        $task->delete();
        return response('this task was deleted' , 204);
    }

    private function isNotAuthorized($task){
        if (Auth::id() !== $task->user_id) {
            return $this->error('' , 'You are not authorized' , 403);
        }
    }
}
