// var sound = new Audio("http://localhost/too/deskbell.wav"); // buffers automatically when created
// var sound = new Audio("http://www.tooready.com/deskbell.wav"); // buffers automatically when created
//console.log(sound);
// toastr.options = {
//     "closeButton": true,
//     "debug": false,
//     "newestOnTop": false,
//     "progressBar": false,
//     "positionClass": "toast-bottom-left",
//     "preventDuplicates": false,
//     "onclick": null,
//     "showDuration": "300",
//     "hideDuration": "10000",
//     "timeOut": "5000",
//     "extendedTimeOut": "1000",
//     "showEasing": "swing",
//     "hideEasing": "linear",
//     "showMethod": "fadeIn",
//     "hideMethod": "fadeOut",
//     "rtl": true
// };

// // Enable pusher logging - don't include this in production
// Pusher.logToConsole = true;
//
// var pusher = new Pusher('d1ede80e4ffc8c93c90c', {
//     cluster: 'ap1',
//     encrypted: true
// });
//
// var channel = pusher.subscribe('dashboard_channel');
// channel.bind('new_order', function(data) {
//     console.log(data);
//     toastr.options.onclick = function() { window.location = data.url; };
//     if (window.can_see_order == true)
//     {
//         console.log("point 1");
//         console.log("point is_res"+ is_restaurant_admin);
//         if (window.is_restaurant_admin == true)
//         {
//             console.log("point 1.1");
//             if (window.restaurants_id.indexOf(String(data.res_id)) > -1)
//             {
//                 console.log("point 1.1.1");
//                 sound.play();
//                 toastr.success(data.msg);
//             }else{
//                 console.log("point 1.1.2");
//             }
//         }else{
//             console.log("point 1.2");
//             sound.play();
//             toastr.success(data.msg);
//         }
//     }
//
// });

$(document).on('click','.destroy',function(){

    var route   = $(this).data('route');
    var token   = $(this).data('token');
    $.confirm({
        icon                : 'glyphicon glyphicon-floppy-remove',
        animation           : 'rotateX',
        closeAnimation      : 'rotateXR',
        title               : 'تأكد عملية الحذف',
        autoClose           : 'cancel|6000',
        text             : 'هل أنت متأكد من الحذف ؟',
        confirmButtonClass  : 'btn-outline',
        cancelButtonClass   : 'btn-outline',
        confirmButton       : 'نعم',
        cancelButton        : 'لا',
        dialogClass			: "modal-danger modal-dialog",
        confirm: function () {
            $.ajax({
                url     : route,
                type    : 'post',
                data    : {_method: 'delete', _token :token},
                dataType:'json',
                success : function(data){
                    if(data.status === 0)
                    {
                        //toastr.error(data.msg)
                        Swal.fire("خطأ!", data.message, "error")
                    }else{
                        $("#removable"+data.id).remove();
                        Swal.fire("أحسنت!", data.message, "success")
                        //toastr.success(data.msg)
                    }
                }
            });
        }
    });
});


