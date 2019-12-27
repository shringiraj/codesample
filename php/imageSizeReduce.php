<?php

namespace common\components;

use Yii;
use yii\helpers\Url;
class imageSizeReduce extends \yii\web\Request {

    function imgThumb($image, $new_width = 400, $new_height = null) {
        $imgPath = Yii::getAlias($image);
        list($width, $height) = $attr = getimagesize($imgPath);
        $factor = $width / $new_width;
        $new_height = ($new_height === null) ? $height / $factor : $new_height;
        //print_r($attr);

        $path_info = pathinfo($image);
        $extension = $path_info['extension'];

        $new_img = time() . "." . $extension;
        $new_img_path = Yii::getAlias("@frontend/web/images/temp/" . $new_img);

        $t = imagecreatefromjpeg($imgPath);
        $s = imagecreatetruecolor($new_width, $new_height);
        $x = imagesx($t);
        $y = imagesy($t);
        imagecopyresampled($s, $t, 0, 0, 0, 0, $new_width, $new_height, $x, $y);
        imagejpeg($s, $new_img_path);
        chmod($new_img_path, 777);
//        return "/images/temp/".$new_img;
        return Url::to(["/images/temp/".$new_img]);
    }

}

?>