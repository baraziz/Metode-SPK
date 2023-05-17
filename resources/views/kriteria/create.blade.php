@extends('templates.layout')

@section('nav-side')
   @parent
@show

@section('content')

   <div class="container col-10 bg-body-tertiary mt-5 mb-3 border rounded-2 py-5 px-5">
      <h1 class="mb-4">TAMBAH DATA KRITERIA</h1>
      <form class="" action="/kriteria" method="post">

         @csrf

         <div class="mb-3">
            <label for="nama" class="form-label">Kriteria</label>
            <input type="text" class="form-control  @error('kriteria') is-invalid @enderror" id="nama" name="kriteria">
            @error('kriteria')
               <div class="invalid-feedback">
                  Data kriteria Kosong
               </div>
            @enderror
         </div>

         <div class="mb-3">
            <label for="jeniskelamin" class="form-label">Atribut</label>
            <select id="jenisKelamin" name="atribut" class="form-select  @error('atribut') is-invalid @enderror" aria-label="Default select example">
               <option selected>Pilih</option>
               <option value="benefit">Benefit</option>
               <option value="cost">Cost</option>
            </select>
            @error('atribut')
               <div class="invalid-feedback">
                  Data Atribut Kosong
               </div>
            @enderror
         </div>

         <div class="mb-3">
            <label for="bobot" class="form-label">Bobot (1-10)</label>
            <input type="number" class="form-control  @error('bobot') is-invalid @enderror" id="bobot" name="bobot">
            @error('bobot')
               <div class="invalid-feedback">
                  Data Atribut Kosong | kurang atau lebih dari ketentuan
               </div>
            @enderror
         </div>

         <div class="text-end">
            <input class="btn btn-primary mt-3" type="submit" value="TAMBAH">
         </div>
      </form>
   </div>

@endsection
