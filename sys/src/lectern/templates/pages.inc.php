<?php
namespace mdBacker\lectern\templates;

function displayField($field) {
  ?>
  <div class='field <?php echo ($field->type === 'md') ? 'text' : ''; ?>'>
    
    <label for='<?= $field->name ?>'>
      <?= $field->name ?><?php if ($field->required) { ?><div class='required' aria-label='required'></div><?php } ?>
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
        <legend>
          <?=$fieldContent->name?><?php if ($field->required) { ?><div class='required' aria-label='required'></div><?php } ?>
        </legend>
        <?php fetchPageFields($fieldContent); ?>
      </fieldset>
    
    <?php } else {
      displayField( $field );
    }
  }
}
?>

<form class='fields'>

  <span class='w3'>
    <div class='disclaimer-required'>required fields<div class='required' aria-label='required'></div></div>
    
    <?php
    fetchPageFields($this->object);
    ?>
  </span>

  <fieldset class='buttons'>
    <button type='submit' aria-label='save'>save</button>
  </fieldset>

</form>