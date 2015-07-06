<?php
/* 访问控制 */
defined('IN_ECTOUCH') or die('Deny Access');
class MessageSend
{

//通过用户的推送事件回复用户信息
    public function send_text_message($fromUsername, $toUsername, $contentStr)
    {
        //该方法负责在收到事件时回复用户文本信息
        $textTpl = "<xml>
                                        <ToUserName><![CDATA[%s]]></ToUserName>
                                        <FromUserName><![CDATA[%s]]></FromUserName>
                                        <CreateTime>%s</CreateTime>
                                        <MsgType><![CDATA[%s]]></MsgType>
                                        <Content><![CDATA[%s]]></Content>
                                 </xml>";
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), "text", $contentStr);
        echo $resultStr;
    }

//向用户推送文本信息
    public function send_to_user($fromUsername, $content,$access_token)
    {
        $content = urlencode(trim($content));
        $send_msg_url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $access_token;
        $post_array_data = array(
            "touser" => $fromUsername,
            "msgtype" => "text",
            "text" => array(
                "content" => $content
            )
        );
        $post_json_data = urldecode(json_encode($post_array_data));
        $result = postMsg($send_msg_url, $post_json_data);
    }

    //向用户推送img或voice信息
    function post_IV_MsgDeal($openid, $msgType, $media_id,$access_token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $access_token;
        $post_array_data = array("touser" => $openid, "msgtype" => $msgType, $msgType => array("media_id" => $media_id));
        $post_json_data = json_encode($post_array_data);
        p($post_json_data);
        $result = postMsg($url, $post_json_data);
        return $result;
    }

    //上传图片到微信服务器
    public function upload_img_to_server($media_type, $file,$access_token)
    {
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=" . $access_token . "&type=" . $media_type;
        $post_data = array("media" => "@" . $file);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($output, true);
        return $result["media_id"];
    }

    public function get_qrcode($scene_id,$access_token)
    {
        $get_msg_url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=" . $access_token;
        $post_er_array = array(
            "action_name" => "QR_LIMIT_SCENE",
            "action_info" => array(
                "scene" => array(
                    "scene_id" => $scene_id
                )
            )
        );
        $post_json = json_encode($post_er_array);
        $result = postMsg($get_msg_url, $post_json);
        $arr = json_decode($result, true); //获取ticket的值
        $ticket = $arr["ticket"];
        return $ticket;

    }


}
