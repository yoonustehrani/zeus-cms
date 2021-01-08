@extends('ZEV::index')

@section('css')
    
@endsection

@section('pagecontent')
<div class="col-12 float-left p-3">
    <h3 class="col-12 p-0 float-left">
        <a href="{{ route(config('ZECMM.controllers.route') . 'templates.create') }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i></a>
        List of Email Templates
    </h3>
    <table class="table table-bordered table-sm text-center float-left">
        <thead class="thead-dark">
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Campaigns</th>
            <th scope="col">Visit</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </thead>
        <tbody>
            @foreach ($templates as $template)
            <tr>
                <th scope="row">{{ $loop->index + 1 }}</th>
                <td>{{ $template->name }}</td>
                <td>{{ $template->campaigns_count }}</td>
                <td>
                    <a target="_blank" href="{{ route(config('ZECMM.controllers.route') . 'templates.show', ['template' => $template->id]) }}" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></a>
                </td>
                <td>
                    <a href="{{ route(config('ZECMM.controllers.route') . 'templates.edit', ['template' => $template->id]) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-pencil-alt"></i></a>
                </td>
                <td>
                    <form action="{{ route(config('ZECMM.controllers.route') . 'templates.destroy', ['template' => $template->id]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection