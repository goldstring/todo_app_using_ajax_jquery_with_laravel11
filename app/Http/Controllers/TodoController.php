<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class TodoController extends Controller
{
    public function index()
    {



        return view('todo');
    }

    public function getTodoList(Request $request)
    {

        try {


            if ($request->has('pageNo')) {

                $perPage = $request->input('perPage', 5);
                $pageNo = $request->input('pageNo', 1);

                $todoListTotalRecords = DB::table('todos')->count('id');
                $pageNo = (($todoListTotalRecords % $perPage) == 0) ? ($todoListTotalRecords / $perPage) : $pageNo;

                $todoList = DB::table('todos')
                    ->selectRaw("TO_BASE64(AES_ENCRYPT(id, ?)) as todo_id, title", ['todo'])
                    ->orderBy('id', 'desc')
                    ->limit($perPage)
                    ->offset(($pageNo > 1) ? ($pageNo - 1) * $perPage : 0)
                    ->get();




                return response()->json(['data' => $todoList, 'totalTodoRecords' => $todoListTotalRecords, 'status' => 'success'], 200);
            } else {
                return response()->json(['msg' => 'Todo Fetch Failed', 'status' => 'error'], 200);
            }
        } catch (Throwable $e) {

            return response()->json(['msg' => $e->getMessage(), 'status' => 'error'], 200);
        }
    }



    public function todoHandler(Request $request)
    {
        try {
            $validated = $request->validate([
                'todo' => 'required'
            ], [
                'todo.required' => 'Todo is required!'
            ]);

            if (count($validated) > 0) {

                if (DB::table('todos')->insertGetId([
                    'title' => $validated['todo']
                ]) != '') {

                    return response()->json(['msg' => 'Todo Added Successfully', 'status' => 'success'], 200);
                } else {
                    return response()->json(['msg' => 'Todo Added Failed', 'status' => 'error'], 200);
                }
            } else {
                return response()->json(['msg' => 'Todo Added Failed', 'status' => 'error'], 200);
            }
        } catch (Throwable $e) {

            return response()->json(['msg' => $e->getMessage(), 'status' => 'error'], 200);
        }
    }


    public function deleteHandler(Request $request)
    {
        try {

            if ($request->has('todo')) {

                $todo = $request->input('todo');



                $noOfRecorsDeleted = DB::table('todos')
                    ->whereRaw("id = AES_DECRYPT(FROM_BASE64(?),?)", [$todo, 'todo'])
                    ->delete();


                if (
                    $noOfRecorsDeleted > 0
                ) {

                    return response()->json(['msg' => 'Todo Deleted Successfully', 'status' => 'success'], 200);
                } else {
                    return response()->json(['msg' => 'Todo Deleted Failed', 'status' => 'error'], 200);
                }
            } else {
                return response()->json(['msg' => 'Todo AddedDeleted Failed', 'status' => 'error'], 200);
            }
        } catch (Throwable $e) {

            return response()->json(['msg' => $e->getMessage(), 'status' => 'error'], 200);
        }
    }
}