<?php $this->load->view('public/header'); ?>
    <div class="main col-sm-9 col-md-10 ">
        <div class="bgf">
            <ol class="breadcrumb">
                <li><a href="#">优惠券管理 </a></li>
                <li class="active"><?php if($data['status']==1):echo '查看';else:echo '编辑';endif;?>优惠券</li>
            </ol>

            <form class="form-horizontal">
            <input type="hidden" value="<?php echo $data['bonus_id'];?>" id="bonus_id">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>优惠券标题</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="请输入优惠券标题" id="bonus_name" value="<?php echo $data['bonus_name'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>金额</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control moneyInput" placeholder="请输入金额" id="amount" value="<?php echo $data['amount'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>有效期(天数)</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="请输入有效期" id="term_days" value="<?php echo $data['term_days'];?>">
                    </div>
                </div>

                 <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>类型</label>
                        <div class="col-sm-9">
                         <?php foreach ($type as $key=>$item) { ?>
                          
                            <label class="radio-inline">
                                <input type="radio" name="bonus_type" value="<?php echo $key ?>" <?php if($data['bonus_type']==$key){ echo "checked"; }?>> <?php echo $item?>
                            </label>
                        <?php } ?>
                          
                        
 
                             
                        </div>
                    </div>
                  <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>发放方式</label>
                        <div class="col-sm-9">
                        <?php foreach ($category as $key=>$item) { ?>
                         <label class="radio-inline">
                                <input type="radio" name="category" value="<?php echo $key ?>" <?php if($data['category']==$key){ echo "checked"; }?>> <?php echo $item?>
                            </label>
                        <?php } ?>
                            
                             
                        </div>
                    </div>

                      <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>是否启用</label>
                        <div class="col-sm-9">
                            <label class="radio-inline">
                                <input type="radio" name="status" value="1"  <?php if($data['status']==1){ echo "checked"; }?>> 是
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="status"  value="0"  <?php if($data['status']==0){ echo "checked"; }?>> 否
                            </label>
                             
                        </div>
                    </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"><span class="text-red">*</span>优惠券备注</label>

                    <div class="col-sm-9">
                        <textarea class="form-control" rows="3" id="description"><?php echo $data['description'];?></textarea>
                    </div>
                </div>
               
                
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-9 ">
                    <?php if($data['status']==1):?>
                        <button class="btn btn-primary" type="button" onclick="history.go(-1)">返回</button>
                    <?php else:?>
                         <button class="btn btn-primary" type="button" id="addSaveBtn">保存</button>
                    <?php endif;?>   
                    </div>
                </div>
            </form>

            <div class="db"></div>
        </div>
    </div>


    <script type="text/javascript" src="<?php echo W_STATIC_URL; ?>js/bonus.js"></script>
<?php $this->load->view("public/footer"); ?>




