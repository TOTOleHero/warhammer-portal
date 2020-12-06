<div class="list-group">
{% for <?= $entity_twig_var_singular ?> in <?= $entity_twig_var_plural ?> %}
  <a href="{{ path('<?= $entity_twig_var_singular ?>_show', {'id': <?= $entity_twig_var_singular ?>.id}) }}" class="list-group-item list-group-item-action flex-column align-items-start active">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">{{ <?= $entity_twig_var_singular ?>.name }}</h5>
      <small>3 days ago</small>
    </div>
    <p class="mb-1">Description</p>
    <small><?= $entity_class_name ?> : </small>
  </a>

{% else %}
 <a href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">No data</h5>
      <small></small>
    </div>
    <p class="mb-1">No data</p>
    <small></small>
  </a>
 {% endfor %}

</div>
