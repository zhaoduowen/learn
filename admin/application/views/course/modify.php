<?php $this->load->view('public/header'); ?>
    <div class="main col-sm-9 col-md-10 ">
        <div class="bgf">
            <ol class="breadcrumb">
                <li><a href="#">固定排课 </a></li>
                <li class="active">编辑排课</li>
            </ol>

            <form class="form-horizontal">
            <input type="hidden" value="<?php echo $data['course_id']?>" id="course_id">
                <div class="form-group">
                        <label for="inputPush2" class="col-sm-2 control-label"><span class="text-red">*</span>日期</label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control date-push" id="course_date"  value="<?php echo $data['course_date']?>">
                        </div>
                    </div>
                 <div class="db"></div>

                   <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>场地</label>
                        <div class="col-sm-9">
                        <select class="form-control" id="site_id" >
                            <option value="">请选择</option>
                            <?php foreach ($site as $key => $value) {?>
                                <option value="<?php echo $value['site_id'];?>" <?php if($value['site_id']===$data['site_id']) echo "selected"; ?>><?php echo $value['site_name'];?></option>
                            <?php }?>
                        </select>
                        </div>
                    </div>

                <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>教室</label>
                        <div class="col-sm-9">
                        <select class="form-control" id="classroom_id" >
                         <option value="">请选择</option>
                            <?php foreach ($classroom as $key => $value) {?>
                                <option value="<?php echo $value['classroom_id'];?>" <?php if($value['classroom_id']===$data['classroom_id']) echo "selected"; ?>><?php echo $value['classroom_name'];?></option>
                            <?php }?>
                        </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>时间区域</label>
                        <div class="col-sm-9">
                        <select class="form-control" id="timetable_id" >
                         <option value="">请选择</option>
                            <?php foreach ($timetable as $key => $value) {?>
                                <option value="<?php echo $value['timetable_id'];?>" <?php if($value['timetable_id']===$data['timetable_id']) echo "selected"; ?>><?php echo $value['begin_time'].'-'.$value['end_time'];?></option>
                            <?php }?>
                        </select>
                        </div>
                    </div>
<div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>选择老师</label>
                        <div class="col-sm-9">
                        <select class="form-control" id="teacher_id" >
                         <option value="">请选择</option>
                            <?php foreach ($teacher as $key => $value) {?>
                                <option value="<?php echo $value['teacher_id'];?>" <?php if($value['teacher_id']===$data['teacher_id']) echo "selected"; ?>><?php echo $value['teacher_name'];?></option>
                            <?php }?>
                        </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>选择课程</label>
                        <div class="col-sm-9">
                        <select class="form-control" id="lesson_id" >
                         <option value="">请选择</option>
                            <?php foreach ($lesson as $key => $value) {?>
                                <option value="<?php echo $value['lesson_id'];?>" <?php if($value['lesson_id']===$data['lesson_id']) echo "selected"; ?>><?php echo $value['lesson_name'];?></option>
                            <?php }?>
                        </select>
                        </div>
                    </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>课程价格</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control"   id="lesson_price"  value="<?php echo $data['lesson_price']?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>场地人数</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="classroom_people_num"  value="<?php echo $data['classroom_people_num']?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-9 ">
                        <button class="btn btn-primary" type="button" id="addSaveBtn">保存</button>
                    </div>
                </div>
            </form>

            <div class="db"></div>
        </div>
    </div>

<script type="text/javascript">
 var referURL = "<?php echo $referUrl?$referUrl:'/course/index' ?>"

</script>
    <script type="text/javascript" src="<?php echo W_STATIC_URL; ?>js/course.js"></script>
<?php $this->load->view("public/footer"); ?>


