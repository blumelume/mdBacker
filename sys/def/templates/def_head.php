<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title> <?= (isset($this->metaTitle->content)) ? $this->metaTitle->content : $GLOBALS['page']->title->content ?> </title>
  <meta name="description" content="<?= $this->metaDescription->content ?>"/>


  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <!-- User-Scripts -->
  <?php
  if (isset($this->scripts->content)) {
    foreach($this->scripts->content as $script) {
      echo $script;
    }
  }
  ?>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
  <!-- User-Stylesheets -->
  <?php
  if (isset($this->stylesheets->content)) {
    foreach($this->stylesheets->content as $stylesheet) {
      echo $stylesheet;
    }
  }
  ?>
</head>