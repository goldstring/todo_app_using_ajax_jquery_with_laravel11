<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css"
        integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-dark">

    <div class="container">
        <div class="row justify-content-center align-items-center main-row">
            <div class="col-8 shadow-lg main-col bg-white">
                <div class="row bg-primary text-white">
                    <div class="col  p-2 text-center text-uppercase">
                        <h4>Todo App Using LAravel 11 (Yash Parab)</h4>
                        <p>Operation Features :- Ajax,Pagnation,Query Builder</p>
                    </div>
                </div>
                <div class="row justify-content-between text-white p-2">

                    <div class="form-group flex-fill mb-2">
                        <input id="todo-input" type="text" class="form-control" placeholder="Enter Your Todo..."
                            value="">
                    </div>
                    <button type="button" id="submit_todo" class="btn btn-primary mb-2 ml-2 text-uppercase">Add
                        todo</button>
                </div>
                <div class="row bg-light" id="todo-container">



                </div>
                <div class="row" id="pagination-container">

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
        integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/todo.js') }}"></script>


</body>

</html>
