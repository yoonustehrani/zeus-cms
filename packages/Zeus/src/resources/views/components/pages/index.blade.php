@extends('ZEV::index')

@section('css')
    <title>Database</title>
@endsection

@section('pagecontent')
    <div class="col-12 float-left p-3">
        <table class="table table-bordered text-center">
            <thead class="thead-dark">
                <th scope="col">#</th>
                <th scope="col">Table Name</th>
                <th scope="col"></th>
                <th scope="col">Browse</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </thead>
            <tbody>
                @foreach ($tables as $table)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $table->prefix . $table->name }}</td>
                        <td class="text-left">
                            @if ($table->dataTypeId)

                            @else
                                <a class="btn btn-sm btn-light" href="#add-to-army">add {{ $table->name }} to Roman Army</a>
                            @endif
                        </td>
                        <td><a class="btn btn-sm btn-warning" href=""><i class="fas fa-search"></i></a></td>
                        <td><a class="btn btn-sm btn-primary" href=""><i class="fas fa-pencil-alt"></i></a></td>
                        <td><a class="btn btn-sm btn-danger" href=""><i class="fas fa-trash"></i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
