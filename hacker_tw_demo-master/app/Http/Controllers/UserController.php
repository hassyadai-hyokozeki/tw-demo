<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Userデータ取得

        // $userModel = new \App\User;
        // $where = [
        //     ['users.id', '<>', Auth::id()],
        // ];
        // $join = [
        //     [
        //         "tableName" => "follows",
        //         "joinType" => "leftJoin",
        //         "joinCondition" => function ($join) {
        //             $join->on('users.id', '=', 'follows.follow_id');
        //             $join->where('follows.user_id', '=', Auth::id());
        //         }
        //     ],
        // ];
        // $select = ['users.*','follows.user_id', 'follows.follow_id'];
        // $users = $userModel->getUsers($where, $join, $select);


        //Eloquent使用して取得
        $where = [
            ['users.id', '<>', Auth::id()],
        ];

        try
        {
            $users = User::select(['users.*','follows.user_id', 'follows.follow_id'])
                ->leftJoin('follows', function($join) {
                    $join->on('users.id', '=', 'follows.follow_id');
                    $join->where('follows.user_id', '=', Auth::id());
                })
                ->where($where)
                ->paginate(5);
        } catch(\exception $e) {

             //エラー内容をLog出力
             \Log::error($e->getMessage());

             $request->session()->flash('message', 'ユーザーデータ取得時エラーが発生しました。');
             $users = [];
        }


        return view('user.list', ['users' => $users]);
    }

    public function follow(Request $request)
    {
        $id = Auth::id();
        // $user = Auth::user();

        //insert
        $followEntity = [
            'user_id' => $id,
            'follow_id' => $request->input('followId'),
        ];

        //@TODO Eloquentに直す。
        $followModel = new \App\Follow;
        if (!$followModel->updateFollow($followEntity)) {
            //@TODO エラーハンドリングを実装する
            echo "errorです。";
            die();
        }

        return redirect()->route('user_list');
    }
}
