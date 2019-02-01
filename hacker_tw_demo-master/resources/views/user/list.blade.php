@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if(!empty($users))
            <div class="card">
                <div class="card-header">ユーザ一覧</div>

                @foreach ($users as $user)

                    <div class="card-body">
                        {{ $user->name }}

                        <div style="float:right">
                            @if (empty($user->follow_id))
                                {!! Form::open(['id' => 'formTweet', 'url' => 'users/follow/', 'enctype' => 'multipart/form-data']) !!}
                                    {{Form::hidden('followId', $user->id, ['id' => 'followId'])}}
                                    <button type="submit" class="btn btn-light">
                                        {{ __('フォローする') }}
                                    </button>
                                {!! Form::close() !!}
                            @else
                                フォロー中
                            @endif

                        </div>
                    </div>

                    <hr>
                @endforeach

                {{ $users->links() }}

            </div>
            @endif

        </div>
    </div>
</div>
@endsection
