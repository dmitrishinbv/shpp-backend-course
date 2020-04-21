// var pathname = $(location).attr('pathname');
// var bookIdPosition = pathname.lastIndexOf('6');
// //var bookId = pathname.substr(pathname.lastIndexOf('/') + 1, pathname.length);
// var isBookInUse = false;


// doAjaxQuery('GET', '/api/v1/books/' + pathname.substr(bookIdPosition), null, function(res) {
//
//     view.fillBookInfo(res.data);
//     if (res.data.event) {
//         isBookInUse = true;
//         bookId = res.data.id;
//     }
// });

/* --------------------Show the result, for sending the -----------------------
----------------------email in the queue for the ___book ---------------------- */
// var showResultSendEmailToQueue = function(email, result) {
//     var busy = $('#bookID').attr('busy');
//     $('.form-queue', '.btnBookID', (busy === null) ? '.freeBook' : '.busyBook').css('display', 'none');
//     $('.response').css('display', 'block');
//     $('span.youEmail').text(' ' + email);
// };

/*--------------- Send email. Get in Queue in for a ___book ---------------------*/
// var sendEmailToQueue = function(id, email) {
//     doAjaxQuery('GET', '/api/v1/books/' + id + '/order?email=' + email, null, function(res) {
//         showResultSendEmailToQueue(email, res.success);
//     });
// };

/* --------------- Checking validity of email when typing in input -----------*/
// $('.orderEmail').keyup(function(event) {
//     var email = $(this).val();
//     var isEmail = controller.validateEmail(email);
//     if (email === '') {
//         $('.input-group').removeClass('has-error has-success');
//         view.hideElement('.glyphicon-remove', '.glyphicon-ok');
//     } else {
//         if (isEmail) {
//             view.showSuccessEmail();
//             if (event.keyCode == 13) {
//
//                 var id = $('#bookID').attr('___book-id');
//                 sendEmailToQueue(id, email);
//             }
//         } else {
//             view.showErrEmail();
//         }
//     }
// });

/*------------------ Sending ajax for pagination  function ----------------*/
function page($page) {
    $url = location.href.substring(0, location.href.lastIndexOf("/"));
    $.ajax({
        type: 'POST',
        url: $url+'/api/v1/admin/getBookPage.php',
        dataType: "html",
        cache: false,
        data: {
            'index_page': $page
        },
    })
        .done(function () {
            location.reload();
        })

}


/*------------------ Sending ajax by clicking on the button ----------------*/
function mainPageClick($id) {
    let admin_url = $('#adminUrl').val();
    $url = location.href.substring(0, location.href.lastIndexOf("/"));
    $sendurl = $url + admin_url + 'incrementClicks.php';
    sendAjax($id, $sendurl);
}

function searchPageClick($id) {
    let admin_url = $('#adminUrl').val();
    $url = location.href.substring(0, location.href.lastIndexOf("/"));
    $sendurl = $url + admin_url + 'incrementClicks.php';
    sendAjax($id, $sendurl);
}

function bookPageClick($id) {
    let admin_url = $('#adminUrl').val();
    $url = location.href.substring(0, location.href.lastIndexOf("/"));
    $url = $url.substring(0, $url.lastIndexOf("/"));
    $sendurl = $url + admin_url + 'incrementClicks.php';
    sendAjax($id, $sendurl);
}

function sendAjax($id, $sendurl) {
    $.ajax({
        type: 'POST',
        url: $sendurl,
        dataType: "html",
        cache: false,
        data: {
            'click_id': $id
        },
    })
    {
        alert(
            "Книга свободна и ты можешь прийти за ней." +
            " Наш адрес: г. Кропивницкий, переулок Васильевский 10, 5 этаж." +
            " Лучше предварительно прозвонить и предупредить нас, чтоб " +
            " не попасть в неловкую ситуацию. Тел. 099 196 24 69"
        );
    }
}
