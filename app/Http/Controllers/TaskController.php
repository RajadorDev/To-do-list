<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\get;

class TaskController extends Controller
{
    

    public function renderCreatePage(Request $request)
    {
        $isToCreate = true;
        $dataList = [];
        if ($id = $request->get('id')) {
            $task = Task::find($id);
            if ($task) {
                if ($task->canBeEdited() && $task->user_id == Auth::user()->id)
                {
                    $isToCreate = false;
                    $dataList['title'] = $task->title;
                    $dataList['description'] = $task->description;
                    $dataList['taskid'] = $id;
                } else {
                    return redirect()->route('dashboard');
                }
            }
        }
        $dataList['actionTitle'] = $isToCreate ? 'Create Task' : 'Edit Task';
        $dataList['isCreate'] = $isToCreate;
        $dataList['actionRoute'] = $isToCreate ? route('task.create') : route('task.edit', [$id]);
        return view('task.edit', $dataList);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:' . Task::TITLE_LEN,
            'description' => 'required|max:400' . Task::DESCRIPTION_LEN
        ]);
        $data['user_id'] = $request->user()->id;
        $task = new Task($data);
        $task->save();
        return redirect()->route('dashboard');
    }

    public function edit(EditTaskRequest $request, string $id)
    {
        $task = Task::findOrFail($id);
        asset($task->user_id === Auth::user()->id && $task->canBeEdited());
        $task->update(
            $request->only([
                'title',
                'description'
            ])
        );
        return redirect()->route('dashboard');
    }

    /** @return Task[] */
    public static function getTasksFrom(User $user) : array 
    {
        return Task::where('user_id', '=', $user->id)->get()->all();
    }

    public function delete(Request $request)
    {
        $id = $request->get('id');
        if (Auth::check())
        {
            $task = Task::where(
                'user_id', '=', Auth::user()->id
            )->where(
                'id', '=', $id
            )
            ->first();
            if ($task)
            {
                $task->delete();
                return '1';            
            }
            return '0';
        }
        return '-1';
    }

    public function check(string $taskId) 
    {
        if (Auth::check())
        {
            $task = Task::where([
                ['user_id', '=', Auth::user()->id],
                ['id', '=', $taskId]
            ])->first();
            if ($task)
            {
                $task->is_completed = true;
                $task->save();
                return '1';
            }
            return '0';
        }
        return '-1';
    }


}
