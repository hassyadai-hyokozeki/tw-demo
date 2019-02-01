<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Tweet extends Model
{
    protected $table = 'tweets';    //これは自動的にモデルの複数形になるので実際、指定しなくてもOKではある。
    protected $guarded = array('id');


    public function getTlTweet() {

        //@TODO Eloquentで書き直す
        $tweets = DB::table('tweets')
            ->leftJoin('users', 'users.id', '=', 'tweets.user_id')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('follows')
                      ->whereRaw('follows.follow_id = tweets.user_id and follows.user_id = '. Auth::id());
            })
            ->orWhere('tweets.user_id', '=', Auth::id())
            ->orderByRaw('tweets.created_at DESC')
            ->paginate(5);
            // ->get();

        return $tweets;
    }

    // この関数でやりたかった事は updateOrCreate で実現出来た。
    // public function updateTweet($tweetEntity) :bool {
    //
    //     try
    //     {
    //         if (empty($tweetEntity['id'])) {
    //             $tweet = new \App\Tweet;
    //         } else {
    //             $tweet = \App\Tweet::firstOrNew(array('id' => $tweetEntity['id']));
    //         }
    //
    //         foreach ($tweetEntity as $key => $value) {
    //             $tweet->{$key} = $value;
    //         }
    //
    //         $tweet->save();
    //
    //         return true;
    //     } catch(\exception $e) {
    //         // エラー内容の表示
    //
    //         var_dump($e);
    //
    //         return false;
    //     }
    //
    // }

}
