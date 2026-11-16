@extends('layouts.app')
@section('title', 'Detalle del Proyecto')
@section('content')

<h1>{{ $project->title }}</h1>
<p><strong>Descripción:</strong> {{ $project->description }}</p>
<p><strong>Fecha límite:</strong> {{ $project->deadline }}</p>
<p><strong>Estado:</strong> {{ $project->status }}</p>

@foreach ($project->users as $user)
{{$user->name}}
{{$user->pivot->role}}
{{$user->pivot->contribution_hours}}

<form action="{{route('projects.users.detach', [$project, $user])}}" method="POST">
    @method('DELETE')
    @csrf
    <button type="submit">Eliminar</button>
</form>
@endforeach

<form action="{{route('projects.users.attach', $project)}}" method="POST">
    @csrf
    <select name="user_id">
        @foreach ($users as $user)
        <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>
    <label for="role">Role:</label>
    <input type="text" name="role" id="role">
    <label for="hours">Contribution's hours:</label>
    <input type="number" name="contribution_hours" id="hours">
    <button type="submit">Enviar</button>
</form>



<a href="{{ route('projects.index') }}">Volver</a>

@endsection