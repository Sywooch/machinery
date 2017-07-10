<?php 
use common\widgets\Adminmenu\AdminmenuWidget;
$this->params['breadcrumbs'][] = ['label' => 'Admin Panel'];

 ?>
<div class="container">
	<div class="row">
		<div class="col-md-3 sidebar sidebar-account">
			<?php echo AdminmenuWidget::widget() ?>
		</div> <!-- .sidebar-account -->
		<div class="col-md-9">
			<div class="account-container">
				<ul class="account-menu-tab flexbox just-between">
					<li class="item-menu item-menu-1 _has-title"><span class="_title .h1">Admin Panel</span></li>
					<li class="item-menu item-menu-2 _has-link"><a href="#"><span><span class="_count">6</span><span class="_text">New messages</span></span></a></li>
					<li class="item-menu item-menu-3 _has-link"><a href="#"><span><span class="_count">54</span><span class="_text">Listing created</span></span></a></li>
					<li class="item-menu item-menu-4 _has-link"><a href="#"><span><span class="_count">2</span><span class="_text">Orders made</span></span></a></li>
				</ul>
				<div class="cf">
					<div class="col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading _header">Recently viewed</div>
							<div class="_list panel-body">
								<ul>
									<li><a href="#">Далеко-далеко за.</a></li>
									<li><a href="#">Алфавит, великий.</a></li>
									<li><a href="#">Снова, осталось.</a></li>
									<li><a href="#">Образ, назад!</a></li>
									<li><a href="#">Свое, свою.</a></li>
									<li><a href="#">Все, имени!</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading _header">My favorite listing</div>
							<div class="_list panel-body">
								<ul>
									<li><a href="#">Далеко-далеко за.</a></li>
									<li><a href="#">Запятых, предложения.</a></li>
									<li><a href="#">Пунктуация, вопрос.</a></li>
									<li><a href="#">Продолжил, речью.</a></li>
									<li><a href="#">Мир, страну!</a></li>
									<li><a href="#">Всемогущая, единственное!</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>