@extends('templates.layout')

@section('nav-side')
   @parent
@show

@section('content')
   <div class="container bg-body-secondary mt-4 border rounded-3 py-3 px-4">
      <h2>TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution)</h2>
   </div>

   <div class="container mt-3 border border-2 rounded-3 py-3 px-4">
      <h3 class="mb-3">Tabel Normalisasi</h3>
      <table class="table table-striped border">
         <thead>
            <tr>
               <th class="col-1 text-center" scope="col">#</th>
               <th class="col-3" scope="col">Nama</th>
               @foreach ($kategories as $kategori)
                  <th class="col text-center" scope="col">{{ $kategori->kategori }} ({{ $kategori->bobot }})</th>
               @endforeach
            </tr>
         </thead>
         <tbody>
            @foreach ($alternatives as $alternatif)
               <tr>
                  <th class="align-middle text-center" scope="row">{{ $loop->iteration }}</th>
                  <td class="align-middle">{{ $alternatif->nama }}</td>
                  @foreach ($alternatif->normalizedMatrix as $normalisasi)
                     <td class="align-middle text-center">{{ $normalisasi }}</td>
                  @endforeach
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>

   <div class="container mt-3 border border-2 rounded-3 py-3 px-4">
      <h3 class="mb-3">Tabel Pembobotan</h3>
      <table class="table table-striped border">
         <thead>
            <tr>
               <th class="col-1 text-center" scope="col">#</th>
               <th class="col-3" scope="col">Nama</th>
               @foreach ($kategories as $kategori)
                  <th class="col text-center" scope="col">{{ $kategori->kategori }} ({{ $kategori->bobot }})</th>
               @endforeach
               <th class="col-2 text-center" scope="col">Total</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($alternatives as $alternatif)
               <tr>
                  <th class="align-middle text-center" scope="row">{{ $loop->iteration }}</th>
                  <td class="align-middle">{{ $alternatif->nama }}</td>
                  @foreach ($alternatif->weightedMatrix as $dataBobot)
                     <td class="align-middle text-center">{{ $dataBobot }}</td>
                  @endforeach
                  <td class="align-middle text-center fw-bold">{{ $alternatif->ranking }}</td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>

   <div class="container mt-3 mb-5 border border-2 rounded-3 py-3 px-4">
      <h3 class="mb-3">Tabel Ranking</h3>
      <table class="table table-striped border">
         <thead>
            <tr>
               <th class="col-1 text-center" scope="col">#</th>
               <th class="col" scope="col">Nama</th>
               <th class="col text-center" scope="col">Nilai Akhir</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($rankings as $ranking)
               <tr>
                  <th class="align-middle text-center" scope="row">{{ $loop->iteration }}</th>
                  <td class="align-middle">{{ $ranking['nama'] }}</td>
                  <td class="align-middle text-center fw-bold">{{ $ranking['bobot'] }}</td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
@endsection
