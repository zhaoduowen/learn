<?php

class Core_Lib_Page {

    public $first_row;
    public $list_rows;
    public $plus;
    protected $total_pages;
    protected $total_rows;
    protected $now_page;
    protected $method = 'defalut';
    protected $parameter = '';
    protected $page_name;
    protected $ajax_func_name;
    protected $url;
    


    public function __construct($data = array()) {
        $this->total_rows = $data['total_rows'];
        $this->parameter = !empty($data['parameter']) ? $data['parameter'] : '';
        $this->list_rows = !empty($data['list_rows']) && $data['list_rows'] <= 100 ? $data['list_rows'] : 10;
        $this->total_pages = ceil($this->total_rows / $this->list_rows);
        $this->page_name = !empty($data['page_name']) ? $data['page_name'] : 'p';
        $this->ajax_func_name = !empty($data['ajax_func_name']) ? $data['ajax_func_name'] : '';
        $this->method = !empty($data['method']) ? $data['method'] : '';
        $this->plus = !empty($data['plus']) ? $data['plus'] : 3;

        /* 当前页面 */
        if (!empty($data['now_page'])) {
            $this->now_page = intval($data['now_page']);
        } else {
            $this->now_page = !empty($_REQUEST[$this->page_name]) ? intval($_REQUEST[$this->page_name]) : 1;
        }
        $this->now_page = $this->now_page <= 0 ? 1 : $this->now_page;

        if (!empty($this->total_pages) && $this->now_page > $this->total_pages) {
            $this->now_page = $this->total_pages;
        }
        $this->first_row = $this->list_rows * ($this->now_page - 1);
    }

    protected function _get_link($page, $text) {
        switch ($this->method) {
            case 'ajax':
                $parameter = '';
                if ($this->parameter) {
                    $parameter = ',' . $this->parameter;
                }
                return '<a onclick="' . $this->ajax_func_name . '(\'' . $page . '\'' . $parameter . ')" href="javascript:void(0)">' . $text . '</a>' . "\n";
                break;
            case 'html':
               //$url = str_replace('?', $page, $this->parameter);
                $url = preg_replace('#\?#', $page, $this->parameter,1);
                $class = "btn ";
                if($text== '下一页'){
                    $class .= 'next';
                    $text = '<span></span>';
                }elseif($text == '上一页'){
                    $class .= 'prev';
                     $text = '<span></span>';
                }
                return '<a class="'.$class.'" href="' . $url . '">' . $text . '</a>' . "\n";
                break;
            case 'htmlnew':
               //$url = str_replace('?', $page, $this->parameter);
                $url = preg_replace('#\?#', $page, $this->parameter,1);
                $class = "btn ";
                if($text== '下一页'){
                    $class .= 'next';
                    $text = '下一页';
                }elseif($text == '上一页'){
                    $class .= 'prev';
                     $text = '上一页';
                }
                return '<li><a href="' . $url . '">' . $text . '</a></li>' . "\n";
                break;

            case 'kv': {
                /* 增加by tongkun ，处理 参数为key&value形式的连接*/
                $url = preg_replace('#pg=\d*#', 'pg='.$page, $this->parameter, 1);
                $class = "btn ";
                if($text== '下一页'){
                    $class .= 'next';
                    $text = '下一页';
                }elseif($text == '上一页'){
                    $class .= 'prev';
                     $text = '上一页';
                }
                return '<li><a href="' . $url . '">' . $text . '</a></li>' . "\n";
                break;
            }
            case 'php':
               $url = preg_replace('#@page@#', $page, $this->parameter,1);
                $class = "btn ";
                if($text== '下一页'){
                    $class .= 'next';
                    $text = '<span></span>';
                }elseif($text == '上一页'){
                    $class .= 'prev';
                     $text = '<span></span>';
                }
                return '<a class="'.$class.'" href="' . $url . '">' . $text . '</a>' . "\n";
                break;
            default:
                return '<a href="' . $this->_get_url($page) . '">' . $text . '</a>' . "\n";
                break;
        }
    }

