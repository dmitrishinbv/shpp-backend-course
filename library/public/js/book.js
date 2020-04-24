/*------------------ Sending ajax for pagination  function ----------------*/
function indexpage($page) {
    $.ajax({
        type: 'POST',
        url: '/library/api/v1/admin/getBookPage.php',
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
    sendAjax($id, '/library/api/v1/admin/incrementClicks.php');
}

function searchPageClick($id) {
    sendAjax($id, '/library/api/v1/admin/incrementClicks.php');
}

function bookPageClick($id) {
    sendAjax($id, '/library/api/v1/admin/incrementClicks.php');
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
