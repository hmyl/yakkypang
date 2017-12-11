<?php

// 无限极分类 数据重组
function module_megre($module,$pid=0){
	$arr = array();
	foreach ($module as $v) {
		if ($v['pid'] == $pid) {
			$v['_child'] = module_megre($module,$v['id']);
			$arr[] = $v;
		}
	}
	return $arr;
}
//if array_column does not exist the below solution will work.
if(!function_exists("array_column")){
	// for php < 5.5
	if (!function_exists('array_column')) {
	    function array_column($input, $column_key, $index_key = null) {
	        $arr = array_map(function($d) use ($column_key, $index_key) {
	            if (!isset($d[$column_key])) {
	                return null;
	            }
	            if ($index_key !== null) {
	                return array($d[$index_key] => $d[$column_key]);
	            }
	            return $d[$column_key];
	        }, $input);

	        if ($index_key !== null) {
	            $tmp = array();
	            foreach ($arr as $ar) {
	                $tmp[key($ar)] = current($ar);
	            }
	            $arr = $tmp;
	        }
	        return $arr;
	    }
	}
}
// 公共函数
function p($data){
	if(is_array($data)||is_object($data)){
		echo '<pre>';
		print_r($data);
	}elseif(is_bool($data)){
		var_dump($data);
	}else{
		echo $data;
	}die;
}

 /**
 * 二维码生成函数
 * @param string         $value   二维码内容
 * @param intval         $matrixPointSize  生成图片大小
 * @param string         $errorCorrectionLevel   容错级别
 * @return string   返回
 */
function create_qrcode($value, $errorCorrectionLevel = 'H', $matrixPointSize = 6,$filename)
{
	vendor("Phpqrcode.Phpqrcode");
	$re = QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

	return $filename ;
	// return "<img src='{$filename}' width='200' height='200' />" ;
}


function getcode($id=1,$text='',$url){
    $src = $url.$id;

	$dir = C('qrcode');
	if(!is_dir($dir))
		mkdir($dir,0755,true);
	$filename = $id.'.png';

	$image = create_qrcode($src,'H',10,$dir.'/'.$filename);

	// $logo = C('qrcode').'2/1.png';//需要显示在二维码中的Logo图像
    if($text){
    	$logo = getGenerateImg($text,$id);
    	$QR = $image;
    	if ($logo !== FALSE) {
    	    $QR = imagecreatefromstring ( file_get_contents ( $QR ) );
    	    $logo = imagecreatefromstring ( file_get_contents ( $logo ) );
    	    $QR_width = imagesx ( $QR );
    	    $QR_height = imagesy ( $QR );
    	    $logo_width = imagesx ( $logo );
    	    $logo_height = imagesy ( $logo );
    	    $logo_qr_width = $QR_width / 5;
    	    $scale = $logo_width / $logo_qr_width;
    	    $logo_qr_height = $logo_height / $scale;
    	    $from_width = ($QR_width - $logo_qr_width) / 2;
    	    imagecopyresampled ( $QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height );
    	}
    	imagepng ( $QR, $dir.'/'.$filename);//带Logo二维码的文件名
    	if(file_exists($logo))
    		unlink($logo);
    }
	return $dir.'/'.$filename ;
}

//获取域名
function getHostInfo()
{
    $secure = getIsSecureConnection();
    $http = $secure ? 'https' : 'http';
    if (isset($_SERVER['HTTP_HOST'])) {
        $hostInfo = $http . '://' . $_SERVER['HTTP_HOST'];
    } else {
        $hostInfo = $http . '://' . $_SERVER['SERVER_NAME'];
        $port = $secure ? $getSecurePort() : $getPort();
        if (($port !== 80 && !$secure) || ($port !== 443 && $secure)) {
            $hostInfo .= ':' . $port;
        }
    }
    return $hostInfo;
}

