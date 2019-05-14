<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo realpath($path.'css/minhaTimesNewRoman.css'); ?>">
    <style>
      body
      {
        font-family: "MinhaTimesNewRoman" !important;
        font-size: 18px;
      	margin-top: 0px;
        margin-left: 0px;
        margin-bottom: 0px;
        margin-right: 0px;
      }

      table
      {
        border-collapse:collapse;
        font-size: 15px;
      }
      
      table>tbody>tr>td, table>thead
      {
        border-bottom: 1px solid black;
      }

      table>thead 
      {
        display: table-header-group
      }

      table tr 
      {
        page-break-inside: avoid
      }

      @page
      { 
        margin-top: 0px;
        margin-left: 0px;
        margin-bottom: 0px;
        margin-right: 0px;
      }

      h1,h2,h3,h4,h5,p
      {
        margin-top: 5px;
        margin-left: 0px;
        margin-bottom: 5px;
        margin-right: 0px;
      }

      .hidden
      {
        display:none !important
      }

      .table-striped table>tbody>tr:nth-of-type(odd)
      {
        background-color:#ddd
      }

      .text-center
      {
        text-align:center
      }

      .text-left
      {
        text-align:left
      }

      .pull-right
      {
        padding-right:15px;
        padding-left:0;
        border-right:5px solid #eee;
        border-left:0;
        text-align:right
      }

      .row
      {
        margin-left:-15px;margin-right:-15px
      }
    </style>
  </head>
  <body>
    <div class="block full" style="display: block;">
      <div class="<?=$classe?>">
        <?=$tabela?>
      </div>
    </div>
  </body>
</html>
