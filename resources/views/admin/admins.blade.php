@extends('layouts.app')

@section('title', 'Administrators')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-ticket"> Administrator</i>
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
                            @foreach ($administrators as $admin)
                                <tr>
                                    <td>
                                    {{ $admin->id }}
                                    </td>
                                    <td>
                                    {{ ucfirst($admin->name) }}
                                    </td>
                                    <td>
                                        <form action="{{ url('admin/administrators/' . $admin->id) }}" method="POST">
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
                        <form action="{{ url('admin/administrators') }}" method="POST">
                        {!! csrf_field() !!}
                        <select id="user_id" type="administrators" class="form-control" name="user_id">
                            <option value="">Select new Administrator</option>
                            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ ucfirst($user->name) }}</option>
                            @endforeach
                        </select>
                        <br>
                        <button type="submit" class="btn btn-success">Make Administrator</button>
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