function getSecurePort()
{
    $securePort = $getIsSecureConnection() && isset($_SERVER['SERVER_PORT']) ? (int) $_SERVER['SERVER_PORT'] : 443;
    return $securePort;
}


function getPort()
{
    $port = !$getIsSecureConnection() && isset($_SERVER['SERVER_PORT']) ? (int) $_SERVER['SERVER_PORT'] : 80;
    return $port;
}

/**
 * Return if the request is sent via secure channel (https).
 * @return boolean if the request is sent via secure channel (https)
 */
function getIsSecureConnection()
{
    return isset($_SERVER['HTTPS']) && (strcasecmp($_SERVER['HTTPS'], 'on') === 0 || $_SERVER['HTTPS'] == 1)
        || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') === 0;
}

function generateImg($source, $text1, $font ,$id ='') {
	$lenNum = mb_strlen($text1,"UTF-8");
	if($lenNum == 4){
		$width = 120;
	}
	if($lenNum == 3){
		$width = 100;
	}
    if($lenNum == 2){
		$width = 80;
	}
    $height = 30;
    $date = C('qrcode').'tmp/';
    if($id){
    	$img = $date . $id . '.jpg';
    }else{
	    $img = $date . md5 ( $source.time() . $text1  ) . '.jpg';
    }
    if(is_file($img)){
    	return $img;
    }
    $main = imagecreatefromjpeg ( $source );
    $target = imagecreatetruecolor ( $width, $height );
    $white = imagecolorallocate ( $target, 255, 255, 255 );
    imagefill ( $target, 0, 0, $white );
    imagecopyresampled ( $target, $main, 0, 0, 0, 0, $width, $height, $width, $height );
    // $text1 = $this->lastWords($text1);
    //控制文字和图片的位置融合
    
    /*if($lenNum == 1){
        $fontSize = 98;//18号字体
        $vX = 20;
        $vY = 45;
    }
    if($lenNum == 2){
        $fontSize = 68;//18号字体
        $vX = 25;
        $vY = 40;
    }
    if($lenNum == 3){
        $fontSize = 48;//18号字体
        $vX = 26;
        $vY = 25;
    }*/
    // if($lenNum == 4){
        $fontSize = 20;//18号字体
        $vX = 13;
        $vY = 12;
    // }
    

    $fontColor = imagecolorallocate ( $target, 0, 0, 0 );//字体的RGB颜色

    $fontWidth = imagefontwidth ( $fontSize );
    $fontHeight = imagefontheight ( $fontSize );

    $textWidth = $fontSize * $lenNum;

    $x = ceil(($width - $textWidth) / 2 ) - $vX;//计算文字的水平位置
    $y = ceil(($height - $textHeight) / 2) + $vY;//计算文字的垂直位置  

    imagettftext ( $target, $fontSize, 0, $x, $y, $fontColor, $font, $text1 );//写文字，且水平居中

    if(!is_dir($date))
		mkdir($date,0755,true);
    imagejpeg ( $target, './' . $img, 95 );
    imagedestroy ( $main );
    imagedestroy ( $target );
    return $img;
}

function getGenerateImg($key='未知',$id=''){
    $rand = mt_rand(2,3);
    //http://my.oschina.net/cart/
    $fontTTF  = dirname(THINK_PATH).'/Public/font/mini.ttf';
    $imgsource  = dirname(THINK_PATH).'/Public/font/'.$rand.'.jpg';
    $img = generateImg ( $imgsource, $key ,$fontTTF,$id);
    return $img;
}

/**
 * [read_excel 读取excel]
 * @param  [type] $file      [文件名 带有路径]
 * @param  string $sheetName [需要读取的表明，可以是array('sheet1','sheet2',....)]
 * @return [type]            [description]
 */
