@extends('layouts.app')
@section('title', 'Editar Proyecto')
@section('content')

<form action="{{ route('projects.update', $project) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="title" value="{{ old('title', $project->title) }}">
    @error('title')
        <p>{{ $message }}</p>
    @enderror

    <input type="text" name="description" value="{{ old('description', $project->description) }}">
    @error('description')
        <p>{{ $message }}</p>
    @enderror

    <input type="date" name="deadline" value="{{ old('deadline', $project->deadline) }}">
    @error('deadline')
        <p>{{ $message }}</p>
    @enderror

    <input type="text" name="status" value="{{ old('status', $project->status) }}">
    @error('status')
        <p>{{ $message }}</p>
    @enderror

    <button type="submit">Actualizar</button>
</form>

<a href="{{ route('projects.index') }}">Volver</a>

@endsection
