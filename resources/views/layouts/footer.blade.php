
<script src="{{asset('adminlte/plugins/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('adminlte/plugins/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('adminlte/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('adminlte/plugins/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('adminlte/js/demo.js')}}"></script>
<script src="{{asset('adminlte/plugins/jquery-confirm/jquery.confirm.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('js/ibnfarouk.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
    $(document).ready(function () {
        $('.sidebar-menu').tree()
    })
</script>
<style>
    .swal2-popup{
        font-size: 1.5rem !important;
    }
</style>

<script>
    @if (session()->has('flash_notification.message'))
    @if(session()->get('flash_notification.level') == "success")
    Swal.fire({
        title: "نجحت العملية!",
        text: "{!! session('flash_notification.message') !!}",
        type: "success",
        confirmButtonText: "حسناً"
    });
    @else
    Swal.fire({
        title: "فشلت العملية!",
        text: "{!! session('flash_notification.message') !!}",
        type: "error",
        confirmButtonText: "حسناً"
    });
    @endif
    @endif
</script>

</body>
</html>
