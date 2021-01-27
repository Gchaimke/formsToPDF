var count = 0;
var form_id = '';
var autosave = false;
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

$('#form-messages').click(function () {
    $('#form-messages').fadeOut(1000);
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
        if (/\.(jpe?g|png)$/i.test(file.name)) {
            var reader = new FileReader();
            reader.addEventListener("load", function () {
                saveLogoToServer(this.result, company);
                sleep(2000);
                var image = new Image();
                image.title = file.name;
                image.src = this.result;
                if (ext == 'jpg') {
                    ext = 'jpeg';
                }
                logo_path.value = "/Uploads/Companies/" + company + "_logo." + ext;
                logo_img.src = logo_path.value;
            }, false);
            reader.readAsDataURL(file);
        } else {
            alert('JPEG, JPG only!')
        }
    }
    if (files) {
        [].forEach.call(files, readAndPreview);
    }
}

function saveLogoToServer(file, company) {
    $.post("/companies/logo_upload", {
        data: file,
        company: company
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
        if (/\.(jpe?g|jpeg|gif|png)$/i.test(file.name)) {
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


function saveSign() {
    $("#sign-canvas").data("jqScribble").save(function (imageData) {
        $("#client_sign").val(imageData.replace(/^data:image\/(png|jpg);base64,/, ""));
    });
}

$('#ajax-form').submit(function (event) {
    //Check if sign canvas exists on page
    var reload = false;
    if ($("#sign-canvas").length && $("#client_sign").length) {
        saveSign();
    }
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
        setTimeout(function () {
            if (reload) {
                location.reload();
            }
        }, 3000); //will call the function after 2 secs.
    }).fail(function () {
        // Make sure that the formMessages div has the 'error' class.
        $('#form-messages').addClass('alert-danger');
        // Set the message text.
        $('#form-messages').text('אין אפשרות לשמור שינוים' + response).fadeIn(1000).delay(3000).fadeOut(5000);
    });

});

function getfolder_name_date() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    return dd + '_' + mm + '_' + yyyy;
}


if ($("#fileupload").length) {
    var upload_folder = 'Uploads/forms_attachments/';
    var new_file = '';
    $("#fileupload").fileupload({
        autoUpload: true,
        add: function (e, data) {
            new_file = upload_folder + form_id + '/' + data.files[0].name
            data.submit();
        },
        progress: function (e, data) {
            //var progress = parseInt((data.loaded / data.total) * 100, 10);
            //data.context.css("background-position-x", 100 - progress + "%");
            $("#upload_spinner").css("display", "inherit");
        },
        done: function (e, data) {
            new_file = upload_folder + form_id + '/' + data.result;
            if (data.result.includes("error")) {
                if (data.result.includes("larger")) {
                    alert("אין אפשרות להעלות קובץ גדול מ-2מגה!");
                } else if (data.result.includes("filetype")) {
                    alert("אין אפשרות להעלות קובץ מסוג הזה!");
                } else {
                    alert(data.result.replace(/<\/?[^>]+(>|$)/g, ""));
                }
                data.context.addClass("error");
            } else {
                setTimeout(function () {
                    data.context = $('<p class="file ltr">').append($('<a target="blank" href="/' + new_file + '">').text(new_file)).appendTo('#files');
                    data.context.addClass("done").append('<a data-file="' + new_file + '" href="#files" class="delete_attachment" onclick="delete_attachment(this)">X</a>');
                    $("#upload_spinner").css("display", "none");
                }, 2000);
                if ($('#attachments').val() == '') {
                    $('#attachments').val(new_file);
                } else {
                    $('#attachments').val($('#attachments').val() + "," + new_file);

                }
            }
            $('#save_btn').click();
        }

    });
}

//Uploader for scripts and tickets
if ($("#upload").length) {
    $("#upload").fileupload({
        autoUpload: true,
        add: function (e, data) {
            data.submit();
        },
        progress: function () {
            $("#upload_spinner").css("display", "inherit");
        },
        done: function (e, data) {
            if (data.result.includes("error")) {
                if (data.result.includes("larger")) {
                    alert("אין אפשרות להעלות קובץ גדול מ-2מגה!");
                } else if (data.result.includes("filetype")) {
                    alert("אין אפשרות להעלות קובץ מסוג הזה!");
                } else {
                    alert(data.result.replace(/<\/?[^>]+(>|$)/g, ""));
                }
                data.context.addClass("error");
            } else {
                location.reload();
            }
            $('#save_btn').click();
        }
    });
}

if ($(".view_name").length) {
    $("tr.data-row").each(function (indexInArray, valueOfElement) {
        var view_name = $(this).find(".view_name");
        var mobile_data = $(this).find(".mobile-data");
        var new_span = $("<span class='mobile-view'></span>");
        mobile_data.each(function () {
            if ($(this).text() != "") {
                var p = $("<p></p>").text($(this).text());
                new_span.append(p);
            }
        });
        console.log(new_span)
        view_name.append(new_span);
    });
}

function delete_attachment(attachment) {
    var data_file = $(attachment).attr('data-file');
    var r = confirm("Delete File " + data_file + "?");
    if (r == true) {
        $.post("/production/delete_attachment", {
            attachment: data_file
        }).done(function (o) {
            $(attachment).parent().hide();
            $('#attachments').val($('#attachments').val().replace(data_file, ""));
            if ($('#attachments').val().startsWith(',')) {
                $('#attachments').val($('#attachments').val().substring(1, $('#attachments').val().length))
            }
            console.log(o);
            $('#save_btn').click();
        });
    }

}

function sleep(milliseconds) {
    const date = Date.now();
    let currentDate = null;
    do {
        currentDate = Date.now();
    } while (currentDate - date < milliseconds);
}

function set_years() {
    let yearDropdown = document.getElementById('yaer-dropdown');
    if (yearDropdown !== null) {
        let currentYear = new Date().getFullYear();
        let earliestYear = 2020;
        while (currentYear >= earliestYear) {
            let dateOption = document.createElement('option');
            dateOption.text = currentYear;
            dateOption.value = currentYear;
            yearDropdown.add(dateOption);
            currentYear -= 1;
        }
    }
}

function set_month() {
    let monthDropdown = document.getElementById('month-dropdown');
    if (monthDropdown !== null) {
        let i = 1;
        while (i <= 12) {
            let dateOption = document.createElement('option');
            dateOption.text = i;
            dateOption.value = i;
            monthDropdown.add(dateOption);
            i++;
        }
    }
}

function delFile(file) {
    var r = confirm("Delete File " + file + "?");
    if (r == true) {
        $.post("/admin/delete_file", {
            file: file
        }).done(function (o) {
            console.log('File deleted from the server.');
            sleep(1000)
            location.reload();
        });
    }
}

$('#show_csv').click(function () {
    $('#csv_month').toggle();
});