<div class="list-group">
	<a class="list-group-item disabled"><span class="glyphicon glyphicon-th-large"></span> 功能</a>
	{if $type == 2}
	<a class="list-group-item {if $action == 'mass_message' || $action == 'mass_list'}active{/if}" href="{url('wechat/mass_message')}">群发消息</a>
	{/if}
	<a class="list-group-item {if $action == 'reply_subscribe' || $action == 'reply_msg' || $action == 'reply_keywords'}active{/if}" href="{url('wechat/reply_subscribe')}">自动回复</a>
	<a class="list-group-item {if $action == 'menu_list'}active{/if}" href="{url('wechat/menu_list')}">自定义菜单</a>
	
	<a class="list-group-item disabled"><span class="glyphicon glyphicon-inbox"></span> 管理</a>
	{if $type == 2}
	<a class="list-group-item {if $action == 'subscribe_list'}active{/if}" href="{url('wechat/subscribe_list')}">用户管理</a>
	{/if}
	<a class="list-group-item {if $action == 'article' || $action == 'picture' || $action == 'voice' || $action == 'video'}active{/if}" href="{url('wechat/article')}">素材管理</a>
	{if $type == 2}
	<a class="list-group-item {if $action == 'qrcode_list'}active{/if}" href="{url('wechat/qrcode_list')}">渠道二维码<br></a>
	{/if}
	<a class="list-group-item disabled"><span class="glyphicon glyphicon-plus"></span> 扩展</a>
	<a class="list-group-item {if $controller == 'Extend'}active{/if}" href="{url('extend/index')}">功能扩展</a>
    
    {if $type == 2}
	<a class="list-group-item disabled"><span class="glyphicon glyphicon-cog"></span> 其他</a>
	<a class="list-group-item {if $action == 'remind'}active{/if}" href="{url('wechat/remind')}">提醒设置</a>
	<a class="list-group-item {if $action == 'customer_service'}active{/if}" href="{url('wechat/customer_service')}">多客服设置</a>
	<a class="list-group-item {if $action == 'share_list'}active{/if}" href="{url('wechat/share_list')}">扫码引荐</a>
	{/if}
</div>