    protected function _set_url() {
        $url = $_SERVER['REQUEST_URI'] . (strpos($_SERVER['REQUEST_URI'], '?') ? '' : "?") . $this->parameter;
        $parse = parse_url($url);
        if (isset($parse['query'])) {
            parse_str($parse['query'], $params);
            unset($params[$this->page_name]);
            $url = $parse['path'] . '?' . http_build_query($params);
        }
        if (!empty($params)) {
            $url .= '&';
        }
        $this->url = $url;
    }

    protected function _get_url($page) {
        if ($this->url === NULL) {
            $this->_set_url();
        }
        //	$lable = strpos('&', $this->url) === FALSE ? '' : '&';
        return $this->url . $this->page_name . '=' . $page;
    }

    public function first_page($name = '第一页') {
        if ($this->now_page > 5) {
            return $this->_get_link('1', $name);
        }
        return '';
    }

    public function last_page($name = '最后一页') {
        if ($this->now_page < $this->total_pages - 5) {
            return $this->_get_link($this->total_pages, $name);
        }
        return '';
    }

    public function up_page($name = '上一页') {
        if ($this->now_page != 1) {
            return $this->_get_link($this->now_page - 1, $name);
        }
        return '';
    }

    public function down_page($name = '下一页') {
        if ($this->now_page < $this->total_pages) {
            return $this->_get_link($this->now_page + 1, $name);
        }
        return '';
    }

    public function show($param = 1,$jump=false) {
        if ($this->total_rows < 1) {
            return '';
        }
        $className = 'show_' . $param;
        $classNames = get_class_methods($this);

        if (in_array($className, $classNames)) {
            return $this->$className($jump);
        }
        return '';
    }

    public function show_1($jump) {
        $plus = $this->plus;
        if ($plus + $this->now_page > $this->total_pages) {
            $begin = $this->total_pages - $plus * 2;
        } else {
            $begin = $this->now_page - $plus;
        }

        $begin = ($begin >= 1) ? $begin : 1;
        $return = '';
        //first_page
        $first_page = $this->first_page('首页');
        if ($first_page) {
            $return .=  $first_page;
        }
        //up_page
        $up_page = $this->up_page('上一页');
        if ($up_page) {
            $return .=  $up_page;
        }
        for ($i = $begin; $i <= $begin + $plus * 2; $i++) {
            if ($i > $this->total_pages) {
                break;
            }
            if ($i == $this->now_page) {
                if ($this->total_pages > 1) {
                    $return .= '<a class="page-active">' . $i . "</a>\n";
                }
            } else {
                $return .=  $this->_get_link($i, $i);
            }
        }
        //down_page
        $down_page = $this->down_page();
        if ($down_page) {
            $return .= $down_page;
        }
        //last_page
        $last_page = $this->last_page('末页');
        if ($last_page) {
            $return .= $last_page;
        }
        
        if($this->total_pages>10 && $jump ){
            $jumpHtml = '<a style="padding:0 5px" class="bornone" href="javascript:">跳转至</a>
        <a style="padding:0 10px" class="page-jump" href="javascript:"> <input class="bro-btn" type="text" id="toPage" value="" size="5"></a>
        <a style="padding:0 5px" class="bornone" href="javascript:">页</a>
       <a class="bornone c-qd" href="javascript:"><input type="button" id="toPageBtn" data-url="'.$this->parameter.'"  value="确定"></a>';
            $return .= $jumpHtml;
        }
        return $return;
    }
    
