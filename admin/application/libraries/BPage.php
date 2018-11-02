<?php

 
class BPage {

    /**
     * 每页显示条数
     * @var int
     */
    private $_pageCount = 0;

    /**
     * 总条目数
     * @var int
     */
    private $_num = 0;

    /**
     * 分页总数
     * @var int
     */
    private $_pageNum = 0;

    /**
     * 当前显示的页数
     * @var int
     */
    private $_currentPage = 0;

    /**
     * 分页链接
     * @var string
     */
    private $_pageLink = '';

    /**
     * 每次显示数字[1][2][3][4]..数量
     * @var int
     */
    private $_showNum = 0;

    /**
     * 最大显示总数
     * @var int
     */
    private $_maxNums = 10000;

    /**
     * 初始化分页
     * @param int $pageCount 每页显示条目：10
     * @param int $nums		        总记录条数：1024
     * @param int $currentPage 当前的页码：8
     * @param int $showNum	   每次显示数字的数量：10
     * @param string $pageLink 分页的连接:如test.php?page=
     */
    public function __construct($pageCount, $nums, $currentPage, $showNum, $pageLink) {

        $this->_pageCount = intval($pageCount);
        $this->_num = intval($nums);

        $this->_showNum = intval($showNum);
        $this->_pageNum = ceil($this->_num / $pageCount);
        $this->_pageLink = $pageLink;

        if (!$currentPage) {
            $this->_currentPage = 1;
        } else {
            $this->_currentPage = intval($currentPage) > $this->_pageNum ? $this->_pageNum : intval($currentPage);
        }
    }

