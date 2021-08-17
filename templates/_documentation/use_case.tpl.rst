.. _{{ context.code }}-scenarios:

Сценарии использования
======================

Каждый сценарий представлен в виде отдельной команды, которая запускает соответствующий хэндлер.

    Параметры - список скаляров, которые необходимо передать в команду.

    Затрагиваемые сущности - список доменных сущностей (Агрегатов), над которыми производятся операции в рамках сценария.


{% for useCase in context.useCases %}

**{{ useCase.title }}** (:code:`{{ useCase.code }}`)

    {% if useCase.parameters|length > 0 %}
Параметры
        {% for parameter in useCase.parameters %}
 *  {{ parameter.title }}  (:code:`{{ parameter.code }}`)

        {% endfor %}
    {% endif %}

    {% if useCase.entities|length > 0 %}
Затрагивыемые сущности
        {% for entity in useCase.entities %}
 *  :ref:`{{ entity.code }}-detail`

        {% endfor %}
    {% endif %}

{% endfor %}
