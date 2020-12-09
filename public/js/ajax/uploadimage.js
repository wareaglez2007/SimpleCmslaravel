$(function () {
    var fileupload = $("#image");
    var filePath = $("#spnFilePath");
    var button = $("#btnFileUpload");
    button.on('click', function () {
        fileupload.on('click', function () { });

    });
    fileupload.on('change', function () {

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

                $.get('/admin/modules/media/mediaupload/lastupload', function (lastimage) {
                   // console.log(lastimage.id);
                    $('#noimageyet').text('');
                    //var ajaximage = "<div class='col-md-2' id='image" + lastimage.id + "'> <a href='#' class=''><img src='http://127.0.0.1:8000/" + lastimage.path_to + lastimage.image_name + "' class='img-thumbnail img-responsive' /></a></div>";
                    var ajaximage = "<div class='col-lg-3' id='image" + lastimage.id + "'><div class='card custom-card' ><a href='#' class=''><img src='http://127.0.0.1:8000/" + lastimage.path_to + lastimage.image_name + "' class='card-img-top' /></a><div class='card-body'><p class='text-muted'>" + lastimage.image_name + "</p><a href='javascript:void(0)' onclick='DeleteImage(" + lastimage.id + ")' id='delimage'>Delete</a></div></div></div>";
                    //images_row
                    $('#images_row').last().append(ajaximage);
                    var current = lastimage.id - 1;
                    $('#ajax_success'+current).attr('id','#ajax_success'+response.lastadded.id);




                });
                console.log(response.lastadded.id);
                // myForm.reset();

                $('#ajax_success'+response.lastadded.id).attr('class', 'alert alert-success').append(response.success);

                setTimeout(function () {

                    $('#ajax_success'+response.lastadded.id).fadeOut('fast');
                }, 2000);

            },
            error: function (data) {
                var image_error = data.responseJSON.errors.image[0];
                var error_message = data.responseJSON.message;

                setTimeout(function () {

                    $('#ajax_errors' + lastimage.id).fadeOut('fast');
                }, 2000);

                $('#ajax_errors' + lastimage.id).attr('class',
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
                    $('#image_info_capsul').attr('style', 'display:none');
                });

                setTimeout(function () {

                    $('#ajax_success' + todelete.id).fadeOut('fast');
                }, 2000);
                $('#ajax_success' + todelete.id).attr('class', 'alert alert-success').append(response.success);
            }

        });

    });//Closing of get

}

function ImageInfoForm(id) {
    const imageid = id;
    // console.log(id);
    $.get('/admin/modules/media/mediaupload/getinfobyid/' + id, function (toupdate) {

        $('#image_info_capsul').attr('style', 'display:visible');
        var image_name = toupdate.image_name;
        var image_alttext = toupdate.alttext;
        var image_caption = toupdate.caption;

        //console.log(toupdate);

        $('#imagename').val(image_name);
        $('#alttext').val(image_alttext);
        $('#imagecaption').val(image_caption);
        $('#imageinfoupdate').attr('onclick', 'UpdateImageInfo(' + id + ')');
        //DeleteImage({{ $image->id }})
        $('#delimage').attr('onclick', 'DeleteImage(' + id + ')');

    });



} //End of function

function UpdateImageInfo(id) {
    //update by ajax listener event

    console.log(id);
    $('#imageinfoupdate').attr('class', 'btn btn-danger');
    //here we call call AJAX to update a record
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //closing of ajaxSetup
    $.ajax({
        url: "/admin/modules/media/mediaupload/updateimageinfo",
        type: "post",
        cache: false,
        data: {
            id: id,
            alttext: $('#alttext').val(),
            caption: $('#imagecaption').val(),

        },
        success: function (response) {
            console.log(response);
            $('#ajax_update_success' + id).attr('class', 'alert alert-success').append(response.success);

            setTimeout(function () {

                $('#ajax_update_success' + id).fadeOut('fast');
            }, 2000);


        }

    });//closing of ajax


}