    public function show_2($jump) {
        $plus = $this->plus;
        if ($plus + $this->now_page > $this->total_pages) {
            $begin = $this->total_pages - $plus * 2;
        } else {
            $begin = $this->now_page - $plus;
        }

        $begin = ($begin >= 1) ? $begin : 1;
        $return = '';
        //first_page
        $first_page = $this->first_page('首页');
        if ($first_page) {
            $return .= '<li class="c-sm">' . $first_page . "</li>\n";
        }
        //up_page
        $up_page = $this->up_page('上一页');
        if ($up_page) {
            $return .= '<li class="pageprev" style="width:65px;">' . $up_page . "</li>\n";
        }
        for ($i = $begin; $i <= $begin + $plus * 2; $i++) {
            if ($i > $this->total_pages) {
                break;
            }
            if ($i == $this->now_page) {
                if ($this->total_pages > 1) {
                    $return .= '<li class="current"><span class="c-xz">' . $i . "</span></li>\n";
                }
            } else {
                $return .= '<li>' . $this->_get_link($i, $i) . '</li>';
            }
        }
        //down_page
        $down_page = $this->down_page();
        if ($down_page) {
            $return .= '<li class="pagenext"  style="width:65px;">' . $down_page . "</li>\n";
        }
        //last_page
        $last_page = $this->last_page('末页');
        if ($last_page) {
            $return .= '<li class="c-sm">' . $last_page . "</li>\n";
        }
        return $return;
    }
    
    //分页 使用更多 类似瀑布流
    public function show_3($jump) {
        $plus = $this->plus;
        if ($plus + $this->now_page > $this->total_pages) {
            $begin = $this->total_pages - $plus * 2;
        } else {
            $begin = $this->now_page - $plus;
        }

        $begin = ($begin >= 1) ? $begin : 1;
        $return = '';
        //first_page
       /* $first_page = $this->first_page('首页');
        if ($first_page) {
            $return .= '<li class="c-sm">' . $first_page . "</li>\n";
        }*/
        //up_page
       /* $up_page = $this->up_page('上一页');
        if ($up_page) {
            $return .= '<li class="pageprev" style="width:65px;">' . $up_page . "</li>\n";
        }*/
       /* for ($i = $begin; $i <= $begin + $plus * 2; $i++) {
            if ($i > $this->total_pages) {
                break;
            }
            if ($i == $this->now_page) {
                if ($this->total_pages > 1) {
                    $return .= '<li class="current"><span class="c-xz">' . $i . "</span></li>\n";
                }
            } else {
                $return .= '<li>' . $this->_get_link($i, $i) . '</li>';
            }
        }*/
        //down_page
        $down_page = $this->down_page("更多");
        if ($down_page) {
            $return .= $down_page ;
        }
        //last_page
        /*$last_page = $this->last_page('末页');
        if ($last_page) {
            $return .= '<li class="c-sm">' . $last_page . "</li>\n";
        }*/
        return $return;
    }

    public function show_4($jump) {
        $plus = $this->plus;
        if ($plus + $this->now_page > $this->total_pages) {
            $begin = $this->total_pages - $plus * 2;
        } else {
            $begin = $this->now_page - $plus;
        }

        $begin = ($begin >= 1) ? $begin : 1;
        $return = '';
        //first_page
        /* $first_page = $this->first_page('首页'); */
        /* if ($first_page) { */
        /*     $return .=  $first_page; */
        /* } */
        //up_page
        $up_page = $this->up_page();
        if ($up_page) {
            $return .=  $up_page;
        }
        for ($i = $begin; $i <= $begin + $plus * 2; $i++) {
            if ($i > $this->total_pages) {
                break;
            }
            if ($i == $this->now_page) {
                if ($this->total_pages > 1) {
                    $return .= '<li class="active"><span >' . $i . "</span></li>\n";
                }
            } else {
                $return .=  $this->_get_link($i, $i);
            }
        }
        //down_page
        $down_page = $this->down_page();
        if ($down_page) {
            $return .= $down_page;
        }
        //last_page
        /* $last_page = $this->last_page('末页'); */
        /* if ($last_page) { */
        /*     $return .= $last_page; */
        /* } */
        return $return;
    }

}

class PageTemplate extends Core_Lib_Page {
    
}
