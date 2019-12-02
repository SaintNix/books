<?php


class Controller_ajax
{
    function __construct()
    {
        $this->model = new Model_Ajax();
        $this->view = new View();
    }

    function book_create()
    {
        $post_data = $this->model->getPost();
        $file = $_FILES;

        try {
            $file_name = $this->model->file_upload($file);
            $rest = $this->model->add_book($post_data['book_name'], $post_data['author_ids'], $post_data['book_public_date'], $file_name);
        } catch (Exception $exception) {
            return "Error: " . $exception->getMessage();
        }
        $this->reload_book_table();
    }

    function book_delete()
    {
        $post_data = $this->model->getPost();
        $this->model->delete_book($post_data['book_id']);
        $this->reload_book_table();
    }

    function book_change_modal_view()
    {
        $authors_selected_ids = [];
        $post_data = $this->model->getPost();
        $data['authors_list'] = $this->model->getAllAuthors();
        $data['book_data'] = $this->model->get_one_book($post_data['book_id']);
        $data['authors_data'] = $this->model->get_books_authors($post_data['book_id']);
        foreach ($data['authors_data'] as $authors_datum) {
            $authors_selected_ids[] = $authors_datum['author_id'];
        }
        $data['$authors_selected_ids'] = $authors_selected_ids;
        $html_data = $this->view->generate('ajax_modal_add_change_view.php', 'ajax_template_view.php', $data);
        die(json_encode($html_data));
    }

    function author_change_modal_view()
    {
        $post_data = $this->model->getPost();
        $data = $this->model->getOneAuthorById($post_data['author_id']);
        $html_data = $this->view->generate('ajax_modal_author_change_view.php', 'ajax_template_view.php', $data);
        die(json_encode($html_data));
    }

    function reload_book_table()
    {
        $data['books_list'] = $this->model->getBooksList();
        $data['authors_list'] = $this->model->getAllAuthors();
        $html_data = $this->view->generate('ajax_books_list_view.php', 'ajax_template_view.php', $data);
        die(json_encode($html_data));
    }

    function book_modal_add_view()
    {
        $data['authors_list'] = $this->model->getAllAuthors();
        $html_data = $this->view->generate('ajax_book_modal_add_view.php', 'ajax_template_view.php', $data);
        die(json_encode($html_data));
    }

    function book_change_data()
    {
        $post_data = $this->model->getPost();
        $file = $_FILES;
        $file_name = $this->model->file_upload($file);
        $this->model->change_book_data($post_data['book_name'], $post_data['book_public_date'], $file_name, $post_data['book_id']);
        $this->model->change_book_authors($post_data['book_id'], $post_data['author_ids']);
        $this->reload_book_table();
    }

    function author_change_data()
    {
        $post_data = $this->model->getPost();
        $file = $_FILES;
        $file_name = $this->model->file_upload($file);
        $this->model->change_author_data($post_data['first_name'], $post_data['family_name'], $post_data['last_name'], $file_name, $post_data['author_id']);
        $this->reload_author_table();
    }

    function reload_author_table()
    {
        $data['authors_list'] = $this->model->getAllAuthorsOrderById();
        $html_data = $this->view->generate('ajax_authors_list_view.php', 'ajax_template_view.php', $data);
        die(json_encode($html_data));
    }

    function author_modal_add_view()
    {
        $html_data = $this->view->generate('ajax_author_modal_add_view.php', 'ajax_template_view.php', '');
        die(json_encode($html_data));
    }

    function author_create()
    {
        $post_data = $this->model->getPost();
        $file = $_FILES;

        try {
            $file_name = $this->model->file_upload($file);
            $this->model->add_author($post_data['first_name'], $post_data['last_name'], $post_data['family_name'], $file_name);
        } catch (Exception $exception) {
            return "Error: " . $exception->getMessage();
        }
        $this->reload_author_table();
    }

    function author_delete()
    {
        $post_data = $this->model->getPost();
        $this->model->delete_author($post_data['author_id']);
        $this->reload_author_table();
    }

    function author_filter()
    {
        $post_data = $this->model->getPost();
        $tests= !empty($post_data['authors_ids']) ? $post_data['authors_ids'] : null;
        $data_sort = !empty($post_data['data_sort']) ? $post_data['data_sort'] : 0;
        $data = $this->model->getFilteredFrontData($data_sort, $tests);
        $html_data = $this->view->generate('ajax_books_front_view.php', 'ajax_template_view.php', $data);
        die(json_encode($html_data));
    }
}