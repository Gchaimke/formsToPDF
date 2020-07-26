var count = 0;
function showLog(log_data, serial) {
    if (log_data != '') {
        log_arr = log_data.split(';')
        $("#show-log").show();
        $("#show-log .list-group").empty();
        $("#serial-header").text(serial);
        log_arr.forEach(element => {
            if (element != '') {
                if (~element.indexOf("QC")) {
                    $("#show-log .list-group").append("<li class='list-group-item list-group-item-warning'>" + element + "</li>");
                } else {
                    $("#show-log .list-group").append("<li class='list-group-item list-group-item-info'>" + element + "</li>");
                }
            }
        });
    }
}

$(".close").click(function () {
    $("#show-log").hide();
});

dragElement(document.getElementById("show-log"));

function dragElement(elmnt) {
    if (elmnt != null) {
        var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
        if (document.getElementById("show-log-header")) {
            // if present, the header is where you move the DIV from:
            document.getElementById("show-log-header").onmousedown = dragMouseDown;
        } else {
            // otherwise, move the DIV from anywhere inside the DIV:
            elmnt.onmousedown = dragMouseDown;
        }

        function dragMouseDown(e) {
            e = e || window.event;
            e.preventDefault();
            // get the mouse cursor position at startup:
            pos3 = e.companyX;
            pos4 = e.companyY;
            document.onmouseup = closeDragElement;
            // call a function whenever the cursor moves:
            document.onmousemove = elementDrag;
        }

        function elementDrag(e) {
            e = e || window.event;
            e.preventDefault();
            // calculate the new cursor position:
            pos1 = pos3 - e.companyX;
            pos2 = pos4 - e.companyY;
            pos3 = e.companyX;
            pos4 = e.companyY;
            // set the element's new position:
            elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
            elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
        }

        function closeDragElement() {
            // stop moving when mouse button is released:
            document.onmouseup = null;
            document.onmousemove = null;
        }
    }
}

$('.select').click(function () {
    var id = $(this).attr('id');
    var link = document.getElementById('batchLink');
    if ($(event.target).is(":checked")) {
        $('#batchLink').attr('href', link.pathname + id + ':');
        count += 1;
    } else {
        $('#batchLink').attr('href', link.pathname.replace(id + ':', ''));
        count -= 1;
    }

    if (count > 0) {
        $('#batchLink').removeClass('disabled');
    } else {
        $('#batchLink').addClass('disabled');
    }
});

function cleanUrl() {
    var link = document.getElementById('batchLink');
    $('#batchLink').attr('href', link.pathname.replace(/:\s*$/, ""));
}

$('input[type="files"]').change(function (e) {
    var fileName = e.target.files[0].name;
    alert('The file "' + fileName + '" has been selected.');
});

function snapLogo() {
    var logo_path = document.getElementById('logo_path');
    var logo_img = document.getElementById('logo_img');
    var files = document.querySelector('input[type=file]').files;

    function readAndPreview(file) {
        // Make sure `file.name` matches our extensions criteria
        ext = file.name.substr((file.name.lastIndexOf('.') + 1));
        if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
            var reader = new FileReader();
            reader.addEventListener("load", function () {
                saveLogoToServer(this.result);
                sleep(2000);
                var image = new Image();
                image.title = file.name;
                image.src = this.result;
                logo_path.value = "/Uploads/Companies/" + company + "_logo." + ext;
                logo_img.src = logo_path.value;
            }, false);
            reader.readAsDataURL(file);
        }
    }
    if (files) {
        [].forEach.call(files, readAndPreview);
    }
}

function saveLogoToServer(file) {
    $.post("/companies/logo_upload", {
        data: file,
        company: company,
        ext: ext
    }).done(function (o) {
        console.log('photo saved to server.');
        console.log(o);
    });
}

function snapPhoto() {
    //var preview = document.querySelector('#preview');
    var files = document.querySelector('input[type=file]').files;
    function readAndPreview(file) {
        // Make sure `file.name` matches our extensions criteria
        if (/\.(jpe?g|jpeg|gif)$/i.test(file.name)) {
            var reader = new FileReader();
            reader.addEventListener("load", function () {
                savePhotoToServer(this.result);
                //sleep(2000);
                var image = new Image();
                image.title = file.name;
                image.src = this.result;
                //preview.appendChild(image);
            }, false);
            reader.readAsDataURL(file);
        }
    }

    if (files) {
        [].forEach.call(files, readAndPreview);
    }
}

function delFile(file) {
    var r = confirm("Delete File " + file + "?");
    if (r == true) {
        $.post("/production/delete_photo", {
            photo: file
        }).done(function (o) {
            console.log('File deleted from the server.');
            sleep(1000)
            location.reload();
        });
    }
}

$('#ajax-form').submit(function (event) {
    // Stop the browser from submitting the form.
    event.preventDefault();
    var formData = $('#ajax-form').serialize();
    $.ajax({
        type: 'POST',
        url: $('#ajax-form').attr('action'),
        data: formData
    }).done(function (response) {
        // Make sure that the formMessages div has the 'success' class.
        $('#form-messages').addClass('alert-success');
        // Set the message text.
        $('#form-messages').text(response).fadeIn(1000).delay(3000).fadeOut(1000); //show message
    }).fail(function () {
        // Make sure that the formMessages div has the 'error' class.
        $('#form-messages').addClass('alert-danger');
        // Set the message text.
        $('#form-messages').text('Oops! An error occured and your message could not be sent.').fadeIn(1000).delay(3000).fadeOut(1000);
    });

});

function sleep(milliseconds) {
    const date = Date.now();
    let currentDate = null;
    do {
        currentDate = Date.now();
    } while (currentDate - date < milliseconds);
}

function centerLoginBox() {
    var ua = navigator.userAgent.toLowerCase();
    var isAndroid = ua.indexOf("android") > -1; // Detect Android devices
    if (isAndroid) {
        //window.orientation is different for iOS and Android
        if (window.orientation == 0 || window.orientation == 180) { //Landscape Mode
            $('#loginbox').css('margin-top', '20%');
        }
        else if (window.orientation == 90 || window.orientation == -90) { //Portrait Mode
            $('#loginbox').css('margin-top', '40%');
        }
    }
    else {
        if (window.orientation == 90 || window.orientation == -90) { //Landscape Mode
            $('#loginbox').css('margin-top', '20%');
        }
        else if (window.orientation == 0 || window.orientation == 180) { //Portrait Mode
            $('#loginbox').css('margin-top', '40%');
        }
    }
}