@extends('layouts.app-master')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel 8 CRUD Example from scratch </h2>
            </div>
            <div class="pull-right">
                {{--                @can('create')--}}
{{--                <a class="btn btn-success" href="{{ route('thing.create') }}"> Create New Thing</a>--}}
                {{--                @endcan--}}
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Img</th>
        </tr>
        @foreach ($shoes as $shoe)
            <tr>
                <td><font>{{ $shoe->shoes_name }} </font>
                <td>{{ $shoe->price_euro }} </td>
                <td><img src="{{  $shoe->img  }}" width="100" height="116" alt=""></td>
                <td>
                    <a class="btn btn-info" href="{{ route('Shoes.show', $shoe->shoe_id)}}">Show</a>
                    <a class="btn btn-info" href="{{ route('Shoes.edit', $shoe->shoe_id)}}">Update</a>
                    <form action="{{ route('Shoes.destroy', $shoe->shoe_id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $shoes->links() }}
@endsection
