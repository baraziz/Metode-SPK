@extends('templates.layout')

@section('nav-side')
   @parent
@endsection

@section('content')
   <div class="container mt-5 border rounded-2 py-3">

      <div class="container text-start">
         <h3>Data Alternatif</h3>
      </div>

      <div class="container text-end mb-3">
         <a class="btn btn-primary" href="alternatif/create" role="button">Tambah Data</a>
      </div>

      <table class="table table-striped border">
         <thead>
            <tr>
               <th class="col-1 text-center" scope="col">#</th>
               <th class="col" scope="col">Nama</th>
               <th class="col-2 text-center" scope="col">Alamat</th>
               <th class="col-2 text-center" scope="col">Jenis Kelamin</th>
               <th class="col-2 text-center" scope="col">Aksi</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($alternatifs as $alternatif)
               <tr>
                  <th class="align-middle text-center" scope="row">{{ $loop->iteration }}</th>
                  <td class="align-middle">{{ $alternatif->nama }}</td>
                  <td class="align-middle text-center">{{ $alternatif->alamat }}</td>
                  <td class="align-middle text-center">{{ $alternatif->jenisKelamin }}</td>
                  <td class="text-center">

                     <form class="d-inline" action="alternatif/{{ $alternatif->id }}" method="post">
                        @method('delete')
                        @csrf
                        <input class="btn btn-danger btn-sm border border-0" type="submit" value="Hapus">
                     </form>
                     <a class="btn btn-primary btn-sm" href="/alternatif/{{ $alternatif->id }}/edit" role="button">Edit
                     </a>
                  </td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
@endsection
