<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Follow extends Model
{
    //@TODO updateOrCreateに直す
    public function updateFollow($followEntity) :bool {

        try
        {
            if (empty($followEntity['id'])) {
                $follow = new \App\Follow;
            } else {
                $follow = \App\Follow::firstOrNew(array('id' => $followEntity['id']));
            }

            foreach ($followEntity as $key => $value) {
                $follow->{$key} = $value;
            }

            $follow->save();

            return true;
        } catch(\exception $e) {
            // エラー内容の表示

            //var_dump($e);
            echo $e->getMessage();

            return false;
        }
    }
}
