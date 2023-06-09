<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

   <link rel="stylesheet" href="css/spk.css">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=MuseoModerno&family=Poppins:wght@300;400&display=swap" rel="stylesheet">

   <title> SISTEM PENDUKUNG KEPUTUSAN </title>
</head>

<body class="">


   @section('nav-side')
      <nav class="navbar bg-primary" data-bs-theme="dark">
         <div class="container">
            <a class="navbar-brand" href="#">Sistem Pendukung Keputusan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
               <div class="offcanvas-header">
                  <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Sistem Pendukung Keputusan</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
               </div>
               <div class="offcanvas-body">
                  <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                     <li class="nav-item">
                        <a class="nav-link" href="/spk">Home</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="/kriteria">Data Kriteria</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="/alternatif">Data Alternatif</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="/nilai-alternatif">Nilai Alternatif</a>
                     </li>
                     <li class="nav-item">
                     </li>
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                           Hasil Seleksi
                        </a>
                        <ul class="dropdown-menu">
                           <li>
                              <a class="dropdown-item" href="/hasil-seleksi/SAW">Simple Additive Weighting (SAW)</a>
                           </li>
                           <li>
                              <a class="dropdown-item" href="/hasil-seleksi/WP">Weighted Product (WP)</a>
                           </li>
                           <li>
                              <a class="dropdown-item text-wrap" href="/hasil-seleksi/TOPSIS">Technique for Order of Preference by Similarity to Ideal Solution (TOPSIS)</a>
                           </li>
                        </ul>
                     </li>
                  </ul>
                  {{-- <form class="d-flex mt-3" role="search">
                     <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                     <button class="btn btn-outline-success" type="submit">Search</button>
                  </form> --}}
               </div>
            </div>
         </div>
      </nav>
   @show

   <div class="container">
      @yield('content')
   </div>


   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>




</body>

</html>
