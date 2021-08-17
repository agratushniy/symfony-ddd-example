.. _{{ context.code }}-abc:

Словарь
=======

{% for entity in context.entities %}

:ref:`{{ context.code }}-{{ entity.code }}-detail` - {{ entity.description }}

{% endfor %}
