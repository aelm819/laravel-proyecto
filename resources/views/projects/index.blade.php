@extends('layouts.app')
@section('title', 'Proyectos')
@section('content')

<a href="{{route('projects.create')}}">Nuevo proyecto</a>
@foreach ($projects as $project)

{{$project->title}} <br>
{{$project->status}} <br>
<a href="{{route('projects.show', $project)}}">Ver</a>
<a href="{{route('projects.edit', $project)}}">Editar</a>
<form action="{{route('projects.destroy', $project)}}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit">Eliminar</button>
</form>
@endforeach
@endsection