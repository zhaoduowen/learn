<?php
class XExcel {
    /**
     * @param array $title
     * @param array $data   二维
     * @param string $filename  without ".csv"
     *
     */
    static public function GetExcelFile($title,$data,$filename="default"){

        if(is_array($title)){
            $title=join(",",$title)."\r\n";
        }

        $content="";
        if(is_array($data)){
            foreach($data as $v){
                foreach($v as $vv){
                    $content.=$vv;
                    $content.=",";
                }
                $content.="\r\n";
            }
        }
        $data = $title.$content;
        $name = $filename.".csv";

        $filesize= strlen($data);

        @header("Content-Type:application/x-msdownload");
        @header("Content-Disposition:".(strstr($_SERVER[TTP_USER_AGENT],"MSIE")?"":"attachment;")."filename=$name");
//			@header("Content-Length:$filesize");
        echo mb_convert_encoding($data, "GBK", "auto");

    }
}
