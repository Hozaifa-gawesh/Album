// Remove empty inputs name
$('#searchForm').submit(function () {
    $(this)
        .find('input[name], select[name]')
        .filter(function () {
            return !this.value;
        }).prop('name', '');
});

// Append Spinner When Form Submit
$(document).on('submit', 'form', function () {
    $(this).find('#submit').attr('disabled', true).append('<i class="fa fa-spinner fa-spin spinnerBTN"></i>');
    $(this).find('#submit').parent().find('a').hide();
});


// Delete And Move Album
$(document).on('click', '.btn-question', function () {
    let Self = $(this);
    let dataId = Self.data('id');

    Swal.fire({
        title: 'Do you want?',
        text: "Do you want delete all the pictures in the album?",
        icon: 'question',
        showCloseButton: true,
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonColor: '#3085d6',
        denyButtonColor: '#17a2b8',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        denyButtonText: 'No, move the pictures',
    }).then((res) => {
        if (res.isConfirmed) {
            deleteItem(Self);

        } else if (res.isDenied) {
            AlbumSelect(dataId);
        }
    })
});

// Delete Item
$(document).on('click', '.btn-delete', function () {
    let Self = $(this);

    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this!",
        icon: 'warning',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteItem(Self);
        }
    })
});

$('.preview_images').magnificPopup({
    delegate: 'a',
    type: 'image',
    gallery: {enabled: true}
});


// Album Modal Select
function AlbumSelect(albumId)
{
    let body = $('body');
    const ImgLOADING = $('.loading_request')
    let albumSelectRoute = $('#AlbumSelect').val();

    $.ajax({
        url: albumSelectRoute,
        type: 'post',
        dataType: 'json',
        beforeSend: function () {
            ImgLOADING.show();
        },
        data: {'album': albumId, '_token': $('meta[name="_token"]').attr('content')},
        success: function (res) {
            if(res.status == true){
                ImgLOADING.hide();
                body.append(res.data);
                $('#albumModal').modal('show');
            }
        }
    });
}


// Delete Item
function deleteItem(element) {
    let body = $('body');
    const ImgLOADING = $('.loading_request');
    let Item = $('#ItemDelete');
    let ItemDeleteRoute = Item.val();
    let ItemName = Item.data('name');

    $.ajax({
        url: ItemDeleteRoute,
        type: 'post',
        dataType: 'json',
        beforeSend: function () {
            ImgLOADING.show();
        },
        data: {'item': element.data('id'), 'item_name': ItemName, '_token': $('meta[name="_token"]').attr('content')},
        success: function (res) {
            if(res.status == true){
                ImgLOADING.hide();
                element.parents('tr').fadeOut(1000);
                Swal.fire(
                    'Deleted!',
                    res.message,
                    'success'
                )
            }
        },
        error: function (reject) {
            ImgLOADING.hide();
            if (reject.status === 422) {
                var response = JSON.parse(reject.responseText);
                var errorString = '<ul style="font-size: 14px;list-style: none">';
                $.each(response.errors, function (key, value) {
                    errorString += '<li>' + value + '</li>';
                });
                errorString += '</ul>';
                Swal.fire({
                    icon: 'error',
                    title: 'Something went wrong',
                    html: errorString,
                })
            }
        }
    });
}
