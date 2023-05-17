@extends('templates.layout')

@section('nav-side')
   @parent
@endsection


@section('content')
   <div class="container mt-5 border rounded-2 py-4">

      <div class="container mb-4 text-start">
         <h3>Nilai Alternatif</h3>
      </div>
      <table class="table table-striped-columns border">
         <thead>
            <tr>
               <th class="col-1 text-center" scope="col">No.</th>
               <th class="col-4" scope="col">Nama Alternatif</th>
               @foreach ($kategories as $kategori)
                  <th class="text-center" scope="col">{{ $kategori->kategori }}</th>
               @endforeach
               <th class="col-1 text-center" scope="col">Aksi</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($alternatives as $alternatif)
               <tr>
                  <th class="align-middle text-center" scope="row">{{ $loop->iteration }}</th>
                  <td class="align-middle">{{ $alternatif->nama }}</td>

                  @php($num = 0)

                  @foreach ($alternatif->kategories as $kategori)
                     @php($num++)
                     <td class="align-middle text-center">{{ $kategori->pivot->nilai }}</td>
                  @endforeach

                  @if ($num < $kolomKategori)
                     @for ($i = $num; $i < $kolomKategori; $i++)
                        <td class="align-middle text-center"></td>
                     @endfor
                  @endif

                  <td class="text-center">
                     <a class="btn btn-primary btn-sm" href="/nilai-alternatif/{{ $alternatif->id }}/edit" role="button">Tambah|Ubah
                     </a>
                  </td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
@endsection
