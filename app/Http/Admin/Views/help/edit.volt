<form class="layui-form kg-form" method="POST" action="{{ url({'for':'admin.help.update','id':help.id}) }}">

    <fieldset class="layui-elem-field layui-field-title">
        <legend>编辑帮助</legend>
    </fieldset>

    <div class="layui-form-item">
        <label class="layui-form-label">标题</label>
        <div class="layui-input-block">
            <input type="text" name="title" value="{{ help.title }}" class="layui-input" lay-verify="required">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">内容</label>
        <div class="layui-input-block">
            <textarea name="content" class="layui-hide" id="kg-layedit">{{ help.content }}</textarea>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-block">
            <input class="layui-input" type="text" name="priority" value="{{ help.priority }}" lay-verify="number">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">发布</label>
        <div class="layui-input-block">
            <input type="radio" name="published" value="1" title="是" {% if help.published == 1 %}checked{% endif %}>
            <input type="radio" name="published" value="0" title="否" {% if help.published == 0 %}checked{% endif %}>
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

{{ partial('partials/layedit') }}

