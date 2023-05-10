<?php


class Pagination
{

    public int $count_pages = 1;
    public int $current_page = 1;
    public string $uri = '';
    public int $mid_size = 5;
    public int $all_pages = 10;

    public function __construct(
        public int $page = 1,
        public int $per_page = 1,
        public int $total = 1
    )
    {
        $this->count_pages = $this->get_count_pages();
        $this->current_page = $this->get_current_page();
        $this->uri = $this->get_params();
        $this->mid_size = $this->get_mid_size();
    }

    public function get_mid_size(): int
    {
        return $this->count_pages <= $this->all_pages ? $this->count_pages : $this->mid_size;
    }

    public function get_start(): int
    {
        return ($this->current_page - 1) * $this->per_page;
    }

    public function get_count_pages(): int
    {
        return ceil($this->total / $this->per_page) ?: 1;
    }

    public function get_current_page(): int
    {
        if ($this->page < 1) {
            $this->page = 1;
        }
        if ($this->page > $this->count_pages) {
            $this->page = $this->count_pages;
        }
        return $this->page;
    }

    public function get_params(): string
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $uri = $url[0];
        if (isset($url[1]) && $url[1] != '') {
            $uri .= '?';
            $params = explode('&', $url[1]);
            foreach ($params as $param) {
                if (!preg_match("#page=#", $param)) $uri .= "{$param}&";
            }
        }
        return $uri;
    }

    public function get_html(): string
    {
        $back = '';
        $forward = '';
        $start_page = '';
        $end_page = '';
        $pages_left = '';
        $pages_right = '';

        if ($this->current_page > 1) {
            $back = "<li class='page-item'><a class='page-link' data-page='" . $this->current_page - 1 . "' href='" . $this->get_link($this->current_page - 1) . "'>&lt;</a></li>";
        }

        if ($this->current_page < $this->count_pages) {
            $forward = "<li class='page-item'><a class='page-link' data-page='" . $this->current_page + 1 . "' href='" . $this->get_link($this->current_page + 1) . "'>&gt;</a></li>";
        }

        if ($this->current_page > $this->mid_size + 1) {
            $start_page = "<li class='page-item'><a class='page-link' data-page='1' href='" . $this->get_link(1) . "'>&laquo;</a></li>";
        }

        if ($this->current_page < ($this->count_pages - $this->mid_size)) {
            $end_page = "<li class='page-item'><a class='page-link' data-page='" . $this->count_pages . "' href='" . $this->get_link($this->count_pages) . "'>&raquo;</a></li>";
        }

        for ($i = $this->mid_size; $i > 0; $i--) {
            if ($this->current_page - $i > 0) {
                $pages_left .= "<li class='page-item'><a class='page-link' data-page='" . $this->current_page - $i . "' href='" . $this->get_link($this->current_page - $i) . "'>" . ($this->current_page - $i) . "</a></li>";
            }
        }

        for ($i = 1; $i <= $this->mid_size; $i++) {
            if ($this->current_page + $i <= $this->count_pages) {
                $pages_right .= "<li class='page-item'><a class='page-link' data-page='" . $this->current_page + $i . "' href='" . $this->get_link($this->current_page + $i) . "'>" . ($this->current_page + $i) . "</a></li>";
            }
        }

        return '<nav aria-label="Page navigation example"><ul class="pagination">' . $start_page . $back . $pages_left . '<li class="page-item active"><a class="page-link">' . $this->current_page . '</a></li>' . $pages_right . $forward . $end_page . '</ul></nav>';

    }

    public function get_link($page): string
    {
        if ($page == 1) {
            return rtrim($this->uri, '?&');
        }

        if (str_contains($this->uri, '&')) {
            return "{$this->uri}page={$page}";
        } else {
            if (str_contains($this->uri, '?')) {
                return "{$this->uri}page={$page}";
            } else {
                return "{$this->uri}?page={$page}";
            }
        }
    }

    public function __toString(): string
    {
        return $this->get_html();
    }

}