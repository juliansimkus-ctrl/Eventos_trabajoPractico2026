@extends('layouts.eventos')

@section('content')
   <section>
       <h1>Simkus Eventos</h1>
       <p>Decoramos tus momentos felices.</p>
   </section>

   <h3><a href="{{ route('bookings.create') }}">Pedí tu presupuesto</a></h3>

   <section>
        <h2>Proximos eventos</h2>
   </section>

@endsection