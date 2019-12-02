<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="home"></span>
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            <span data-feather="file"></span>
                            Главная
                        </a>
                    </li>
                </ul>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link active" href="/admin/books/">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-file-text">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            Книги
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/authors/">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-file-text">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            <span data-feather="file-text"></span>
                            Авторы
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <h2>Книги
            <!-- Кнопка модалки добавления -->
            <button type="button" class="btn btn-primary book-modal-add-button" data-toggle="modal" data-target="#exampleModalCenter">
                Добавить
            </button>
            </h2>
            <div class="table-responsive">

            </div>
        </main>
    </div>
</div>

<!-- Модалка добавления -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="add_book btn btn-primary">OK</button>
                <button type="button" class="modal_close btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script src="/bootstrap/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
<script src="/js/selectize.js"></script>
<link rel="stylesheet" href="/css/selectize.bootstrap3.css">
<script>
    (function ($) {
        var files;
        // заполняем переменную данными файлов, при изменении значения file поля
        $(document).on('change', '.custom-file-input', function () {
            files = this.files;
        });
        //Создаем новую книгу
        $(document).on('click', '.add_book', function (event) {

            event.stopPropagation(); // остановка всех текущих JS событий
            event.preventDefault();  // остановка дефолтного события для текущего элемента - клик для <a> тега

            var flag = true; //Проверка полей
            var flag2 = false; //Проверка полей
            var from_dat = $('#book-add').serializeArray();
            console.log(from_dat);
            $.each(from_dat, function (key, val) {
                if (!val['value']) {
                    flag = false;
                }
                if (val['name'] === 'author_ids[]') {
                    flag2 = true;
                }
            });
            if (!flag2) {
                flag = false;
            }
            if (!files) {
                flag = false;
            }
            if (flag) {
                // закрвыаем модалку
                $('.modal_close').click();
                // ничего не делаем если files пустой
                if (typeof files == 'undefined') return;

                // создадим данные файлов в подходящем для отправки формате
                var data = new FormData();
                $.each(files, function (key, value) {
                    data.append(key, value);
                });

                var is_action_change = from_dat[0]['value'];
                // добавим переменную идентификатор запроса
                data.append('ajax', 1);
                if (is_action_change !== '0') {
                    data.append('action', 'book_change_data');
                    data.append('book_id', is_action_change);
                } else {
                    data.append('action', 'book_create');
                }
                //Добавим данные формы
                $.each(from_dat, function (key, val) {
                    data.append(val['name'], val['value']);
                });
                ajax_to_dom(data, '.table-responsive');
            } else {
                alert('Не заполнены поля');
            }
        });
        //Получаем ивставляем вью в модалку изменений книги
        $(document).on('click', '.change_book_get_modal_view', function (event) {
            // создадим данные файлов в подходящем для отправки формате
            var data = new FormData();
            // добавим переменную идентификатор запроса
            data.append('ajax', 1);
            data.append('action', 'book_change_modal_view');
            data.append('book_id', $(this).attr('book_id'));
            // AJAX запрос
            ajax_to_dom(data, '.modal-body');
        });
        //Изменем данные в книге
        $(document).on('click', '.change_book_data', function (event) {

            event.stopPropagation(); // остановка всех текущих JS событий
            event.preventDefault();  // остановка дефолтного события для текущего элемента - клик для <a> тега

            var flag = true; //Проверка полей
            var flag2 = false; //Проверка полей
            var from_dat = $('#book-add').serializeArray();

            $.each(from_dat, function (key, val) {
                if (!val['value']) {
                    flag = false;
                }
                if (val['name'] === 'author_ids[]') {
                    flag2 = true;
                }
            });
            if (!flag2) {
                flag = false;
            }
            if (!files) {
                flag = false;
            }
            if (flag) {
                // закрвыаем модалку
                $('.modal_close').click();
                // ничего не делаем если files пустой
                if (typeof files == 'undefined') return;

                // создадим данные файлов в подходящем для отправки формате
                var data = new FormData();
                $.each(files, function (key, value) {
                    data.append(key, value);
                });

                // добавим переменную идентификатор запроса
                data.append('ajax', 1);
                data.append('action', 'change_book_data');
                //Добавим данные формы
                $.each(from_dat, function (key, val) {
                    data.append(val['name'], val['value']);
                });
                ajax_to_dom(data, '.table-responsive');
            } else {
                alert('Не заполнены обязательные поля');
            }
        });
        //Удаляем книгу
        $(document).on('click', '.delete_book', function (event) {
            // создадим данные файлов в подходящем для отправки формате
            var data = new FormData();
            // добавим переменную идентификатор запроса
            data.append('ajax', 1);
            data.append('action', 'book_delete');
            data.append('book_id', $(this).attr('book_id'));
            // AJAX запрос
            ajax_to_dom(data, '.table-responsive');
        });
        //Получаем и вставляем свежие данные в модалку создания книги
        $(document).on('click', '.book-modal-add-button', function (event) {
            // создадим данные файлов в подходящем для отправки формате
            var data = new FormData();
            // добавим переменную идентификатор запроса
            data.append('ajax', 1);
            data.append('action', 'book_modal_add_view');
            // AJAX запрос
            ajax_to_dom(data, '.modal-body');
        });

        function reload_book_table() {
            // создадим данные файлов в подходящем для отправки формате
            var data = new FormData();
            // добавим переменную идентификатор запроса
            data.append('ajax', 1);
            data.append('action', 'reload_book_table');
            // AJAX запрос
            ajax_to_dom(data, '.table-responsive');
        }

        function ajax_to_dom(data, location) {
            $(location).html('<div style="width: 100%;display: flex;justify-content: center"><img width="50%" src="/img/loading1.gif"/></div>');
            $.ajax({
                url: '/index.php',
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                // отключаем обработку передаваемых данных, пусть передаются как есть
                processData: false,
                // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
                contentType: false,
                // функция успешного ответа сервера
                success: function (respond, status, jqXHR) {
                    // ОК
                    if (typeof respond.error === 'undefined') {
                        // файлы загружены, делаем что-нибудь
                        // покажем пути к загруженным файлам в блок '.ajax-reply'
                        $(location).html(respond);
                        $('div.modal-body select').selectize({
                            maxItems: 3
                        });
                        bsCustomFileInput.init();
                        console.log(respond);
                    }
                    // error
                    else {
                        console.log('ОШИБКА: ' + respond.error);
                    }
                },
                // функция ошибки ответа сервера
                error: function (jqXHR, status, errorThrown) {
                    console.log('ОШИБКА AJAX запроса: ' + status, jqXHR);
                }
            });
        }

        reload_book_table();
    })(jQuery)
</script>
<script>
    $('#select-state').selectize({
        maxItems: 3
    });
</script>