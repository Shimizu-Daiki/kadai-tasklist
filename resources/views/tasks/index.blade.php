@extends('layouts.app')

@section('content')

<!-- ここにページ毎のコンテンツを書く -->
    <h1>タスク一覧</h1>
    @if (Auth::check())
    
        @if (count($tasks) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>status</th>
                        <th>タスク</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                    <tr>
                        
                        <td>{!! link_to_route('tasks.show', $task->id, ['task' => $task->id]) !!}</td>
                        <td>{{ $task-> status}}</td>
                        <td>{{ $task->content }}</td>
                    </tr>
                    
                    @endforeach
                </tbody>
            </table>
        @endif
        
    @else
    
        @include('welcome')
        
    @endif
    
    
    {{-- メッセージ作成ページへのリンク --}}
    {!! link_to_route('tasks.create', 'タスクの追加', [], ['class' => 'btn btn-primary']) !!}
    
@endsection