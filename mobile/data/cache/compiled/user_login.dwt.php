<?php echo $this->fetch('library/user_header.lbi'); ?>
<div class="login_content top_menu_m50">
  <form name="formLogin" id="login_from" action="<?php echo url('user/login');?>" method="post" class="validforms">
    <div class="loginBox mb clearfix">
      <ul class="tab clearfix">
        <li class="on">会员登录</li>
        <!--    <li class="ti">非会员登录</li> -->
      </ul>
      <div class="login tab-on">
        <dl>
          <dt><?php echo $this->_var['lang']['username']; ?>:</dt>
          <dd>
            <input placeholder="<?php echo $this->_var['lang']['username']; ?>/<?php echo $this->_var['lang']['mobile']; ?>/<?php echo $this->_var['lang']['email']; ?>" name="username" id="username" datatype="*" type="text" class="input-txt w158">
          </dd>
        </dl>
        <dl>
          <dt><?php echo $this->_var['lang']['label_password']; ?>:</dt>
          <dd>
            <input placeholder="<?php echo $this->_var['lang']['label_password']; ?>"  name="password" datatype="*6-16" type="password" class="input-txt w158">
          </dd>
        </dl>

        <?php if ($this->_var['enabled_captcha']): ?>
        <dl>
          <dt><?php echo $this->_var['lang']['comment_captcha']; ?>:</dt>
          <dd>
            <input name="captcha" type="text" class="input-txt w38" placeholder="<?php echo $this->_var['lang']['comment_captcha']; ?>">
            <img src="<?php echo url('Public/captcha', array('rand'=>$this->_var['rand']));?>" alt="captcha" class="img-yzm" onClick="this.src='<?php echo url('public/captcha', array('t'=>'Math.random()'));?>'" /> </dd>
        </dl>
        <?php endif; ?>
        
        <dl class="mb">
          <dd>
            <p>
              <label>
                <input type="checkbox" value="1" name="remember" id="remember">
                <span><?php echo $this->_var['lang']['remember']; ?></span></label>
              <a href="<?php echo url('user/get_password_phone');?>" id="forget-password" class="blue_link"><?php echo $this->_var['lang']['forgot_password']; ?></a> </p><?php if ($this->_var['anonymous_buy'] == 1 && $this->_var['step'] == 'flow'): ?>
      <a href="<?php echo url('flow/consignee',array('direct_shopping'=>1));?>" style="float:right;"><?php echo $this->_var['lang']['direct_shopping']; ?></a>
      <?php endif; ?>
          </dd>
        </dl>
        <input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
        <a href="javascript:$('#login_from').submit();" id="loginButton" class="red mb login-btn"><?php echo $this->_var['lang']['now_landing']; ?></a> <a href="<?php echo url('user/register');?>" class="blue_link reg-link" style="cursor: pointer;">还不是会员？立即注册加入。</a> </div>
    </div>

  </form>


 
  <div class="clearfix ect-padding-lr ect-margin-tb user-hezuo"><h5><?php echo $this->_var['lang']['third_login']; ?></h5>
    <p> <a href="<?php echo url('user/third_login',array('type'=>'qq'));?>"><img src="__TPL__/images/qq.png"></a> <a href="<?php echo url('user/third_login',array('type'=>'sina'));?>"><img src="__TPL__/images/weibo.png"></a> </p>
  </div>
</div>
<?php echo $this->fetch('library/search.lbi'); ?> <?php echo $this->fetch('library/page_footer.lbi'); ?>
</body></html>