@extends('layouts.app')
@section('content')
<form action="{{ route('projects.store') }}" method="POST">
    @csrf

    <input type="text" name="title" value="{{ old('title') }}">
    @error('title')
        <p>{{ $message }}</p>
    @enderror

    <input type="text" name="description" value="{{ old('description') }}">
    @error('description')
        <p>{{ $message }}</p>
    @enderror

    <input type="date" name="deadline" value="{{ old('deadline') }}">
    @error('deadline')
        <p>{{ $message }}</p>
    @enderror

    <input type="text" name="status" value="{{ old('status') }}">
    @error('status')
        <p>{{ $message }}</p>
    @enderror

    <button type="submit">Enviar</button>
</form>
@endsection
