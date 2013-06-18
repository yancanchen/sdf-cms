<form id="pagerForm" method="post" action="<?php echo __URL__;?>">

    <input type="hidden" name="status" value="<?php echo $this->input->get_post('status'); ?>">
    <input type="hidden" name="keywords" value="<?php echo $this->input->get_post('keywords'); ?>" />

    <input type="hidden" name="pageNum" value="<?php echo $this->input->get_post('pageNum');?>" /><!--【必须】value=1可以写死-->
    <input type="hidden" name="numPerPage" value="<?php echo $this->input->get_post('numPerPage');?>" /><!--【可选】每页显示多少条-->
    <input type="hidden" name="orderField" value="<?php echo $this->input->get_post('orderField');?>" /><!--【可选】查询排序-->
    <input type="hidden" name="orderDirection" value="<?php echo $this->input->get_post('orderDirection');?>" /><!--【可选】升序降序-->
</form>


<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="<?php echo __URL__;?>" method="post">
        <div class="searchBar">
            <table class="searchContent">
                <tr>
                    <td>
                        搜索关键字：<input type="text" name="keywords" value="<?php echo $this->input->get_post('keywords'); ?>" />
                    </td>
                    <td>
                        <?php
                        $options = array(
                            ''  => '所有',
                            '1'    => '可用',
                            '0'   => '禁用',
                        );
                        echo form_dropdown('status', $options, $this->input->get_post('status'),'class="combox"');
                        ?>
                    </td>
                    <td>
                        建档日期：<input type="text" name="created" class="date" readonly="true" value="<?php echo $this->input->get_post('created'); ?>" />
                    </td>
                </tr>
            </table>
            <div class="subBar">
                <ul>
                    <li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
                    <li><a class="button" href="demo_page6.html" target="dialog" mask="true" title="查询框"><span>高级检索</span></a></li>
                </ul>
            </div>
        </div>
    </form>
</div>
<div class="pageContent">
<div class="panelBar">
    <ul class="toolBar">
        <li><a class="add" href="<?php echo __URL__.'/add';?>" target="navTab" ><span>添加</span></a></li>
        <li><a class="delete" href="<?php echo __URL__.'/delete';?>/{user_id}" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>
        <li><a class="edit" href="<?php echo __URL__.'/edit';?>/{user_id}" target="navTab"><span>修改</span></a></li>
        <li class="line">line</li>
        <li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li>
    </ul>
</div>

    <table class="list" width="100%" layoutH="138">
        <thead>
        <tr>
            <?php foreach($list_fields as $f): ?>
            <th width="80" class="<?php if($f==$this->input->get_post('orderField'))echo $this->input->get_post('orderDirection'); ?>" orderfield="<?php echo $f; ?>"><?php echo $f; ?></th>
            <?php endforeach; ?>
            <th width="80">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($list as $v): ?>
        <tr target="<?php echo $list_fields[0]; ?>" rel="<?php echo $v[$list_fields[0]] ?>">
            <?php foreach($list_fields as $f): ?>
            <td><?php echo $v[$f]; ?></td>
            <?php endforeach; ?>
            <td>
                <a class="btnDel" href="<?php echo __URL__.'/delete/'.$v[$list_fields[0]];;?>" target="ajaxTodo" title="删除">删除</a>
                <a class="btnEdit" href="<?php echo __URL__.'/edit/'.$v[$list_fields[0]];;?>" target="navTab" title="编辑">编辑</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<div class="panelBar">
    <div class="pages">
        <span>显示</span>
        <?php
        $options = array('20'  => '20','50'=> '50','100'   => '100','200'   => '200',);
        echo form_dropdown('numPerPage', $options, $this->input->get_post('numPerPage'),'class="combox" onchange="navTabPageBreak({numPerPage:this.value})"');
        ?>
        <span>条，共<?php echo intval($this->input->get_post('totalCount'));?>条</span>
    </div>

    <div class="pagination" targetType="navTab" totalCount="<?php echo intval($this->input->get_post('totalCount'));?>" numPerPage="<?php echo intval($this->input->get_post('numPerPage'));?>" pageNumShown="10" currentPage="<?php echo intval($this->input->get_post('pageNum')); ?>"></div>

</div>
</div>