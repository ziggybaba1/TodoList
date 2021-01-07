<?php

namespace App\Http\Controllers\v1\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Todo\TodoRequest;
use App\Http\Resources\SingleData;
use App\Models\Todo;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(TodoRequest $request){
        $message = "Todo could not retrieve";
        $status = 200;
        $todos = $request->user()->todos()->orderBy('created_at', 'asc')->paginate(10);
        if($todos)
        {
            $message = "Successful";
        }
        return (SingleData::make($todos) )->additional(['message' => $message,'status'=>$status])->response()->setStatusCode($status);
    }

    public function store(TodoRequest $request)
    {
        $message = "Todo could not store";
        $status = 400;
        try{
            $request->user()->todos()->create([
                'name' => $request->name,
                ]);
                $todos = $request->user()->todos()->orderBy('created_at', 'asc')->paginate(10);
                if($todos)
                {
                    $message = "Successful";
                    $status = 200;
                }
                return (SingleData::make($todos) )->additional(['message' => $message,'status'=>$status ])->response()->setStatusCode($status);
        }
        catch (\Exception $e) {
            return response()->json([
                'message'    =>   $message,
                'success'   =>  false,
                'status'=>$status 
            ],  $status );  
        }

    }
    public function update(TodoRequest $request,Todo $todos)
    {
        $message = "Todo could not store";
        $status = 400;
        //$todos=Todo::find($todo);
        try{
            $todos->update([
                'name' => $request->name,
                'complete'=>!$todos->complete
                ]);
               
                $todos = $request->user()->todos()->orderBy('created_at', 'asc')->paginate(10);
                if($todos)
                {
                    $message = "Successful";
                    $status = 200;
                }
                return (SingleData::make($todos) )->additional(['message' => $message ])->response()->setStatusCode($status);
        }
        catch (\Exception $e) {
            return response()->json([
                'message'    =>   $message,
                'success'   =>  false,
                'status'=>$status 
            ],  $status );
        }

    }
    public function destroy(TodoRequest $request,Todo $todos)
    {
        $message = "Todo could not delete";
        $status = 400;
        //$todos=Todo::find($todo);
        try{
            $this->authorize('destroy', $todos);
                $todos->delete();
                $todos = $request->user()->todos()->orderBy('created_at', 'asc')->paginate(10);
                if($todos)
                {
                    $message = "Successful";
                    $status = 200;
                }
            return (SingleData::make($todos) )->additional(['message' => $message ])->response()->setStatusCode($status);
        }
        catch (\Exception $e) {
            return response()->json([
                'message'    =>   $message,
                'success'   =>  false,
                'status'=>$status 
            ],  $status ); 
        }

    }
}
