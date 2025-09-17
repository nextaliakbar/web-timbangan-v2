<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi Timbangan</title>

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
  <!-- Select2 Bootstrap4 Theme -->
  <link rel="stylesheet" href="{{asset('adminlte3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  @livewireStyles
</head>
<body class="hold-transition layout-fixed sidebar-collapse">
<div class="wrapper">

  @livewire('main.navbar')

  @yield('content')

  <!-- Footer -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">Version 3.2.0</div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>

<!-- jQuery -->
<script data-navigate-once src="{{asset('adminlte3/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script data-navigate-once src="{{asset('adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script data-navigate-once src="{{asset('adminlte3/dist/js/adminlte.min.js')}}"></script>
<!-- SweetAlert2 -->
<script data-navigate-once src="{{asset('adminlte3/plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
<!-- Momemnt -->
<script data-navigate-once src="{{asset('adminlte3/plugins/moment/moment.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script data-navigate-once src="{{asset('adminlte3/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Select2 -->
<script data-navigate-once src="{{asset('adminlte3/plugins/select2/js/select2.full.min.js')}}"></script>

@if(session()->has('error'))
<script>
  Swal.fire({
    title: 'Akses Ditolak',
    text: '{{session()->get("error")}}',
    icon: 'error'
  });
</script>
@endif
@livewireScripts
</body>
</html>
