<?php
//$html_data = "<tbody>";

$html_data .= "<form id=\"book-add\" action=\"/\" method=\"post\">";
$html_data .= "<input name=\"book_id\" type=\"text\" hidden=\"hidden\" hidden value=\"" . $data['book_data']['book_id'] . "\">";
$html_data .= "<input name=\"pic_id\" type=\"text\" hidden=\"hidden\" hidden value=\"" . $data['book_data']['pic_id'] . "\">";
$html_data .= "<select id=\"select-state\" name=\"author_ids[]\" multiple class=\"demo-default\" style=\"width:250px\" placeholder=\"Выбор...\">";
$html_data .= "<option value=\"\">Выбор...</option>";
foreach ($data['authors_list'] as $author) {
    $html_data .= "<option value='" . $author['author_id'] . "' ";
    if (in_array($author['author_id'], $data['$authors_selected_ids'])) {
        $html_data .= " selected ";
    }
    $html_data .= ">" . $author['family_name'] . "</option>";
}
$html_data .= "</select>";
$html_data .= "<label>";
$html_data .= "<input name=\"book_name\" class=\"form-control\" type=\"text\" value=\"" . $data['book_data']['title'] . "\"/>";
$html_data .= "</label>";
$html_data .= "<label>";
$html_data .= "<input name=\"book_public_date\" class=\"form-control\" type=\"number\" min=\"0\" max=\"2019\" step=\"1\" value=\"" . $data['book_data']['pub_date'] . "\" />";
$html_data .= "</label>";
$html_data .= "<div class=\"custom-file\">";
$html_data .= "<input type=\"file\" class=\"custom-file-input\" id=\"customFile\">";
$html_data .= "<label class=\"custom-file-label\" for=\"customFile\">Choose file</label>";
$html_data .= "</div>";
$html_data .= "</form>";