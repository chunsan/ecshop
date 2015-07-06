<?php

/* 访问控制 */
defined('IN_ECTOUCH') or die('Deny Access');
class ShareButton
{


    public function handle($postObj)
    {
        //用户点击赚积分,生成分享链接推送给用户
        $fromUsername = $postObj['FromUserName'];
        $toUsername = $postObj['ToUserName'];
        $access_token=$postObj['access_token'];
        $content = '扫码即可关注!';
		$message_send=new MessageSend();
        $message_send->send_text_message($fromUsername, $toUsername, $content);
        //推送分享链接
        $content = '正在为您生成二维码，请稍候......您的ID为'.$postObj['scene_id'];
        $message_send->send_to_user($fromUsername, $content,$access_token);

        //推送携带用户信息的二维码信息
        //根据用户id命名,让二维码图片和用户绑定
        $destination = './include/apps/default/weixinimg/';
        if(!file_exists($destination)){
            mkdir($destination);
        }
        $destination = $destination . $fromUsername . '.jpg';
        if (!file_exists($destination)) {
            //调用微信接口生成二维码信息
		    $ticket = $message_send->get_qrcode($postObj['scene_id'],$access_token);
            $get_erweima_url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$ticket;
            $file = downloadfile($get_erweima_url);
            copy(realPath($file),$destination);
            $this->picture_deal($destination,$postObj['scene_id']);
        }
        //上传二维码图片到微信服务器
        $media_type = "image";
        $media_id = $message_send->upload_img_to_server($media_type, $destination,$access_token);
        $message_send->post_IV_MsgDeal($fromUsername, $media_type, $media_id,$access_token);
    }

    public function picture_deal($temp_picture,$userid)
    {
        $im = Imagecreatefromjpeg($temp_picture);
        $textcolor = imagecolorallocate($im, 0, 0, 0);
        imagestring($im, 5, 30, 400, "ID=$userid", $textcolor);//加入用户ID
        imagejpeg($im,$temp_picture);
        $footerphoto = "./include/apps/default/weixin/big.jpg";//已有图片
        $srcSize = getimagesize($temp_picture);
        $srcSize1 = getimagesize($footerphoto);
        $bigphoto = imagecreatetruecolor($srcSize1[0], $srcSize1[1]);
        $srcImageSource = imagecreatefromjpeg($temp_picture);
        imagecopyresampled($bigphoto, $srcImageSource, 0, 0, 0, 0,
            $srcSize1[0], $srcSize1[1], $srcSize[0], $srcSize[1]);
        $biginfo = $srcSize1;
        $footerinfo = getimagesize($footerphoto);
        $bigwidth = $biginfo[0];
        $bigheight = $biginfo[1];
        $footerwidth = $footerinfo[0];
        $footerheight = $footerinfo[1];

        $initheight = max(array($bigwidth, $footerwidth));
        $initwidth = max(array($bigheight, $footerheight)) + min(array($bigheight, $footerheight));

        header("Content-type: image/jpeg");
        $im = imagecreatetruecolor($initwidth, $initheight);
        imagecopyresized($im, $bigphoto, 0, 0, 0, 0, $bigwidth, $bigheight, $bigwidth, $bigheight);
        imagecopyresized($im, imagecreatefromjpeg($footerphoto), $bigwidth, 0, 0, 0, $footerwidth, $footerheight, $footerwidth, $footerheight);
        imagejpeg($im,$temp_picture);
    }


}

?>
