function initBackup() {
    jQuery.ajax({
        type: "GET",
        url: "/library/api/v1/admin/backup.php",
    })
        .done(function () {
            alert("Вы успешно выполнили полный бэкап сайта");
        })
        .fail(function () {
        });
    return false;
}

function logout() {
    jQuery.ajax({
        type: "GET",
        url: "/library/api/v1/admin/showUserInfo.php",
        async: false,
        username: "logmeout",
        password: "123456",
        headers: {"WWW-Authenticate": "Basic Realm=\"Library\""},
    })
        .done(function () {
        })
        .fail(function () {
            alert("Вы успешно вышли с системы. Сейчас вы будете перенаправлены на главную страницу");
            window.location = '/library';
        });
    return false;
}

function checkInput() {
    if ($('#input').val() !== '')
        $('#submit').removeAttr('disabled');
    else
        $('#submit').attr('disabled', 'disable');
}

function checkFlag() {
    if ($('#defaultCheck1'))
        $('#button3').removeAttr('disabled');
    else
        $('#button3').attr('disabled', 'disable');
}

function page($page) {
    $.ajax({
        type: 'POST',
        url:'/library/api/v1/admin/getBookPage.php',
        dataType: "html",
        cache: false,
        data: {
            'page': $page
        },
    })
        .done(function () {
            location.reload();
        })
}


function confirmDelete($id) {
    $url = location.href.substring(0, location.href.lastIndexOf("/"));
    $.ajax({
        type: 'POST',
        url: '/library/api/v1/admin/deleteBook.php',
        dataType: "html",
        cache: false,
        data: {
            'id': $id
        },
    })
        .done(function () {
             location.reload();
        })
}


function addNewBook() {
    $bookName = $('#input').val().trim();
    if ($bookName === '') {
        alert("Название книги не заполнено!");
        return;
    }
    $url = location.href.substring(0, location.href.lastIndexOf("/"));
    $('#bookInfo').on('submit', function (e) {
        e.preventDefault();
        var $that = $(this),
            formData = new FormData($that.get(0));
        $.ajax({
            type: 'POST',
            url: '/library/api/v1/admin/addBook.php',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
        })
            .done(function () {
                location.reload();
            })
            .fail(function () {
                location.reload();
            });

    });
}

function handleFileSelect(evt) {
    var file = evt.target.files; // FileList object
    var f = file[0];
    // Only process image files.
    if (!f.type.match('image.*')) {
        alert("Image only please....");
        document.getElementById("file").value = "";
        return false;
    }

    var reader = new FileReader();
    // Closure to capture the file information.
    reader.onload = (function (theFile) {
        return function (e) {
            // Render thumbnail.
            var span = document.createElement('span');
            span.innerHTML = ['<img class="thumb" width= "200px", title="', escape(theFile.name), '" src="', e.target.result, '" />'].join('');
            document.getElementById('output').insertBefore(span, null);
        };
    })(f);
    // Read in the image file as a data URL.
    reader.readAsDataURL(f);
}