function read_excel($filename,$sheetName = ''){
	if(file_exists($filename)){
		vendor("PHPExcel.PHPExcel.IOFactory");
		if(!empty($sheetName)){
			$fileType=\PHPExcel_IOFactory::identify($filename);//自动获取文件的类型提供给phpexcel用
			$objReader=\PHPExcel_IOFactory::createReader($fileType);//获取文件读取操作对象
			$sheetName=$sheetName;
			$objReader->setLoadSheetsOnly($sheetName);//只加载指定的sheet
			$objPHPExcel=$objReader->load($filename);//加载文件
			$temp = [];
			foreach($objPHPExcel->getWorksheetIterator() as $k=>$sheet){//循环取sheet
					$tempRow = '';
					foreach($sheet->getRowIterator() as $row){//逐行处理
							//if($row->getRowIndex()<2)continue;
							$tempCol = [];
							foreach($row->getCellIterator() as $cell){//逐列读取
									$data=$cell->getValue();//获取单元格数据
									$tempCol[] = $data;
							}
							$tempRow[] = $tempCol;
					}
					$temp[$k]= $tempRow;
			}
			return $temp;
		}else{
			$objPHPExcel=\PHPEXCEL_IOFactory::load($filename);//加载文件
			$sheetCount=$objPHPExcel->getSheetCount();//获取excel文件里有多少个sheet
			for($i=0;$i<$sheetCount;$i++){
				$data[]=$objPHPExcel->getSheet($i)->toArray();//读取每个sheet里的数据 全部放入到数组中
			}
			return $data;
		}
	}else{
		return '请确保你的读取文件存在';
	}
	
}

//文件大小格式化
function formart_size($num){
	if(empty($num)) $num = 0;
	$g = 1024*1024*1024;
	$m = 1024*1024;
	if($num>$g)
		$num = round($num/$g,2).'G';
	elseif ($num>$m)
		$num = round($num/$m,2).'MB';
	elseif ($num>1024) 
		$num = round($num/1024,2).'KB';
	else
		$num = round($num,2).'K';
	return $num;
}

//加密
function get_pwd($str){
	return md5($str.'qh'.md5($str));
}

// 焦点 获取  控制器/方法   输出
function focus($c='',$echo = 'active'){
	if(empty($c)) exit();
	if($c)$c = trim(strtolower($c),'/');
	$d_a = strtolower(ACTION_NAME);
	$d_c = strtolower(CONTROLLER_NAME);
	if(strpos($c, '/')){
		$temp = explode('/', $c);
		if(in_array($d_c, explode(',',$temp[0]))&&($temp[1]==$d_a||$temp[1]=='*'||in_array($d_a, explode(',',$temp[1])))){
			if(empty($echo))
				echo  'active';
			else
				echo $echo;
		}else echo '';
	}else{
		if(in_array($d_a, explode(',',$c)))
			if(empty($echo))
				echo  'active';
			else
				echo $echo;
		else echo '';
	}
}



if(!function_exists('crop')){

    /**
     * [crop 压缩图片]
     * @param  [type]  $path   [图片路径]
     * @param  integer $width  [图片宽度]
     * @param  integer $height [图片高度]
     * @return [type]          [图片路径]
     */
    function crop($path,$width=100,$height=100,$type = 3){
        $path = '.'.str_replace('\\', '/', $path);
        if(is_file($path)){
            $a = explode('.', $path);
            $ext = array_pop($a);
            // 新图片名称
            $fileName = str_replace('.'.$ext, '_'.$width.'_'.$height.'.'.$ext,$path);
            /*if(is_file($fileName)){
                return trim($fileName,'.');
            }*/
            $images =  new \Think\Image(); 
            $img = $images->open($path);
            // 原图高度
            $w = $img->width();
            // 图片宽度
            $h = $img->height();
            $width = $width<$w?$width:$w;
            $height = $height<$h?$height:$h;
            $re = $img->thumb($width,$height,$type)->save($fileName);
            if($re){
                return trim($fileName,'.');
            }else{
                return trim($path,'.');
            }
        }else{
            return trim($path,'.');
        }
    }
}
