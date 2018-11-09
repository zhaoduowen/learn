<?php 
$CI = & get_instance();
$CI->load->model('m_admin');

$tree = array(
	array('name'=>'首页设置管理','controller'=>'sethome','href_url'=>'/sethome/index','children'=>array(
			array('name'=>'品牌专访','controller'=>'sethome','href_url'=>'/sethome/brand_index'),
			array('name'=>'广告管理','controller'=>'ad','href_url'=>'/ad/index'),
			
			)),
	array('name'=>'广告管理','controller'=>'ad','href_url'=>'/ad/index','children'=>array()),
	array('name'=>'分类管理','controller'=>'category','href_url'=>'/category/index','children'=>array()),
	array('name'=>'品牌管理','controller'=>'brand','href_url'=>'/brand/index','children'=>array()),
    array('name'=>'文章管理','controller'=>'infomation','href_url'=>'/infomation/index','children'=>array()),
	array('name'=>'活动管理','controller'=>'news','href_url'=>'/news/index','children'=>array()),
	array('name'=>'评论管理','controller'=>'comment','href_url'=>'/comment/index','children'=>array()),
	
	array('name'=>'用户管理','controller'=>'webuser','href_url'=>'/webuser/index','children'=>array()),
	
	array('name'=>'后台权限管理','controller'=>'user','href_url'=>'/user/index','children'=>array()),
);
	


$uriParam = parse_url($_SERVER['REQUEST_URI']);


$select = $this->uri->segment(1);




?>

<div class="slide-bar">
	<div class="logo"><img src="<?php echo W_STATIC_URL; ?>images/logo.png"></div>
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	<?php
        if (isset($tree) && !empty($tree)) {
            foreach ($tree as $key => $value) {?>
		<div class="panel">
			<div class="panel-heading" role="tab" >
			  <h4 class="panel-title">
			   <?php if(!empty($value['children'])){?>
			    <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo 'collapse'.$key;?>" aria-expanded="true" aria-controls="collapseOne" class="collapsed">
			      <?php echo $value['name']; ?> 
			     
			        <span class="pull-right glyphicon glyphicon-menu-down" aria-hidden="true"></span>
			      
			    </a>
			    <?php }else{?>	
			    <a  href="<?php echo site_url($value['href_url']);?>"  <?php if($value['controller']!=$select){?>class="collapsed" <?php }?>>
			      <?php echo $value['name']; ?> 
			      
			    </a>
			    <?php }?>
			  </h4>
			</div>
			 <?php if (isset($value['children']) && !empty($value['children'])) { ?>
			<div id="<?php echo 'collapse'.$key;?>" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
			  <div class="panel-body">
			   <?php foreach ($value['children'] as $cv) {?>
			    <a <?php if($cv['controller']==$select){?>class="active" <?php }?> href="<?php echo site_url($cv['href_url']);?>"><?php echo $cv['name']; ?></a>
			   <?php }?> 
			  
			    
			  </div>
			</div>
			<?php }?> 
		</div>


		<?php }?> 
		<?php }?> 
	   	
		

	</div>
</div>

<script>
( function (window , $ ){
	var $elem = $('#accordion a.active').closest('.panel-collapse' );
	$elem.addClass('in');
	$elem.siblings( '.panel-heading' ).find( 'a.collapsed' ).removeClass('collapsed');
})(window , jQuery )
	
</script>
