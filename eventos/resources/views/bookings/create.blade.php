@extends('layouts.eventos')
@section('content')
    <h1>Nuevo evento</h1>

    @if ($errors->any())
        <div class="errores">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf

        <p>Tipo de evento</p>
        <div class="categorias">
            @foreach ($categories as $category)
            <label class="tarjeta-categoria">
                <input type="radio"
                   name="event_category_id"
                   value="{{ $category->id }}"
                   {{ old('event_category_id') == $category->id ? 'checked' : '' }}
                   required>
            <strong>{{ $category->name }}</strong>
            <p>{{ $category->description }}</p>
            </label>
            @endforeach
        </div>
        @error('event_category_id') <p class="error">{{ $message }}</p> @enderror

        <label for="nombre">Nombre: </label>
        <input id="nombre" name="client_name" value="" required>

        <label for="email">Email: </label>
        <input id="email" type="email" name="client_email" value="" required>

        <label for="telefono">Numero de telefono: </label>
        <input id="telefono" type="tel" name="client_phone" value="" required>

        <label for="fecha">Fecha estimada: </label>
        <input id="fecha" type="date" name="estimated_date" value="" required>

        <label for="invitados">Cantidad de invitados: </label>
        <input id="invitados" name="estimated_guests" type="number" min="1">

        <label for="ideas">Recomendaciones: </label>
        <textarea id="ideas" name="ideas_or_details" required></textarea>

        <button type="submit">Enviar</button>
    </form>