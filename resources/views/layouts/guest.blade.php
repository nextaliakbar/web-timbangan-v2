<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf_token" content="{{csrf_token()}}">
  <title>Masuk</title>
    <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('adminlte3/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('adminlte3/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('adminlte3/dist/css/adminlte.min.css')}}">
    <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('adminlte3/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  @livewireStyles
</head>
<body>
    @yield('content')
<!-- jQuery -->
<script data-navigate-once src="{{asset('adminlte3/plugins/jquery/jquery.slim.min.js')}}"></script>
<!-- Popper -->
<script data-navigate-once src="{{asset('adminlte3/plugins/popper/umd/popper.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script data-navigate-once src="{{asset('adminlte3/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- SweetAlert2 -->
<script data-navigate-once src="{{asset('adminlte3/plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
<!-- Momemnt -->
<script data-navigate-once src="{{asset('adminlte3/plugins/moment/moment.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script data-navigate-once src="{{asset('adminlte3/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

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