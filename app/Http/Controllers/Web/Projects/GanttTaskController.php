<?php


namespace App\Http\Controllers\Web\Projects;

use App\Models\GanttTask;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GanttTaskController extends Controller
{
    public function index(Request $request)
    {

        $items = GanttTask::where('rfp_id',$request->rfp_id)->get();

        $message = 'Return Data successfully';
        return mainResponse(true, $message , $items, 200, 'items',''); 
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $task = GanttTask::create($request->all());
        $message = 'Return Data successfully';
        return mainResponse(true, $message , $task, 200, 'items',''); 

    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $task = GanttTask::findOrFail($id);
        $task->update($request->all());


        $message = 'Return Data successfully';
        return mainResponse(true, $message , $task, 200, 'items','');
    }

    public function destroy($id)
    {
        GanttTask::destroy($id);
        // GanttTask::where('parent',$id)->destroy();

        $message = 'Return Data successfully';
        return mainResponse(true, $message ,'', 200, 'items','');
    }



   
}