    /**
     * 显示分页
     * @return string
     */
    public function showPageHtml() {

        if ($this->_num == 0)
            return '';

        $pageStr = '<ul class="pagination">';
        if ($this->_num > $this->_maxNums) {
            $this->_num = $this->_maxNums;
            //  $pageStr .= "<li class=\"page_count\"><em>共搜索到超过{$this->_maxNums}条记录</em></li>";
        } else {
            //$pageStr .= "<li class=\"page_count\"><em>共搜索到{$this->_num}条记录</em></li>";
        }
        //$pageStr .= "当前第" . $this->_currentPage . "/" . $this->_pageNum."页 ";

        if ($this->_currentPage > 1) {
            $firstPageUrl = $this->_pageLink . "1";
            $prewPageUrl = $this->_pageLink . ($this->_currentPage - 1);
            $pageStr .=  '<li class=""><a href="'.$prewPageUrl.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        } else {
            
            $pageStr .=  '<li class="disabled"><a href="javascript:void(0);" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        }

        $a = $this->_initNumPage();
        for ($i = 0; $i < count($a); $i++) {
            $s = $a[$i];
            if ($s == $this->_currentPage) {
                $pageStr .= '<li class="active"><a href="javascript:void(0);">' . $s . '</a></li>';
                
            } else {
                $url = $this->_pageLink . $s;
                $pageStr .= '<li class=""><a href="'.$url.'">' . $s . '</a></li>';
               
                
            }
        }

        if ($this->_currentPage < $this->_pageNum) {
            $lastPageUrl = $this->_pageLink . $this->_pageNum;
            $nextPageUrl = $this->_pageLink . ($this->_currentPage + 1);
            $pageStr .=  '<li class=""><a href="'.$nextPageUrl.'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
           
        } else {
            $pageStr .=  '<li class="disabled"><a href="javascript:void(0);" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
           
        }

        $pageStr .= '</ul>';
        return $pageStr;
    }
    
 	public function showPageHtml3() {

        if ($this->_num == 0)
            return '';

        $pageStr = '<ul>';
       
            $pageStr .= "<li class=\"page_count\">共{$this->_num}条</li>";
       
        //$pageStr .= "当前第" . $this->_currentPage . "/" . $this->_pageNum."页 ";

        if ($this->_currentPage > 1) {
            $firstPageUrl = $this->_pageLink . "1";
            $prewPageUrl = $this->_pageLink . ($this->_currentPage - 1);
            $pageStr .= "<a class='jxbtn' href='{$firstPageUrl}'><li class=\"shou hidden\">首页</li></a>";
            $pageStr .= "<a class='prv jxbtn' href='{$prewPageUrl}'><li class=\"prev hidden\">上一页</li></a>";
        } else {
            $pageStr .= "<a class=\"disabled jxbtn\" href=\"javascript:void(0);\"><li class=\"shou \">首页</li></a>";
            $pageStr .= "<a class=\"disabled jxbtn\" href=\"javascript:void(0);\"><li class=\"prev \">上一页</li></a>";
        }

        $a = $this->_initNumPage();
        for ($i = 0; $i < count($a); $i++) {
            $s = $a[$i];
            if ($s == $this->_currentPage) {
                $pageStr .= "<a class=\"disabled active curren\" href=\"javascript:void(0);\"><strong><li class=\"selected\">" . $s . "</li></strong></a>";
            } else {
                $url = $this->_pageLink . $s;
                $pageStr .= "<a class=\"jxbtn\" href='{$url}'><li class=\"\" >" . $s . "</li></a>";
                
            }
        }

        if ($this->_currentPage < $this->_pageNum) {
            $lastPageUrl = $this->_pageLink . $this->_pageNum;
            $nextPageUrl = $this->_pageLink . ($this->_currentPage + 1);
            $pageStr .= "<a class=\"jxbtn\" href='{$nextPageUrl}'><li class=\"next\">下一页</li></a> ";
            $pageStr .= "<a class=\"jxbtn\" href='{$lastPageUrl}'><li class=\"wei\">尾页</li></a> ";
        } else {
            $pageStr .= "<a class=\"disabled jxbtn\" href=\"javascript:void(0);\"><li class=\"next\">下一页</li></a>";
            $pageStr .= "<a class=\"disabled jxbtn\" href=\"javascript:void(0);\"><li class=\"wei\">尾页</li></a> ";
        }
        $pageStr .="<input type=\"text\" style=\"width:20px\" id=\"pagenum\">&nbsp<input type=\"button\" style=\"width:30px\" value='go' id=\"gopage\" onclick=\"gourl()\">";
        $pageStr .="<script>
        function gourl()
        {
            var num=document.getElementById(\"pagenum\").value

            if(num>0&&num<=$this->_pageNum)
            {

                  window.location.href=\"$this->_pageLink\"+num

            }
            else
            {

                 alert('输入非法');
            }
        }

        </script>";
        $pageStr .= '</ul>';
        return $pageStr;
    }
    


    /**
     * 用来给建立分页的数组初始化的函数
     * @return multitype:number
     */
    private function _initArray() {
        $array = array();

        for ($i = 0; $i < $this->_showNum; $i++) {
            $array[$i] = $i;
        }
        return $array;
    }

    /**
     * 初始化分页数字的数组
     * @return multitype:number
     */
    private function _initNumPage() {
        // 		var_dump($this->_pageNum);
        // 		var_dump($this->_currentPage);
        // 		var_dump($this->_showNum);
        if ($this->_pageNum < $this->_showNum) {
            $current_array = array();
            for ($i = 0; $i < $this->_pageNum; $i++) {
                $current_array[$i] = $i + 1;
            }
        } else {
            $current_array = $this->_initArray();
            if ($this->_currentPage <= 3) {
                for ($i = 0; $i < count($current_array); $i++) {
                    $current_array[$i] = $i + 1;
                }
            } elseif ($this->_currentPage <= $this->_pageNum
                    && $this->_currentPage > $this->_pageNum - $this->_showNum + 1) {
                for ($i = 0; $i < count($current_array); $i++) {
                    $current_array[$i] = ($this->_pageNum) - ($this->_showNum) + 1 + $i;
                }
            } else {
                for ($i = 0; $i < count($current_array); $i++) {
                    $current_array[$i] = $this->_currentPage - 2 + $i;
                }
            }
        }

        return $current_array;
    }

    /**
     * 将临时变量置空
     */
    public function __destruct() {
        unset($pageCount);
        unset($nums);
        unset($currentNum);
        unset($showNum);
        unset($pageLink);
    }

}

?>