@extends('ZEV::index')

@section('css')
    <title>{{ $dataType->display_name_plural }}</title>
@endsection

@section('pagecontent')
    <div class="col-12 float-left p-3">
        <table class="table table-bordered text-center">
            <thead class="thead-dark">
                <th scope="col">#</th>
                @foreach ($dataType->columns as $column)
                    <th scope="col">{{ $column->display_name }}</th>
                @endforeach
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </thead>
            <tbody>
                @foreach ($data as $dt)
                <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    @foreach ($dataType->columns as $column)
                    <td>{{ $dt[$column->field] }}</td>
                    @endforeach
                    <td><a class="btn btn-outline-info" href="{{ route('RomanCamp.' . $dataType->slug . '.edit' , ['id' => $dt->id]) }}"><i class="fas fa-pencil-alt"></i></a></td>
                    <td>
                        <form action="{{ route('RomanCamp.' . $dataType->slug . '.destroy' , ['id' => $dt->id]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
