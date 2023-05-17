@extends('templates.layout')

@section('nav-side')
   @parent
@show

@section('content')

   <div class="container col-10 bg-body-tertiary mt-5 mb-3 border rounded-2 py-5 px-5">
      <h1 class="mb-4">UPDATE DATA KRITERIA</h1>
      <form class="" action="/kriteria/{{ $kriteria->id }}" method="post">
         @method('put')
         @csrf

         <div class="mb-3">
            <label for="nama" class="form-label">Kriteria</label>
            <input type="text" class="form-control  @error('kriteria') is-invalid @enderror" id="nama" name="kriteria" value="{{ $kriteria->kategori }}">
            @error('kriteria')
               <div class="invalid-feedback">
                  Data kriteria Kosong
               </div>
            @enderror
         </div>

         <div class="mb-3">
            <label for="jeniskelamin" class="form-label">Atribut</label>
            <select id="jenisKelamin" name="atribut" class="form-select  @error('atribut') is-invalid @enderror" aria-label="Default select example">
               <option>Pilih</option>
               <option value="benefit" @if ($kriteria->atribut == 'benefit') selected @endif>Benefit</option>
               <option value="cost" @if ($kriteria->atribut == 'cost') selected @endif>Cost</option>
            </select>
            @error('atribut')
               <div class="invalid-feedback">
                  Data Atribut Kosong
               </div>
            @enderror
         </div>

         <div class="mb-3">
            <label for="bobot" class="form-label">Bobot (1-10)</label>
            <input type="number" class="form-control  @error('bobot') is-invalid @enderror" id="bobot" name="bobot" value="{{ $kriteria->bobot }}">
            @error('bobot')
               <div class="invalid-feedback">
                  Data Atribut Kosong | kurang atau lebih dari ketentuan
               </div>
            @enderror
         </div>

         <div class="text-end">
            <input class="btn btn-primary mt-3" type="submit" value="UBAH">
         </div>
      </form>
   </div>

@endsection
