@extends('templates.layout')

@section('nav-side')
   @parent
@show

@section('content')

   <div class="container col-10 bg-body-tertiary mt-5 mb-3 border rounded-2 py-5 px-5">
      <h1 class="mb-4">UPDATE DATA ALTERNATIF</h1>

      <form action="/alternatif/{{ $id }}" method="post">
         @method('put')
         @csrf
         <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $nama }}">
            @error('nama')
               <div class="invalid-feedback">
                  Data Nama Kosong
               </div>
            @enderror
         </div>

         <div class="mb-3">
            <label for="jenis" class="form-label">Jenis Kelamin</label>
            <select name="jenisKelamin" id="jenis" class="form-select" aria-label="Default select example">
               <option value="" selected>Pilih</option>
               <option value="laki-laki" @if ($jenisKelamin == 'laki-laki') selected @endif>Laki-laki</option>
               <option value="perempuan" @if ($jenisKelamin == 'perempuan') selected @endif>Perempuan</option>
            </select>
            @error('jenisKelamin')
               <div class="invalid-feedback">
                  Data Jenis Kelamin Kosong
               </div>
            @enderror
         </div>

         <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $alamat }}">
            @error('jenisKelamin')
               <div class="invalid-feedback">
                  Data Alamat Kosong
               </div>
            @enderror
         </div>

         <input class="btn btn-primary mt-3" type="submit" value="UBAH">
         <div class="text-end">
         </div>
      </form>
   </div>

@endsection
