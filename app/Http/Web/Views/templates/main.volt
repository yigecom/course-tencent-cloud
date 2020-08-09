<!DOCTYPE html>
<html lang="zh-CN-Hans">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="{{ seo.getKeywords() }}">
    <meta name="description" content="{{ seo.getDescription() }}">
    <meta name="csrf-token" content="{{ csrfToken.getToken() }}">
    <title>{{ seo.getTitle() }}</title>
    {{ icon_link('favicon.ico') }}
    {{ css_link('lib/layui/css/layui.css') }}
    {{ css_link('web/css/common.css') }}
    {% block link_css %}{% endblock %}
    {% block inline_css %}{% endblock %}
</head>
<body class="main">
<div id="header">
    {{ partial('partials/header') }}
</div>
<div id="main" class="layui-main">
    {% block content %}{% endblock %}
</div>
<div id="footer">
    {{ partial('partials/footer') }}
</div>

{{ partial('partials/js_global_vars') }}
{{ js_include('lib/layui/layui.js') }}
{{ js_include('web/js/common.js') }}

{% if router.getActionName() != 'im' %}
    {{ js_include('web/js/fixbar.js') }}
{% endif %}

{% block include_js %}{% endblock %}
{% block inline_js %}{% endblock %}

{% if settings.analytics %}
    {{ settings.analytics }}
{% endif %}

</body>
</html>