<?php

class Upload extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function index() {
        require_once(dirname(__FILE__) . '/../config/constants.php');
        date_default_timezone_set('PRC');
        //----------------------------------------- start edit here ---------------------------------------------//
        $script_location = G_IMAGE_DOMAIN; // location fo the script
        $maxlimit = 9048576; // maxim image limit
        $dir = '';
        //$folder = "images"; // folder where to save images
        if ($_POST && !empty($_POST) && isset($_POST['typeinfo'])) {
            if ($_POST['typeinfo']) {
                //按月生成目录
                $y = date('Y');
                $m = date('m');
                $d = date('d');
                $dir = $_POST['typeinfo'] . '/' . $y . '/' . $m . '/' . $d;
            }
            //目录增加 id一级
            if ($_POST && !empty($_POST) && isset($_POST['id'])) {
                $dir .= $_POST['id'];
            }
        }
        // echo $dir;
        // echo $dir;exit();
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $folder = $dir; // folder where to save images
        // requirements
        $minwidth = 10; // minim width
        $minheight = 10; // minim height
        $maxwidth = 4000; // maxim width
        $maxheight = 4000; // maxim height
        $message = array('status' => 0, 'mess' => '', 'smailurl' => '', 'imageurl' => '');
        // allowed extensions
        $extensions = array('.png', '.gif', '.jpg', '.jpeg', '.PNG', '.GIF', '.JPG', '.JPEG');
        //----------------------------------------- end edit here ---------------------------------------------//
        // check that we have a file
        if ((!empty($_FILES["uploadfile"])) && ($_FILES['uploadfile']['error'] == 0)) {
            // check extension
            $extension = strrchr($_FILES['uploadfile']['name'], '.');
            if (!in_array($extension, $extensions)) {
                $message['status'] = 0;
                $message['mess'] = '上传类型不正确，可上传 .png , .gif, .jpg, .jpeg 格式';
            } else {
                // get file size
                $filesize = $_FILES['uploadfile']['size'];
                // check filesize
                if ($filesize > $maxlimit) {
                    $message['status'] = 0;
                    $message['mess'] = '上传图片过大';
                } else if ($filesize < 1) {
                    $message['status'] = 0;
                    $message['mess'] = '请上传文件';
                } else {
                    // temporary file
                    $uploadedfile = $_FILES['uploadfile']['tmp_name'];
                    // capture the original size of the uploaded image
                    list($width, $height) = getimagesize($uploadedfile);
                    // check if image size is lower
                    if ($width < $minwidth || $height < $minheight) {
                        $message['status'] = 0;
                        $message['mess'] = '上传图片太小，请上传大于' . $minwidth . 'x' . $minheight . '图片';
                    } else if ($width > $maxwidth || $height > $maxheight) {
                        $message['status'] = 0;
                        $message['mess'] = '上传图片太大，请上传小于' . $maxwidth . 'x' . $maxheight . '图片' . '当前大小' . $width . '***' . $height;
                    } else {
                        // all characters lowercase
                        $filename = strtolower($_FILES['uploadfile']['name']);
                        // replace all spaces with _
                        $filename = preg_replace('/\s/', '_', $filename);
                        // extract filename and extension
                        $pos = strrpos($filename, '.');
                        $basename = substr($filename, 0, $pos);
                        $basename = substr(md5($basename), 0, 6);
                        $ext = substr($filename, $pos + 1);
                        // get random number9
                        $rand = time();
                        // image name
                        $image = $basename . '-' . $rand . "." . $ext;
                        // check if file exists
                        $check = $folder . '/' . $image;
                        if (file_exists($check)) {
                            $message['status'] = 0;
                            $message['mess'] = '非常抱歉：图片已经存在';
                        } else {
                            // check if it's animate gif
                            $frames = exec("identify -format '%n' " . $uploadedfile . "");

                            if ($frames > 1) {
                                // yes it's animate image
                                // copy original image
                                copy($_FILES['uploadfile']['tmp_name'], $folder . '/' . $image);
                                // orignal image location
                                $write_image = $folder . '/' . $image;
                                //ennable form
                            } else {

                                // create an image from it so we can do the resize
                                switch ($ext) {
                                    case "gif":
                                        $src = imagecreatefromgif($uploadedfile);
                                        break;
                                    case "jpg":
                                        $src = imagecreatefromjpeg($uploadedfile);
                                        break;
                                    case "jpeg":
                                        $src = imagecreatefromjpeg($uploadedfile);
                                        break;
                                    case "png":
                                        $src = imagecreatefrompng($uploadedfile);
                                        break;
                                }
                                ////my
//                                   $uploadedfile = $this->mark($uploadedfile);
                                $guige = array('s_' => '500,300', 'b_' => '600,450', 'l_' => '260,195');
                                foreach ($guige as $gk => $gv) {
                                    copy($_FILES['uploadfile']['tmp_name'], $folder . '/' . $image);
                                    $write_image = $folder . '/' . $image;
                                    // create third thumbnail image - resize original to 125 width x 125 height pixels
                                    $arrtmp = explode(',', $gv);
                                    $newwidth = $arrtmp[0];
                                    $newheight = $arrtmp[1];
                                    $tmp = imagecreatetruecolor($newwidth, $newheight);
                                    imagealphablending($tmp, false);
                                    imagesavealpha($tmp, true);
                                    $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
                                    imagefilledrectangle($tmp, 0, 0, $newwidth, $newheight, $transparent);
                                    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                                    // write thumbnail to disk
                                    $write_thumb3image = $folder . '/' . $gk . $image;
                                    $this->imageUpdatesize( $write_image, $newwidth, $newheight,$gk);
                                    $this->mark($write_thumb3image, G_UPLOAD . 'mark.png', $folder . '/', $gk . $image);
                                }

                                //end my
                                // all is done. clean temporary files
                                imagedestroy($src);
                                imagedestroy($tmp);
                                $message['status'] = 1;
                                $message['mess'] = '上传成功';
                                $message['listurl'] = str_replace(G_UPLOAD, '', $write_thumb3image);
                                //  $message['imageurl'] = $write_thumb2image;
                                $message['imageurl'] = str_replace(G_UPLOAD, '', $write_image);
                                $this->mark(G_UPLOAD . $message['imageurl'], G_UPLOAD . 'mark.png', $folder . '/', $image);
                                echo json_encode($message); // image preview
                                exit;
                            }
                        }
                    }
                }
            }
            // error all fileds must be filled
        } else {
            $message['status'] = 0;
            $message['mess'] = '请上传文件';
        }
        echo json_encode($message);
    }

    /**
     * 等比例缩放函数（以保存新图片的方式实现）
     * @param string $picname  被缩放的处理图片源
     * @param int $maxx 缩放后图片的最大宽度
     * @param int $maxy 缩放后图片的最大高度
     * @param string $pre 缩放后图片的前缀名
     * @return $string 返回后的图片名称（） 如a.jpg->s.jpg
     *
     * */
    function imageUpdatesize($picname, $maxx = 100, $maxy = 100, $pre = "s_") {
      
        $info = getimageSize($picname); //获取图片的基本信息 
        $w = $info[0]; //获取宽度
        $h = $info[1]; //获取高度
        //获取图片的类型并为此创建对应图片资源
        switch ($info[2]) {
            case 1://gif
                $im = imagecreatefromgif($picname);
                break;
            case 2://jpg
                $im = imagecreatefromjpeg($picname);
                break;
            case 3://png
                $im = imagecreatefrompng($picname);
                break;
            default:
                die("图像类型错误");
        }
        //计算缩放比例
        if (($maxx / $w) > ($maxy / $h)) {
            $b = $maxy / $h;
        } else {
            $b = $maxx / $w;
        }
        //计算出缩放后的尺寸
        $nw = floor($w * $b);
        $nh = floor($h * $b);
        //创建一个新的图像源（目标图像）
        $nim = imagecreatetruecolor($nw, $nh);
        //执行等比缩放
        imagecopyresampled($nim, $im, 0, 0, 0, 0, $nw, $nh, $w, $h);
        //输出图像（根据源图像的类型，输出为对应的类型）
        $picinfo = pathinfo($picname); //解析源图像的名字和路径信息
        $newpicname = $picinfo["dirname"] . "/" . $pre . $picinfo["basename"];
        switch ($info[2]) {
            case 1:
                imagegif($nim, $newpicname);
                break;
            case 2:
                imagejpeg($nim, $newpicname);
                break;
            case 3:
                imagepng($nim, $newpicname);
                break;
        }
        //释放图片资源
        imagedestroy($im);
        imagedestroy($nim);
        //返回结果
        return $newpicname;
    }

    /**
     * 生成图片
     * @param type $imgfile
     * @return type
     */
    private function img_create_from_ext($imgfile) {
        $info = getimagesize($imgfile);
        $im = null;
        switch ($info[2]) {
            case 1:
                $im = imagecreatefromgif($imgfile);
                break;
            case 2:
                $im = imagecreatefromjpeg($imgfile);
                break;
            case 3:
                $im = imagecreatefrompng($imgfile);
                break;
        }
        return $im;
    }

    /**
     * 图片加水印
     * @param type $srcImg
     * @param type $waterImg
     * @param type $savepath
     * @param type $savename
     * @param type $position
     * @param type $opacity
     * @return string
     */
    private function mark($srcImg, $waterImg, $savepath = null, $savename = null, $position = 3, $opacity = 10) {
        $temp = pathinfo($srcImg);
        $name = $temp['basename'];
        $path = $temp['dirname'];
        $exte = $temp['extension'];
        $savename = $savename ? $savename : $name;
        $savepath = $savepath ? $savepath : $path;
        $savefile = $savepath . '/' . $savename;

        $srcinfo = @getimagesize($srcImg);
        if (!$srcinfo) {
            return -1;
        }
        $waterinfo = @getimagesize($waterImg);
        if (!$waterinfo) {
            return -2;
        }
        $srcImgObj = $this->img_create_from_ext($srcImg);
        if (!$srcImgObj) {
            return -3;
        }
        $waterImgObj = $this->img_create_from_ext($waterImg);
        if (!$waterImgObj) {
            return -4;
        }

        switch ($position) {
            case 1:
                $x = $y = 0;
                break;
            case 2:
                $x = $srcinfo[0] - $waterinfo[0];
                $y = 0;
                break;
            case 3:
                $x = ($srcinfo[0] - $waterinfo[0]) / 2;
                $y = ($srcinfo[1] - $waterinfo[1]) / 2;
                break;
            case 4:
                $x = 0;
                $y = $srcinfo[1] - $waterinfo[1];
                break;
            case 5:
                $x = $srcinfo[0] - $waterinfo[0];
                $y = $srcinfo[1] - $waterinfo[1];
                break;
        }


        imagecopy($srcImgObj, $waterImgObj, $x, $y, 0, 0, $waterinfo[0], $waterinfo[1]);

        switch ($srcinfo[2]) {
            case 1:
                imagegif($srcImgObj, $savefile);
                break;
            case 2:
                imagejpeg($srcImgObj, $savefile);
                break;
            case 3:
                imagepng($srcImgObj, $savefile);
                break;
            default: return -5;
        }
        imagedestroy($srcImgObj);
        imagedestroy($waterImgObj);
        return $savefile;
    }

}

?>