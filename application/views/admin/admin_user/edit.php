<h2 class="contentTitle">修改</h2>

<div class="pageContent">
    <form method="post" action="<?php echo __URL__.'/update';?>" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
        <input type="hidden" name="<?php echo $_REQUEST['PK']; ?>" value="<?php echo $DATA[$_REQUEST['PK']] ?>"/>
        <div class="pageFormContent" layoutH="98">

            <div class="unit">
                <label>登录名：</label>
                <input type="text" name="DATA[username]" minlength="3" maxlength="20" class="required alphanumeric required" value="<?php echo $DATA['username'] ?>"/>
                <span class="info">3-20位用于登录的名字，只能是字母，数字和“_”的组合</span>
            </div>
            <div class="unit">
                <label>名：</label>
                <input type="text" name="DATA[lastname]" minlength="0" maxlength="20" class="required" value="<?php echo $DATA['lastname'] ?>"/>
                <span class="info">用户的名</span>
            </div>
            <div class="unit">
                <label>姓：</label>
                <input type="text" name="DATA[firstname]" minlength="0" maxlength="20" value="<?php echo $DATA['firstname'] ?>" />
                <span class="info">用户的姓</span>
            </div>
            <div class="unit">
                <label>密码：</label>
                <input type="password" name="DATA[password]" minlength="4" maxlength="20" class="required" value="<?php echo $DATA['password'] ?>"/>
                <span class="info">4—20位的密码。</span>
            </div>
            <div class="unit">
                <label>状态：</label>
                <select name="DATA[status]">
                    <option value="1">启用</option>
                    <option value="0">禁用</option>
                </select>
                <span class="info">*</span>
            </div>


            <div class="unit">
                <label>其他信息：</label>
                <textarea rows="2" cols="80" name="DATA[extra]" class="textInput"><?php echo $DATA['extra'] ?></textarea>
                <span class="info">描述</span>
            </div>

            <div class="divider"></div>


        </div>

        <div class="formBar">
            <ul>
                <li>
                    <div class="buttonActive">
                        <div class="buttonContent">
                            <button type="submit">提交</button>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="button">
                        <div class="buttonContent">
                            <button type="button" class="close">取消</button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

    </form>
</div>