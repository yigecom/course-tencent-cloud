{% if register_with_phone == 1 %}
    <form class="layui-form account-form" method="POST" action="{{ action_url }}">
        <div class="layui-form-item">
            <label class="layui-icon layui-icon-cellphone"></label>
            <input id="cv-phone" class="layui-input" type="text" name="phone" autocomplete="off" placeholder="手机" lay-verify="phone">
        </div>
        <div class="layui-form-item">
            <label class="layui-icon layui-icon-password"></label>
            <input class="layui-input" type="password" name="password" autocomplete="off" placeholder="密码（字母数字特殊字符6-16位）" lay-verify="required">
        </div>
        <div class="layui-form-item">
            <div class="layui-input-inline verify-input-inline">
                <label class="layui-icon layui-icon-vercode"></label>
                <input class="layui-input" type="text" name="verify_code" placeholder="验证码" lay-verify="required">
            </div>
            <div class="layui-input-inline verify-btn-inline">
                <button id="cv-phone-emit-btn" class="layui-btn layui-btn-disabled" type="button" disabled="disabled">获取验证码</button>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button id="cv-phone-submit-btn" class="layui-btn layui-btn-fluid layui-btn-disabled" disabled="disabled" lay-submit="true" lay-filter="go">注册帐号</button>
                <input type="hidden" name="return_url" value="{{ return_url }}">
                <input id="cv-phone-captcha-enabled" type="hidden" value="{{ captcha.enabled }}">
                <input id="cv-phone-captcha-appId" type="hidden" value="{{ captcha.app_id }}">
                <input id="cv-phone-captcha-ticket" type="hidden" name="captcha[ticket]">
                <input id="cv-phone-captcha-rand" type="hidden" name="captcha[rand]">
            </div>
        </div>
    </form>
{% else %}
    <div class="register-close-tips">
        <i class="layui-icon layui-icon-tips"></i> 手机注册已关闭
    </div>
{% endif %}