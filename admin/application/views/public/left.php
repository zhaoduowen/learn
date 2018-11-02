<?php 
$CI = & get_instance();
$CI->load->model('m_admin');

$tree = array(
	array('name'=>'场馆管理','controller'=>'site','href_url'=>'/site/index','children'=>array()),
	array('name'=>'课程管理','controller'=>'lesson','href_url'=>'/lesson/index','children'=>array()),
	array('name'=>'精练计划','controller'=>'plan','href_url'=>'/plan/index','children'=>array()),
    array('name'=>'老师管理','controller'=>'teacher','href_url'=>'/teacher/index','children'=>array()),
	array('name'=>'固定排课','controller'=>'course','href_url'=>'/course/index','children'=>array()),
	array('name'=>'自选排课','controller'=>'teacherCourse','href_url'=>'/teacherCourse/index','children'=>array()),
	array('name'=>'用户管理','controller'=>'webuser','href_url'=>'/webuser/index','children'=>array()),
	array('name'=>'订单管理','controller'=>'order','href_url'=>'/order/index','children'=>array(
		array('name'=>'约课订单','controller'=>'order','href_url'=>'/order/index'),
		array('name'=>'计划订单','controller'=>'orderPlan','href_url'=>'/orderPlan/index'),
		)),
	array('name'=>'营销管理','controller'=>'yingxiao','href_url'=>'','children'=>array(
		array('name'=>'优惠券管理','controller'=>'bonus','href_url'=>'/bonus/index'),
		array('name'=>'广告管理','controller'=>'ad','href_url'=>'/ad/index'),
		array('name'=>'幸运大转盘','controller'=>'activity','href_url'=>'/activity/index'),
		array('name'=>'关于我们','controller'=>'infomation','href_url'=>'/infomation/listAction')
		)),
  
	);


$uriParam = parse_url($_SERVER['REQUEST_URI']);
// $select = $uriParam['path'];

$select = $this->uri->segment(1);
// if ($select=='bonus'||$select=='ad'||$select=='infomation') {
// 	$select = 'yingxiao';
// }



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
