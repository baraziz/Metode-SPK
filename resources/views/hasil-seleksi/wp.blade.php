@extends('templates.layout')

@section('nav-side')
   @parent
@show

@section('content')
   <div class="container bg-body-secondary mt-4 border rounded-3 py-3 px-4">
      <h2>Weighted Product (WP)</h2>
   </div>

   <div class="container mt-3 border border-2 rounded-3 py-3 px-4">
      <h3 class="mb-3">Tabel Bobot W</h3>
      <table class="table table-striped border">
         <thead>
            <tr>
               @foreach ($bobot_w as $bobot)
                  <th class="col align-middle text-center" scope="col">{{ $bobot['kategori'] }} <br> ({{ $bobot['atribut'] }})</th>
               @endforeach
            </tr>
         </thead>
         <tbody>
            <tr>
               @foreach ($bobot_w as $bobot)
                  <td class="align-middle text-center">{{ $bobot['bobot_w'] }}</td>
               @endforeach
            </tr>
         </tbody>
      </table>
   </div>

   <div class="container mt-3 border border-2 rounded-3 py-3 px-4">
      <h3 class="mb-3">Tabel Bobot S</h3>
      <table class="table table-striped border">
         <thead>
            <tr>
               <th class="col-1 text-center" scope="col">#</th>
               <th class="col-3" scope="col">Nama</th>
               @foreach ($bobot_w as $bobot)
                  <th class="col align-middle text-center" scope="col">{{ $bobot['kategori'] }}</th>
               @endforeach
               <th class="col-2 text-center" scope="col">Bobot S</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($bobot_s as $bobot)
               <tr>
                  <th class="align-middle text-center" scope="row">{{ $loop->iteration }}</th>
                  <td class="align-middle">{{ $bobot['nama'] }}</td>
                  @foreach ($bobot['normalisasi'] as $item)
                     <td class="align-middle text-center">{{ $item }}</td>
                  @endforeach
                  <td class="align-middle text-center fw-bold">{{ $bobot['bobot_s'] }}</td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>

   <div class="container mt-3 border border-2 rounded-3 py-3 px-4">
      <h3 class="mb-3">Tabel Bobot V</h3>
      <table class="table table-striped border">
         <thead>
            <tr>
               <th class="col-1 text-center" scope="col">#</th>
               <th class="col" scope="col">Nama</th>
               <th class="col text-center" scope="col">Bobot V</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($bobot_v as $bobot)
               <tr>
                  <th class="align-middle text-center" scope="row">{{ $loop->iteration }}</th>
                  <td class="align-middle">{{ $bobot['nama'] }}</td>
                  <td class="align-middle text-center fw-bold">{{ $bobot['bobot_v'] }}</td>
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
               <th class="col text-center" scope="col">Bobot</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($rankings as $ranking)
               <tr>
                  <th class="align-middle text-center" scope="row">{{ $loop->iteration }}</th>
                  <td class="align-middle">{{ $ranking['nama'] }}</td>
                  <td class="align-middle text-center fw-bold">{{ $ranking['bobot_v'] }}</td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>


@endsection
