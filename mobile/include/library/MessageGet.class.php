<?php
/* 访问控制 */
defined('IN_ECTOUCH') or die('Deny Access');
class MessageGet
{

    public function get_access_token()
    {
       $data1='22222';
        $data = json_decode(file_get_contents("./include/apps/default/weixin/access_token.json"));
        logResult(var_export('$data->expire_time ='.$data->expire_time ,true));
        logResult(var_export('time ='.time() ,true));
        if ($data->expire_time < time()) {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . APPID . "&secret=" . APPSECRET;
            logResult(var_export('$url ='.$url ,true));
            $res = json_decode(MessageGet::httpGet($url));
            logResult(var_export('$res ='.$res ,true));
            $access_token = $res->access_token;
            if ($access_token) {
                $data->expire_time = 600;
                $data->access_token = $access_token;
                $fp = fopen("./include/apps/default/weixin/access_token.json", "w");
                if(!$fp){
                    return MessageGet::get_access_token();
                }
                flock($fp,LOCK_EX);
                fwrite($fp, json_encode($data));
                fclose($fp);
            }else{
            }
        } else {
            $access_token = $data->access_token;
        }
        $access_token = $data->access_token;
        return $access_token;
    }

    public function get_js_api_ticket()
    {
        $data = json_decode(file_get_contents("./include/apps/default/weixin/jsapi_ticket.json"));
        if ($data->expire_time < time()) {
            $accessToken = MessageGet::get_access_token();
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode(MessageGet::httpGet($url));
            if(!isset($res->ticket)){
                //当不是微信浏览器访问时，无需验证
                return;
            }
            $ticket = $res->ticket;
            if ($ticket) {
                //微信服务器返回的ticket有效时间为7000,设置5000之后过期，过期之后重新获取
                $data->expire_time = time() + $res->expires_in - 300;
                $data->jsapi_ticket = $ticket;
                $fp = fopen("./include/apps/default/weixin/jsapi_ticket.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $ticket = $data->jsapi_ticket;
        }
        return $ticket;
    }

    public function get_qrcode($scene_id,$access_token)
    {
//        $access_token = MessageGet::get_access_token();
        $get_msg_url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=" . $access_token;
        $post_er_array = array(
            "action_name" => "QR_LIMIT_SCENE",
            "action_info" => array(
                "scene" => array(
                    "scene_id" => $scene_id
                )
            )
        );
        logResult(var_export('$post_er_array='.$post_er_array,true));
        $post_json = json_encode($post_er_array);
        $result = postMsg($get_msg_url, $post_json);
        $arr = json_decode($result, true); //获取ticket的值
        $ticket = $arr["ticket"];
        return $ticket;

    }

    public function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

}
