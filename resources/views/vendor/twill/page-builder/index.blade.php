@extends('twill::layouts.main')

@section('content')
<div class="container">
    <h2>Pages</h2>
    <a href="{{ route('pages.create') }}" class="btn btn-success mb-3">Add Page</a>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th><th>Slug</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pages as $page)
            <tr>
                <td>{{ $page->title }}</td>
                <td>{{ $page->slug }}</td>
                <td>
                    <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('pages.destroy', $page->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete page?')" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
