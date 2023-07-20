// Xử lý sự kiện nút duyệt
$(".borrow-btn").click(function() {
    var id = $(this).data("id");
    $("#confirmationBorrowModal" + id).css("display", "block");
});


// Xử lý sự kiện nút xác nhận duyệt mượn sách
$(".confirm-borrow-btn").click(function() {
    var id = $(this).data("id");
});

//Xử lý sự kiện nút không mượn sách
$(".cancel-borrow-btn").click(function() {
    var id = $(this).data("id");
    $("#confirmationBorrowModal" + id).css("display", "none");
});

// Xử lý sự kiện nút xóa
$(".delete-btn").click(function() {
    var id = $(this).data("id");
    $("#confirmationDeleteModal" + id).css("display", "block");
});


// Xử lý sự kiện nút xác nhận xóa yêu cầu
$(".confirm-delete-btn").click(function() {
    var id = $(this).data("id");
    $("#confirmationDeleteModal" + id).css("display", "none");
});

//Xử lý sự kiện nút không xóa yêu cầu
$(".cancel-delete-btn").click(function() {
    var id = $(this).data("id");
    $("#confirmationDeleteModal" + id).css("display", "none");
});

function continueModal(bookId, name, code, bookname, route){
    $("#content").html("");

    var str =
        `<div class="modal fade" id="staticBackdrop` + bookId + `" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Borrow book</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cancel"></button>
                    </div>
                    <div class="modal-body">
                        <p><b>Name:</b> <span class="text-error-notify">` + name + `</span></p>
                        <p><b>Code:</b> <span class="text-error-notify">` + code + `</span></p>
                        <p><b>Book Name:  </b> <span class="text-error-notify">` + bookname + `</span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="` + route + `" method="GET">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="btn btn-primary" type="submit">Continue</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>`
    $("#modal").append(str);
    $("#staticBackdrop" + bookId).modal("show");
}

function giveModal(bookId, name, code, bookname, borrow_date, date, route){
    $("#content").html("");

    var str =
        `<div class="modal fade" id="staticBackdrop` + bookId + `" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Give book back</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cancel"></button>
                    </div>
                    <div class="modal-body">
                        <p><b>Name:</b> <span class="text-error-notify">` + name + `</span></p>
                        <p><b>Code:</b> <span class="text-error-notify">` + code + `</span></p>
                        <p><b>Book Name:  </b> <span class="text-error-notify">` + bookname + `</span></p>
                        <p><b>Borrow Date:</b> <span class="text-error-notify">` + borrow_date + `</span></p>
                        <p><b>Return Date:</b> <span class="text-error-notify">` + date + `</span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="` + route + `" method="GET">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="btn btn-primary" type="submit">Continue</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>`
    $("#modal").append(str);
    $("#staticBackdrop" + bookId).modal("show");
}

