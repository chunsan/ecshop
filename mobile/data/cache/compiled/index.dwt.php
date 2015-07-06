<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="con">
  <header class="ect-header"> <a href="#" id="msgButton" class="news">消息</a>
    <form action="<?php echo url('category/index');?><?php if ($this->_var['id']): ?>&id=<?php echo $this->_var['id']; ?><?php endif; ?>"  method="post" id="searchForm" name="searchForm">
      <div class="search">
        <input name="keywords" type="search" placeholder="<?php echo $this->_var['lang']['no_keywords']; ?>" id="keywordBox2">
        <button type="submit" value="<?php echo $this->_var['lang']['search']; ?>" onclick="return check('keywordBox2')">搜索</button>
      </div>
    </form>
  </header>
  <div class="clear" style="height:50px;"></div>
  
  <div id="focus" class="focus ect-margin-tb">
    <div class="hd">
      <ul>
      </ul>
    </div>
    <div class="bd"><?php 
$k = array (
  'name' => 'ads',
  'id' => '1',
  'num' => '3',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></div>
  </div>
  
  
  <nav class="container-fluid">
    <ul class="row ect-row-nav">
      <?php $_from = $this->_var['navigator']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');if (count($_from)):
    foreach ($_from AS $this->_var['nav']):
?> 
      <a href="<?php echo $this->_var['nav']['url']; ?>">
      <li class="col-sm-3 col-xs-3"><i class="khfw_ico"><img src="<?php echo $this->_var['nav']['pic']; ?>" ></i>
        <p class="text-center"><?php echo $this->_var['nav']['name']; ?></p>
      </li>
      </a> 
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
  </nav>
  <div class="box type">
    <div class="box-hd">
      <h2>分类推荐</h2>
    </div>
    <?php if ($this->_var['cat_best']): ?>
    <div class="box-bd clearfix">
      <?php $_from = $this->_var['cat_best']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat_best');if (count($_from)):
    foreach ($_from AS $this->_var['cat_best']):
?> 
          <dl class="dl-horizontal clearfix">
            <dt><a href="<?php echo $this->_var['cat_best']['url']; ?>"><img src="<?php echo $this->_var['cat_best']['cat_image']; ?>" class="responsive" style="height:5em"></a></dt>
            <dd>
              <h2><a href="<?php echo $this->_var['cat_best']['url']; ?>" style="color:#000000"><?php echo $this->_var['cat_best']['cat_name']; ?></a></h2>
              <?php if ($this->_var['cat_best']['child_id']): ?>
              <p>
              <?php $_from = $this->_var['cat_best']['child_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'rec_cat');$this->_foreach['f'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f']['total'] > 0):
    foreach ($_from AS $this->_var['rec_cat']):
        $this->_foreach['f']['iteration']++;
?>
              <?php if ($this->_foreach['f']['iteration'] < 2): ?>
              <a href="<?php echo $this->_var['rec_cat']['url']; ?>" style="color:#a2a2a2"><?php echo htmlspecialchars($this->_var['rec_cat']['name']); ?></a> | 
              <?php endif; ?>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              </p>
              <?php endif; ?>
            </dd>
          </dl>
     <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
    <?php endif; ?>
  </div>
  <div class="box" style="">
    <div class="box-hd">
      <h2>限时抢购</h2>
    </div>
    <div class="box-bd"><?php 
$k = array (
  'name' => 'ads',
  'id' => '2',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?> </div>
  </div>
  <div class="box" style="">
    <div class="box-hd">
      <h2>新品上市</h2>
    </div>
    <div class="box-bd"><?php 
$k = array (
  'name' => 'ads',
  'id' => '3',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?> </div>
  </div>

    <div class="box" style="">
    <div class="box-hd">
      <h2>精品推荐</h2>
    </div>
    <div class="box-bd"><?php 
$k = array (
  'name' => 'ads',
  'id' => '4',
  'num' => '1',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?> </div>
  </div>

  <?php echo $this->fetch('library/recommend_hot.lbi'); ?>
  <footer>
    <nav class="ect-nav"><?php echo $this->fetch('library/page_menu.lbi'); ?></nav>
  </footer>
  <div style="padding-bottom:4.2em;"></div>
</div>
<?php echo $this->fetch('library/search.lbi'); ?> 
<?php echo $this->fetch('library/page_footer.lbi'); ?> 
<script type="text/javascript">
get_asynclist("<?php echo url('index/ajax_goods', array('type'=>'hot'));?>" , '__TPL__/images/loader.gif');
</script>
</body>
</html>