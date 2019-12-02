<style>
    .book_item {
        vertical-align: bottom;
        /* height: 267px; */
        /* width: 180px; */
        border-radius: 5px;
        margin: 10px;
        box-shadow: 0 3px 10px -2px rgba(0, 0, 0, .1);
        border: 1px solid rgba(0, 0, 0, .1);
        background-color: #fff;
        display: flex;
        justify-content: center;
        flex-direction: column;
        padding: 10px;
    }

    .book_container {
        overflow: hidden;
        width: 100%;
        position: relative;
        display: flex;
        flex-wrap: wrap;
        /* justify-content: center; */
        padding-top: 55px;
    }

    .book_image {
        height: 195px;
        max-width: 210px;
    }

    .filter_div {
        padding-top: 65px;
        min-width: 200px;
        background-color: #f8f9fa !important;
        box-shadow: inset 1px 0 0px 0px rgba(0, 0, 0, .1);
        padding-left: 23px;
        position: fixed;
        right: 0px;
        height: 100vh;
    }

    .fake_filter_div {
        padding-top: 65px;
        min-width: 200px;
        padding-left: 23px;
    }

    .main-view {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
</style>
<div class="main-view">
    <div class="book_container">

    </div>
    <div class="fake_filter_div">
    </div>
    <div class="filter_div">
        <div class="filter_container" style="display: flex;flex-direction: column;justify-content: center">
            <h4>Фильтр</h4>
            <h6>Авторы</h6>
            <fieldset id="filter_fildset">
                <form id="author_filter" action="\" method="POST">
                    <?
                    foreach ($data['author_list'] as $author) {
                        ?>
                        <div>
                            <input type="checkbox" id="author_<?= $author['author_id'] ?>" name="authors_ids[]"
                                   value="<?= $author['author_id'] ?>"/>
                            <label for="author_<?= $author['author_id'] ?>"><?= $author['family_name'] ?></label>
                        </div>
                        <?
                    }
                    ?>
                    <h6>Сортировка</h6>
                    <input type="checkbox" id="data_sort" name="data_sort" value="1"/>
                    <label for="data_sort">По дате добавления</label>
                </form>
            </fieldset>
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
<script>
    $(document).ready(function () {
        //Загрузка списка книг с фильтром и сортировкой
        //Загрузка самого фильтра по авторам
        $(document).on('change', 'input', function () {
            var from_dat = $('#author_filter').serializeArray();
            // создадим данные файлов в подходящем для отправки формате
            var data = new FormData();
            console.log(from_dat);
            data.append('ajax', 1);
            data.append('sort', 1);
            data.append('action', 'author_filter');
            //Добавим данные формы
            $.each(from_dat, function (key, val) {
                data.append(val['name'], val['value']);
            });
            $("#filter_fildset").attr('disabled', 'disabled');
            ajax_to_dom(data, '.book_container');
        });

        function reload_main_view() {
            // создадим данные файлов в подходящем для отправки формате
            var data = new FormData();
            // добавим переменную идентификатор запроса
            data.append('ajax', 1);
            data.append('action', 'author_filter');
            // AJAX запрос
            ajax_to_dom(data, '.book_container');
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
                        $('#filter_fildset').prop("disabled", false);
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

        reload_main_view();
    });
</script>
