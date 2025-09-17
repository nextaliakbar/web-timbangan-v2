<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf_token" content="{{csrf_token()}}">
  <title>@yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('adminlte3/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('adminlte3/dist/css/adminlte.min.css')}}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{asset('adminlte3/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('adminlte3/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('adminlte3/plugins/select2/css/select2.min.css')}}">
  <!-- Select2 Theme -->
  <link rel="stylesheet" href="{{asset('adminlte3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <style>
    .loading-overlay {
        position: fixed; /* atau absolute jika hanya ingin menutupi konten */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Latar belakang semi-transparan */
        z-index: 9999; /* Pastikan di atas elemen lain */
        display: flex;
        justify-content: center;
        align-items: center;
    }
  </style>
  @livewireStyles
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    @livewire('admin.navbar')

    @include('layouts.sidebar')
    
    @yield('content')

    @include('layouts.footer')
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script data-navigate-once src="{{asset('adminlte3/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script data-navigate-once src="{{asset('adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script data-navigate-once src="{{asset('adminlte3/dist/js/adminlte.min.js')}}"></script>
<!-- SweetAlert2 -->
<script data-navigate-once src="{{asset('adminlte3/plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
<!-- Moment -->
<script data-navigate-once src="{{asset('adminlte3/plugins/moment/moment.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script data-navigate-once src="{{asset('adminlte3/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Select2 -->
<script data-navigate-once src="{{asset('adminlte3/plugins/select2/js/select2.full.min.js')}}"></script>
@if (session()->has('error'))
<script>
  Swal.fire({
    title: 'Akses Ditolak',
    text: '{{session()->get("error")}}',
    icon: 'error'
  });
</script>
@endif
<div id="loading-overlay" class="loading-overlay d-none">
    <div class="spinner-border text-info" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<script>
    $(document).on('livewire:navigate', ()=> {
        $('#loading-overlay').removeClass('d-none');
    });

    $(document).on('livewire:navigating', ()=> {
        $('#loading-overlay').addClass('d-none');
    });

    $(document).on('livewire:navigated', ()=> {
        $('#loading-overlay').addClass('d-none');
    });
</script>
@livewireScripts
</body>
</html>
