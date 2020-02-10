$(document).ready(function() {

    //$('.tt').tooltip();
    
    pullData();

    function pullData() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                dataD = JSON.parse(this.responseText);
                console.log(dataD);
            };
        }
        xhttp.open("POST", "manage.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`request=select`);
    }

    $('#addInsect').click(function() {
        console.log('cccccccc')
        $('#addModal').modal();
    });

    $('.btn_edit').click(function() {
        console.log('fffff')
        $("#editModal").modal();

        var pid = $(this).attr('pid');
        var nameinsect = $(this).attr('name');
        var alias = $(this).attr('alias');
        var charstyle = $(this).attr('charstyle');
        var dangerInsect = $(this).attr('dangerstyle');
        var numPicChar = $(this).attr('numPicChar')
        var numPicDanger = $(this).attr('numPicDanger')
        var icon = $(this).attr('data-icon')
        var footer;

        console.log("icon = " + icon)

        $('#img-pic-logo-edit').attr('src', "../../icon/pest/" + pid + "/" + icon)
        footer = `<div class="img-reletive">

        <img width="100px" height="100px" src="https://ast.kaidee.com/blackpearl/v6.18.0/_next/static/images/gallery-filled-48x48-p30-6477f4477287e770745b82b7f1793745.svg" width="50px" height="50px" alt="">
        <input type="file" id="pic-style-char-edit" name="picstyle_insert-edit[]" accept=".jpg" multiple>
        </div>`
        $('#grid-pic-style-char-edit').html(setImgEdit(icon, pid, numPicChar, footer))


        footer = `<div class="img-reletive">
        <img width="100px" height="100px" src="https://ast.kaidee.com/blackpearl/v6.18.0/_next/static/images/gallery-filled-48x48-p30-6477f4477287e770745b82b7f1793745.svg" width="50px" height="50px" alt="">
        <input type="file" class="form-control" id="p_photo-edit" name="p_photo-edit[]" accept=".jpg,.png" multiple>
        </div>`
        $('#grid-p_photo-edit').html(setImgEdit(icon, pid, numPicDanger, footer))
        $('#e_name').val(alias);
        $('#e_alias').val(nameinsect);
        $('#e_charactor').text(charstyle);
        $('#e_danger').text(dangerInsect);
        //document.getElementById("e_charactor").value = charstyle;
        //document.getElementById("e_danger").value = dangerInsect;
        $('#e_pid').val(pid);

        $('#e_o_name').val(alias);
        $('#e_o_alias').val(nameinsect);
        $('#e_o_charcator').text(charstyle);
        $('#e_o_danger').text(dangerInsect);
        // document.getElementById("e_o_charactor").value = charstyle;
        //document.getElementById('e_o_alias').value = dangerInsect;
    });

    // Configure/customize these variables.
    var showChar = 100; // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more";
    var lesstext = "Show less";
    $('.more').each(function() {
        var content = $(this).html();
        if (content.length > showChar) {
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
            var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h +
                '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
            $(this).html(html);
        }

    });

    $(".morelink").click(function() {
        if ($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;

    });

});



$(document).on('click', '.delete', function() {
    delfunction($(this).attr('data-pid'), $(this).attr('data-alias'))
})

function delfunction(_sid, _alias) {
    // alert(_did);
    swal({
            title: "คุณต้องการลบ",
            text: `${_alias} หรือไม่ ?`,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            cancelButtonClass: "btn-secondary",
            confirmButtonText: "ยืนยัน",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false,
            closeOnCancel: function() {
                $('[data-toggle=tooltip]').tooltip({
                    boundary: 'window',
                    trigger: 'hover'
                });
                return true;
            }
        },
        function(isConfirm) {
            if (isConfirm) {
                console.log(1)
                swal({
                    title: "ลบข้อมูลสำเร็จ",
                    type: "success",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "ตกลง",
                    closeOnConfirm: false,

                }, function(isConfirm) {
                    if (isConfirm) {
                        delete_1(_sid)
                    }

                });
            } else {

            }
        });
}


