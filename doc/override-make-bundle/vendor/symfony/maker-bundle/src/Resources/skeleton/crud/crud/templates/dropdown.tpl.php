
<div class="dropdown-menu">
{% for <?= $entity_twig_var_singular ?> in <?= $entity_twig_var_plural ?> %}
          <a class="dropdown-item" href="{{ path('<?= $route_name ?>_show', {'id': <?= $entity_twig_var_singular ?>.id}) }}">{{ <?= $entity_twig_var_singular ?>.name }}</a>
{#          <div class="dropdown-divider"></div> 
          <a class="dropdown-item" href="#">Separated link</a>
#}
{% else %}
    <a class="dropdown-item" href="#">No data</a>
{% endfor %}          
</div>