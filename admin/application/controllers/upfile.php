<?php
class Upfile extends CI_Controller
{
    function __construct()
    {
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
                $dir .=$_POST['id'];
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
                                $guige = array('s_' => '500,300', 'b_' => '600,450', 'l_' => '260,195');
                                foreach ($guige as $gk => $gv) {
                                    copy($_FILES['uploadfile']['tmp_name'], $folder . '/' . $image);
                                    $write_image = $folder . '/' . $image;
        // create third thumbnail image - resize original to 125 width x 125 height pixels
                                    $arrtmp = explode(',', $gv);
                                    // $newwidth = $arrtmp[0];
                                    // $newheight = $arrtmp[1];
                                    //测试要求原图
                                     $newwidth = $width;
                                    $newheight = $height;
                                    $tmp = imagecreatetruecolor($newwidth, $newheight);
                                    imagealphablending($tmp, false);
                                    imagesavealpha($tmp, true);
                                    $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
                                    imagefilledrectangle($tmp, 0, 0, $newwidth, $newheight, $transparent);
                                    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        // write thumbnail to disk
                                    $write_thumb3image = $folder . '/' . $gk . $image;
                                    switch ($ext) {
                                        case "gif":
                                            imagegif($tmp, $write_thumb3image);
                                            break;
                                        case "jpg":
                                            imagejpeg($tmp, $write_thumb3image, 100);
                                            break;
                                        case "jpeg":
                                            imagejpeg($tmp, $write_thumb3image, 100);
                                            break;
                                        case "png":
                                            imagepng($tmp, $write_thumb3image);
                                            break;
                                    }
                                }
                                //end my
        // all is done. clean temporary files
                                imagedestroy($src);
                                imagedestroy($tmp);
                                $message['status'] = 1;
                                $message['mess'] = '上传成功';
                                $message['listurl'] = str_replace(G_UPLOAD,'',$write_thumb3image);
                                //  $message['imageurl'] = $write_thumb2image;
                                $message['imageurl'] = str_replace(G_UPLOAD,'',$write_image);
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

    //上传非图片文件
    public function uploadfile() {
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
                $dir .=$_POST['id'];
            }
        }
        // echo $dir;

        // echo $dir;exit();
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $save_path = $folder = $dir; // folder where to save images
       
        $message = array('status' => 0, 'mess' => '');
        // allowed extensions
        $extensions = array('.csv', '.xlsx');
        //----------------------------------------- end edit here ---------------------------------------------//
        // check that we have a file
        if ((!empty($_FILES["uploadfile"])) && ($_FILES['uploadfile']['error'] == 0)) {
            // check extension
            $extension = strrchr($_FILES['uploadfile']['name'], '.');
            if (!in_array($extension, $extensions)) {
                $message['status'] = 0;
                $message['mess'] = '上传类型不正确，可上传 .xlsx , .csv 格式';
            } else {
        
                $filesize = $_FILES['uploadfile']['size'];
                
                if ($filesize > $maxlimit) {
                    $message['status'] = 0;
                    $message['mess'] = '上传文件过大';
                } else if ($filesize < 1) {
                    $message['status'] = 0;
                    $message['mess'] = '请上传文件';
                } else {
        
                    $uploadedfile = $_FILES['uploadfile']['tmp_name'];

                    $filename = strtolower($_FILES['uploadfile']['name']);
                    $pos = strrpos($filename, '.');
                    $basename = substr($filename, 0, $pos);
                    $basename = substr(md5($basename), 0, 6);
                    $ext = substr($filename, $pos + 1);
   
                    $rand = time();
    
                    $image = $basename . '-' . $rand . "." . $ext;
                    $saveFile_path = $folder . '/' . $image;

                    if(getOS()=='Linux'){
                        
                        $mv = move_uploaded_file($uploadedfile, $saveFile_path);
                    }else{
                        //解决windows下中文文件名乱码的问题                  
                        $save_path = safeEncoding($save_path,'GB2312');

                        $mv = move_uploaded_file($uploadedfile, $saveFile_path);
                    }
                    if(!$mv){                   
                        echo json_encode(array('status'=>0,'mess'=>'上传失败'));exit;
                    }   
                    echo json_encode(array(
                        'status'=>1,
                        'mess'=>'上传成功',
                        'file_path' => str_replace(G_UPLOAD,'',$saveFile_path)
                        
                        ));exit;
                    
                
                   
                }
            
            }
        } else {
            $message['status'] = 0;
            $message['mess'] = '请上传文件';
        }
        echo json_encode($message);
       
    }
}
?>