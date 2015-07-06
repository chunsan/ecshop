<?php

/**
 * ECTouch Open Source Project
 * ============================================================================
 * Copyright (c) 2012-2014 http://ectouch.cn All rights reserved.
 * ----------------------------------------------------------------------------
 * 文件名称：IndexController.class.php
 * ----------------------------------------------------------------------------
 * 功能描述：ECTouch首页控制器
 * ----------------------------------------------------------------------------
 * Licensed ( http://www.ectouch.cn/docs/license.txt )
 * ----------------------------------------------------------------------------
 */
/* 访问控制 */
defined('IN_ECTOUCH') or die('Deny Access');

class IndexController extends CommonController {



    /**
     * 首页信息
     */
    public function index() {
        // 自定义导航栏
        if (isset($_GET['code']) && isset($_GET['state']) ){
            $openid =$this -> GetOpenid($_GET['code']);
            if(isset($openid)&&!empty($openid)){
                $time = time() + 3600 * 24 * 30;
                setcookie("ECS[openid]", $openid, $time, $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);
            }
        }
        $navigator = model('Common')->get_navigator();
        $this->assign('navigator', $navigator['middle']);
        $this->assign('best_goods', model('Index')->goods_list('best', C('page_size')));
        $this->assign('new_goods', model('Index')->goods_list('new', C('page_size')));
        $this->assign('hot_goods', model('Index')->goods_list('hot', C('page_size')));
        //首页推荐分类
        $cat_rec = model('Index')->get_recommend_res();
        $this->assign('cat_best', $cat_rec[1]);
        $this->assign('cat_new', $cat_rec[2]);
        $this->assign('cat_hot', $cat_rec[3]);
        // 促销活动
        $this->assign('promotion_info', model('GoodsBase')->get_promotion_info());
        // 团购商品
        $this->assign('group_buy_goods', model('Groupbuy')->group_buy_list(C('page_size'),1,'goods_id','ASC'));
        // 获取分类
        $this->assign('categories', model('CategoryBase')->get_categories_tree());
        // 获取品牌
        $this->assign('brand_list', model('Brand')->get_brands($app = 'brand', C('page_size'), 1));
        $this->display('index.dwt');
    }

    /**
     * ajax获取商品
     */
    public function ajax_goods() {
        if (IS_AJAX) {
            $type = I('get.type');
            $start = $_POST['last'];
            $limit = $_POST['amount'];
            $hot_goods = model('Index')->goods_list($type, $limit, $start);
            $list = array();
            // 热卖商品
            if ($hot_goods) {
                foreach ($hot_goods as $key => $value) {
                    $this->assign('hot_goods', $value);
                    $list [] = array(
                        'single_item' => ECTouch::view()->fetch('library/asynclist_index.lbi')
                    );
                }
            }
            echo json_encode($list);
            exit();
        } else {
            $this->redirect(url('index'));
        }
    }

    /**
     * 通过code获取openID
     */
    public function GetOpenid($c_code)
    {
        $wxinfo = model('Base')->model->table('wechat')
            ->field('id, token, appid, appsecret, oauth_redirecturi, type, oauth_status')
            ->where('default_wx = 1 and status = 1')
            ->find();
        $appid = $wxinfo['appid'];
        $secret = $wxinfo['appsecret'];
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appid . "&secret=" . $secret . "&code=" . $c_code . "&grant_type=authorization_code";
        $result = $this->getData($url);
        $jsondecode = json_decode($result);
        if ($jsondecode != null) {
            if (property_exists($jsondecode, "openid")) {
                return $jsondecode->{"openid"};
            } else {
                return "code is invalid.";
            }
        }
    }

    //获取https的get请求结果
   public function getData($c_url)
    {
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $c_url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    }

}
