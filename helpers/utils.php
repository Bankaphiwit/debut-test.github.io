<?php

function layoutHeader($title = "")
{
  ob_start();
  require(BASE_DIR . '/view/layout/header.php');
  echo ob_get_clean();
}


function layoutFooter()
{
  ob_start();
  require(BASE_DIR . '/view/layout/footer.php');
  echo ob_get_clean();
}
