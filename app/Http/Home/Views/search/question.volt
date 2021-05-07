{% if pager.total_pages > 0 %}
    <div class="search-question-list">
        {% for item in pager.items %}
            {% set owner_url = url({'for':'home.user.show','id':item.owner.id}) %}
            {% set question_url = url({'for':'home.question.show','id':item.id}) %}
            {% set solved_class = item.solved ? 'column solved' : 'column' %}
            <div class="search-question-card article-card question-card">
                <div class="info">
                    <div class="title layui-elip">
                        <a href="{{ question_url }}" target="_blank">{{ item.title }}</a>
                    </div>
                    <div class="summary">{{ item.summary }}</div>
                    <div class="meta">
                        <span class="owner">提问：<a href="{{ owner_url }}">{{ item.owner.name }}</a></span>
                        <span class="view">浏览：{{ item.view_count }}</span>
                        <span class="like">点赞：{{ item.like_count }}</span>
                        <span class="answer">回答：{{ item.answer_count }}</span>
                    </div>
                </div>
            </div>
        {% endfor %}
    </div>
{% else %}
    {{ partial('search/empty') }}
{% endif %}