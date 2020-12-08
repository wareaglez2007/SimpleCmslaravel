$(function () {
    var fileupload = $("#image");
    var filePath = $("#spnFilePath");
    var button = $("#btnFileUpload");
    button.click(function () {
        fileupload.click();

    });
    fileupload.change(function () {

        //here we need to call the ajax.

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $(
                    'meta[name="csrf-token"]')
                    .attr(
                        'content')
            }
        }); //closing of ajax setup
        let myForm = document.getElementById('myForm');
        let formData = new FormData(myForm);
        $.ajax({

            url: "/admin/modules/media/mediaupload/imageupload",
            type: "post",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function (response) {
                //After success get the image information and show it in the page
                //Call another ajax??
                $('#ajax_success').text('');
                $.get('/admin/modules/media/mediaupload/lastupload', function (lastimage) {
                    console.log(lastimage.id);
                    $('#noimageyet').text('');
                    //var ajaximage = "<div class='col-md-2' id='image" + lastimage.id + "'> <a href='#' class=''><img src='http://127.0.0.1:8000/" + lastimage.path_to + lastimage.image_name + "' class='img-thumbnail img-responsive' /></a></div>";
                   var ajaximage ="<div class='col-lg-3' id='image"+lastimage.id+"'><div class='card custom-card' ><a href='#' class=''><img src='http://127.0.0.1:8000/" + lastimage.path_to + lastimage.image_name + "' class='card-img-top' /></a><div class='card-body'><p class='text-muted'>" + lastimage.image_name + "</p><a href='javascript:void(0)' onclick='DeleteImage("+lastimage.id+")' id='delimage'>Delete</a></div></div></div>";
                    //images_row
                    $('#images_row').last().append(ajaximage);

                });



                console.log(response.message);
                myForm.reset();

                $('#ajax_success').attr('class','alert alert-success').append(response.success);
            },
            error: function (data) {
                var image_error = data.responseJSON.errors.image[0];
                var error_message = data.responseJSON.message;
                $('#ajax_errors').attr('class',
                    'alert alert-danger').append('<p>' +
                        image_error + "<br>" + error_message);

            }
        });


    });
});

function DeleteImage(id) {
    $.get('/admin/modules/media/mediaupload/getinfobyid/' + id, function (todelete) {
        console.log(todelete.image_hash)
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $(
                    'meta[name="csrf-token"]')
                    .attr(
                        'content')
            }

        }); //closing of ajaxSetup
        $.ajax({
            url: "/admin/modules/media/mediaupload/destroy",
            type: "post",
            data: {
                id: todelete.id,
                image_hash: todelete.image_hash,
                path_to: todelete.path_to,
                image_name: todelete.image_name
            },
            success: function (response) {
                $('#image' + todelete.id).fadeOut(700, function () {
                    $('#image' + todelete.id).fadeIn().delay(2000);
                    $('#image' + todelete.id).remove();
                });

            }

        });

    });//Closing of get
}
