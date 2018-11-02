<?php $this->load->view('public/header'); ?>
<style type="text/css">
    .main .self-info .form-group label{
        width:90px;
    }
    .input-group{
        width: 220px;
        margin-left: 5px;
    }
</style>
    <div class="main col-sm-9 col-md-10 ">
        <div class="bgf">
            <ol class="breadcrumb">
                <li><a href="#">优惠券管理 </a></li>
                <li class="active">已发数量</li>
            </ol>
            <form action="/bonus/uselist" method="post">
            <input type="hidden" name="bonus_id" value="<?php echo $where['bonus_id'] ?>"  >
            <input type="hidden" name="status" value="<?php echo $where['status'] ?>"  >
            <div class="self-info">
                <div class="form-inline">
                    
                <div class="form-group">
                    <label class="" for="keyword">手机号</label>
                    <input type="input" class="form-control"  name="keyword"
                           value="<?php echo $where['mobile'] ?>" placeholder="关键字">
                </div>
                 <div class="form-group">
                        <label for="" class="">劵类型</label>
                            <select class="form-control" name="type" id="type">
                                <option value="">请选择类型</option>
                                <?php foreach ($type as $key=>$item) { ?>
                                    <option
                                        value="<?php echo $key; ?>" <?php if($where['type'] == $key){ echo  "selected" ;}?>><?php echo $item ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <div class="form-group">
                        <label for="" class="">发放类型</label>
                            <select class="form-control" name="category" id="category">
                                <option value="">请选择类型</option>
                                <?php foreach ($category as $key=>$item) { ?>
                                    <option
                                        value="<?php echo $key; ?>" <?php if($where['category'] == $key){ echo  "selected" ;}?>><?php echo $item ?></option>
                                <?php } ?>
                            </select>
                        </div>
                <button class="btn btn-primary"  type="submit">查询</button>
                
                </div>
                <div class="db"></div>
                
                    </div>
                </div>  </form>
                <div class="db"></div>
    <div class="table-responsive " style="white-space: nowrap;">
        <?php if (!empty($data)) { ?>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>用户昵称</th>
                    <th>手机号</th>
                    <th>金额</th>
                    <th>类型</th>
                    <th>有效时间</th>
                    <th>使用时间</th>
                   
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $item) { ?>
                    <tr>
                        
                        <td><?php echo $item['nickname']; ?></td>
                        <td><?php echo $item['mobile']; ?></td>
                        <td><?php echo $item['amount']; ?></td>
                        <td><?php echo $type[$item['bonus_type']] ;?></td>
                        <td><?php echo $item['begin_date'].'-'.$item['end_date']; ?></td>
                        <!-- <td><?php echo $category[$item['category']] ;?></td> -->
                        
                        <td><?php echo $item['use_time']; ?></td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>
            <?php
        } else {
            echo "暂无数据";
        }
        ?>
    </div>
    <div class="text-center">
        <ul class="pagination">
            <?php echo $pagination; ?>
        </ul>
    </div>

            <div class="db"></div>
        </div>
    </div>


<?php $this->load->view("public/footer"); ?>