@extends('templates.layout')

@section('nav-side')
   @parent
@endsection


@section('content')
   <div class="container mt-5 border rounded-2 py-3">
      <div class="container text-start">
         <h3>Data Kriteria</h3>
      </div>
      <div class="container text-end mb-3">
         <a class="btn btn-primary" href="kriteria/create" role="button">Tambah Kriteria</a>
      </div>

      <table class="table table-striped border">
         <thead>
            <tr>
               <th class="col-1 text-center" scope="col">No.</th>
               <th class="col" scope="col">Nama Kriteria</th>
               <th class="col-2 text-center" scope="col">Atribut</th>
               <th class="col-2 text-center" scope="col">Bobot</th>
               <th class="col-2 text-center" scope="col">Aksi</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($kategoris as $kategori)
               <tr>
                  <th class="align-middle text-center" scope="row">{{ $loop->iteration }}</th>
                  <td class="align-middle">{{ $kategori->kategori }}</td>
                  <td class="align-middle text-center">{{ $kategori->atribut }}</td>
                  <td class="align-middle text-center">{{ $kategori->bobot }} - {{ $kategori->bobotPersen }}%</td>
                  <td class="text-center">
                     <form class="d-inline" action="kriteria/{{ $kategori->id }}" method="post">
                        @method('delete')
                        @csrf
                        <input class="btn btn-danger btn-sm border border-0" type="submit" value="Hapus">
                     </form>
                     <a class="btn btn-primary btn-sm" href="/kriteria/{{ $kategori->id }}/edit" role="button">Edit
                     </a>
                  </td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
@endsection
