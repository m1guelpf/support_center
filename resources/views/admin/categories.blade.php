@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-ticket"> Categories</i>
                </div>

                <div class="panel-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>
                                    {{ $category->id }}
                                    </td>
                                    <td>
                                        {{ $category->name }}
                                    </td>
                                    <td>
                                        <form action="{{ url('admin/category/' . $category->id) }}" method="POST">
                                            {!! csrf_field() !!}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br><br>
                        <center>
                        <form action="{{ url('admin/categories') }}" method="POST">
                        {!! csrf_field() !!}
                        <input type="text" name="name" placeholder="Category Name" value="{{ old('name') }}">
                        <button type="submit" class="btn btn-success">Add</button>
                        </form>
                        @if (count($errors) > 0)
                          <div class="alert alert-danger">
                            <ul>
                              @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                              @endforeach
                            </ul>
                          </div>
                        @endif
                        </center>
                </div>
            </div>
        </div>
    </div>
@endsection
