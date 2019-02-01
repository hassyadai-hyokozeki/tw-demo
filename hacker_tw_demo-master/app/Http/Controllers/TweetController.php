<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{

    public function update(Request $request) {
        $id = Auth::id();
        // $user = Auth::user();

        //insert
        $tweetEntity = [
            'user_id' => $id,
            'tweet' => $request->input('tweet'),
        ];

        try
        {
            $tweetModel = new \App\Tweet;
            $tweetModel::updateOrCreate(['id' => ''],$tweetEntity);
        } catch(\exception $e) {
            //エラー内容をLog出力
            \Log::error($e->getMessage());

            $request->session()->flash('message', 'ツイート時にエラーが発生しました。');
        }

        return redirect()->route('home');
    }
}
