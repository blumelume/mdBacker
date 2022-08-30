<?php
namespace mdBacker\lectern\templates;

function displayField($field) {
  ?>
  <div class='field'>
    
    <label for='<?= $field->name ?>'>
      <?= $field->name ?>
      <?php if ($field->required) { ?>
        <span class='required' aria-label='required'>*</span>
      <?php } ?>
    </label>
    
    <?php if ($field->type === 'md') { ?>
      <textarea type='text' name='<?= $field->name ?>'><?= $field->content ?></textarea>
    <?php } else { ?>
      <input type='text' name='<?= $field->name ?>' value='<?= $field->content ?>'></input>
    <?php } ?>

  </div>
  <?php
}

function fetchPageFields( $parentModule ) {

  foreach( $parentModule->fieldList as $f ) {

    $field = $parentModule->$f;
    $fieldContent = $field->content;

    if (is_a($fieldContent, 'mdBacker\cabinet\classes\Module')) {
    ?>

      <fieldset class='field-parent'>
        <legend><?=$fieldContent->name?></legend>
        <?php fetchPageFields($fieldContent); ?>
      </fieldset>
    
    <?php } else {
      displayField( $field );
    }
  }
}
?>

<form class='fields'>

  <p class='disclaimer-required'><span class='required' aria-label='required'>*</span> required fields</p>

  <?php
  fetchPageFields($this->object);
  ?>

</form>