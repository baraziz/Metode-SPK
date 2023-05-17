@extends('templates.layout')

@section('nav-side')
   @parent
@show

@section('content')

   <div class="container col-10 bg-body-tertiary mt-5 mb-3 border rounded-2 py-5 px-5">
      <h1 class="mb-4">TAMBAH/UBAH DATA KRITERIA</h1>
      <h4 class="mb-3">Alternatif : {{ $alternatif->nama }}</h4>
      <form class="" action="/nilai-alternatif/{{ $alternatif->id }}" method="post">
         @method('put')
         @csrf

         @foreach ($kategories as $kategori)
            <div class="mb-3">

               @php($name = str_replace(' ', '', $kategori->kategori))

               <label for="{{ $name }}" class="form-label">{{ $kategori->kategori }} (1-10)</label>
               <input type="number" step="0.01" class="form-control @error("{{ $name }}") is-invalid @enderror" id="{{ $name }}" name="{{ $name }}" value="{{ old("$name") }}">

               @error('{{ $name }}')
                  <div class="invalid-feedback">
                     Data {{ $name }} Kosong
                  </div>
               @enderror

            </div>
         @endforeach

         <div class="text-end">
            <input class="btn btn-primary mt-3" type="submit" value="TAMBAH | UBAH">
         </div>
      </form>
   </div>

@endsection
