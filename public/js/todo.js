function showToast(msgType, msg, icon) {
    $.toast({
        heading: msgType,
        text: msg,
        position: 'bottom-center',
        stack: false,
        icon: icon
    });
}
const perPage = 5;
function wrapTodoList(data, totalRecords, currentPage) {
    $("#todo-container").html('');

    if (data.length > 0) {
        data.forEach(element => {

            let $todoHtml = `<div data-id="${element.todo_id}" class="col col-12 p-2 todo-item">
                <div class="input-group">
                <input type="text" readonly class="form-control" 
                    value="${element.title}">
                <div class="input-group-append">
                    <button data-todo_id="${element.todo_id}" class="btn btn-outline-secondary bg-danger text-white deleteBtn" type="button" onclick="deleteTodo('${element.todo_id}',${currentPage});"
                    id="delete">X</button>
                </div>
                </div>
                </div>`;
            $("#todo-container").append($todoHtml);
        });
    }


    let totalPages = Math.ceil(totalRecords / perPage);

    // Ensure currentPage is within bounds
    currentPage = Math.max(1, Math.min(currentPage, totalPages));

    let paginationHtml = `<nav aria-label="Page navigation"><ul class="pagination justify-content-center">`;

    // Previous Button
    if (currentPage > 1) {
        paginationHtml += `<li class="page-item">
            <a class="page-link" href="#" onclick="fetchTodos(${currentPage - 1})">Previous</a>
        </li>`;
    }

    // Page Numbers
    for (let page = 1; page <= totalPages; page++) {

        if (currentPage > page) {
            paginationHtml += `<li class="page-item ${page === currentPage ? "active" : ""}">
            <a class="page-link" href="#" onclick="fetchTodos(${page})">${page}</a>
        </li>`;
        }
        else {
            paginationHtml += `<li class="page-item ${page === currentPage ? "active" : ""}">
            <a class="page-link" href="#" onclick="fetchTodos(${page})">${page}</a>
        </li>`;
        }


    }

    // Next Button
    if (currentPage < totalPages) {
        paginationHtml += `<li class="page-item">
            <a class="page-link" href="#" onclick="fetchTodos(${currentPage + 1})">Next</a>
        </li>`;
    }

    paginationHtml += `</ul></nav>`;
    $("#pagination-container").html(paginationHtml);
}


function getTodoList(pageNo) {
    $.ajax({
        type: "POST",
        url: "/todo-list",
        contentType: "application/json",
        data: JSON.stringify({ 'perPage': perPage, 'pageNo': pageNo, _token: $('meta[name="csrf-token"]').attr('content') }),

        success: function (response) {
            if (response.status == "success") {
                wrapTodoList(response.data, response.totalTodoRecords, pageNo);
            } else {
                showToast('Error', 'Something went wrong', 'error');
            }
        }
    });
}

function fetchTodos(page) {
    getTodoList(page);
}


function deleteTodo(todo, currentPage) {
    if (confirm('Are You Sure To Delete This Todo ?')) {
        $.ajax({
            type: "POST",
            url: "/delete-todo",
            data: {
                todo: todo,
                _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
            },
            success: function (response) {
                if (response.status == "success") {
                    showToast('Success', 'Todo Deleted Successfully', 'success');
                    getTodoList(currentPage);
                } else {
                    showToast('Error', 'Something went wrong', 'error');
                }
            }
        });

    }

}

getTodoList(1);


$("#submit_todo").click(function (e) {


    var todo = $("#todo-input").val();
    if (todo == "") {
        showToast('Error', 'Please Enter A Todo', 'error');
        return;
    }

    $.ajax({
        type: "POST",
        url: "/add-todo",
        data: {
            todo: todo,
            _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
        },
        success: function (response) {
            if (response.status == "success") {
                showToast('Success', 'Todo Added Successfully', 'success');
                $("#todo-input").val("");
                $("#todo-container").html(response.data);
                getTodoList(1);
            } else {
                showToast('Error', 'Something went wrong', 'error');
            }
        }
    });


});