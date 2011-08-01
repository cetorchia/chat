<?php

// Gets the previous message file date
function prevFileDate($y = null,$w = null)
{
  $y = isset($y) ? $y : gmdate('Y');
  $w = isset($w) ? $w : gmdate('W');

  // Try to decrease week
  $w = $w - 1;
  if($w<1) {
    $y = $y - 1;
    $w = 52;
  }

  return("y=$y&w=$w");
}

// Gets the next message file date
function nextFileDate($y = null,$w = null)
{
  $y = isset($y) ? $y : gmdate('Y');
  $w = isset($w) ? $w : gmdate('W');

  // Try to increase week
  $w = $w + 1;
  if($w>52) {
    $y = $y + 1;
    $w = 1;
  }

  return("y=$y&w=$w");
}

