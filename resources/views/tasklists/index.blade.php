@extends('layouts.app')

@section('content')


    @if (Auth::check())
     <?php $user = Auth::user(); ?>
        {{ $user->name }}  
        
    <h1>タスク一覧</h1>


      @if (count($tasklists) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>ステータス</th>
                    <th>タスク</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasklists as $tasklist)
                @if(\Auth::user()->id==$tasklist->user_id)
                    <tr>
                        <td>{!! link_to_route('tasklists.show', $tasklist->id, ['id' => $tasklist->id]) !!}</td>
                        <td>{{ $tasklist->status }}</td>
                        <td>{{ $tasklist->content }}</td>
                    </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    	@endif
    
      {!! link_to_route('tasklists.create', '新規タスクの投稿', null, ['class' => 'btn btn-primary']) !!}

    
    
    
    
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to Tasklist</h1>
                {!! link_to_route('signup.get', 'Sign up now!', null, ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
    @endif




    
  
@endsection