@extends('layouts.app')
@section('title', 'Detalle del Proyecto')
@section('content')

<h1>{{ $project->title }}</h1>
<p><strong>Descripción:</strong> {{ $project->description }}</p>
<p><strong>Fecha límite:</strong> {{ $project->deadline }}</p>
<p><strong>Estado:</strong> {{ $project->status }}</p>

<a href="{{ route('projects.index') }}">Volver</a>

@endsection
