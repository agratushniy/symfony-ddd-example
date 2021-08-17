DDDocs
======

.. toctree::
   :maxdepth: 2
   :caption: Оглавление

{% for context in contexts %}
   context/{{ context.code }}/index.rst
{% endfor %}

