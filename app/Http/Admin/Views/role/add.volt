<form class="layui-form kg-form" method="POST" action="{{ url({'for':'admin.role.create'}) }}">

    <fieldset class="layui-elem-field layui-field-title">
        <legend>添加角色</legend>
    </fieldset>

    <div class="layui-form-item">
        <label class="layui-form-label">名称</label>
        <div class="layui-input-block">
            <input class="layui-input" type="text" name="name" {% if role.type == 'system' %}readonly{% endif %} lay-verify="required">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">描述</label>
        <div class="layui-input-block">
            <input class="layui-input" type="text" name="summary" {% if role.type == 'system' %}readonly{% endif %} lay-verify="required">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
            <button class="kg-submit layui-btn" lay-submit="true" lay-filter="go">提交</button>
            <button type="button" class="kg-back layui-btn layui-btn-primary">返回</button>
        </div>
    </div>

</form>