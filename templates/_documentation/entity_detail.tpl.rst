.. _{{ context.code }}-{{ entity.code }}-detail:

{{ entity.title }}
{% for i in 1..entity.title|length %}={% endfor %}

**FQCN**: :code:`{{ entity.fqcn|raw }}`

**Описание**: {{ entity.description }}

{% if entity.nodes|length > 0 %}
Состав
------

{% for node in entity.nodes %}
 *  :ref:`{{ context.code }}-{{ node.code }}-detail`

{% endfor %}
{% endif %}

{% if entity.mutators|length > 0 %}

Мутаторы
--------

{% for mutator in entity.mutators %}

**{{ mutator.title }}** (:code:`{{ mutator.code }}`)

    {% if mutator.rules|length > 0 %}

Бизнес-правила

    {% for rule in mutator.rules %}

 *  {{ rule.title }} - *{{ rule.description }}*


    {% endfor %}
    {% endif %}

    {% if mutator.events|length > 0 %}

События

    {% for event in mutator.events %}

 *  {{ event.title }} (:code:`{{ event.code }}`)
    {% for subscriber in event.subscribers %}
   *  (:ref:`context-{{ subscriber.contextCode }}-detail`) {{ subscriber.title|raw }} (:code:`{{ subscriber.code }}`)
    {% endfor %}
    {% endfor %}
    {% endif %}

{% endfor %}

{% endif %}