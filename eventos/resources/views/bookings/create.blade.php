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

        <label for="categoria">Categoria: </label>
        <select id="categoria" name="event_category_id">
            <option value=""></option>
            <option value="infantil">Cumpleaños infantil</option>
            <option value="quince">Fiesta de 15</option>
            <option value="boda">Boda</option>
            <option value="babyshower">Baby shower</option>
            <option value="bautismo">Bautismo</option>
            <option value="cumpleaniosAdulto">Cumpleaños de adulto</option>
        </select>

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