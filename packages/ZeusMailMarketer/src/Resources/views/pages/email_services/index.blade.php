@extends('ZEV::index')

@section('css')
    
@endsection

@section('pagecontent')
<div class="col-12 float-left p-3">
    <h3 class="col-12 p-0 float-left">
        <a href="{{ route(config('ZECMM.controllers.route') . 'services.create') }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i></a>
        List of Email Services
    </h3>
    <table class="table table-bordered table-sm text-center float-left">
        <thead class="thead-dark">
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Type</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </thead>
        <tbody>
            @foreach ($email_services as $service)
            <tr>
                <th scope="row">{{ $loop->index + 1 }}</th>
                <td>{{ $service->name }}</td>
                <td>{{ $service->type->name }}</td>
                <td>
                    <a href="{{ route(config('ZECMM.controllers.route') . 'services.edit', ['service' => $service->id]) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-pencil-alt"></i></a>
                </td>
                <td>
                    <form action="{{ route(config('ZECMM.controllers.route') . 'services.destroy', ['service' => $service->id]) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection