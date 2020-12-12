@extends('ZEV::index')

@section('css')
    
@endsection

@section('pagecontent')
<div class="col-12 float-left p-3">
    <h3 class="col-12 p-0 float-left">
        {{-- <a href="{{ route('RomanCamp.' . $datatype->slug . '.create') }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> <i class="{{ $datatype->icon }}"></i></a> --}}
        List of Extentions
    </h3>
    <table class="table table-bordered table-sm text-center float-left">
        <thead class="thead-dark">
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Main Page</th>
        </thead>
        <tbody>
            @foreach ($extentions as $ext)
            <tr>
                <th scope="row">{{ $loop->index + 1 }}</th>
                <td>{{ $ext['name'] }}</td>
                <td><a href="{{ route('RomanCamp.extention.' . $ext['routes']['as']) }}" class="btn btn-warning"><i class="fas fa-eye"></i></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection