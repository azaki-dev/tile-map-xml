<!DOCTYPE html>
<html>
  <head>
    <link rel="shortcut icon" href="images/map.png" />
    <meta http-equiv="Content-Type" content="text/html; charset-utf-8" />
    <title> Tile Map Creator </title>
    <script src="lib/jquery.min.js"></script>
    <script src="lib/yahoo-yui.js"></script>
    
    <!-- Source File --> 
    <script src="lib/yahoo-json.js"></script>
  
    <style>
      body{
        background-color: #D89E79;
      }
      div.jquery-drag-to-select{
        background: #def;
        display:none; 
        opacity: .3; 
        filter:alpha(opacity=30); 
        z-index: 10; 
        border: 1px solid #369;
      } 
      div.jquery-drag-to-select.active{ 
        display:block;
      } 
      div.selected{ 
        background:#900;
        border:#F00 thin solid !important;
      }
      .block{
        background-image: url(tile/block.png);
        background-position: -200px 0px;
        background-size:cover;
      }
      .build{
        background-image: url(tile/build.png);
        background-position: -200px 0px;
        background-size:cover;
      }
      .build2{
        background-image: url(tile/build2.png);
        background-position: -200px 0px;
      }
      .darkgrass{
        background-image: url(tile/darkgrass.png);
        background-position: -200px 0px;
      }
      .grass{
        background-image: url(tile/grass.png);
        background-position: -200px 0px;
      }
      .houses{
        background-image: url(tile/houses.png);
        background-position: -200px 0px;
      } 
      .rock{
        background-image: url(tile/rock.png);
        background-position: -200px 0px;
      } 
      .sand{
        background-image: url(tile/sand.png);
        background-position: -200px 0px;
      } 
      .tree{
        background-image: url(tile/tree.png);
        background-position: -200px 0px;
      } 
      .wall{
        background-image: url(tile/wall.png);
        background-position: -200px 0px;
      } 
      .water{
        background-image: url(tile/water.png);
        background-position: -200px 0px;
      } 
    </style>

  <script>
      function change_tile(x){
        $('#js_tile_hold').attr('class',x);
      }

      function place_tile(){
        $(event.target).attr('class', $('#js_tile_hold').attr('class'));
      }

      function toggle_grid(){
          if($('.map_box div:first').css("margin") != "0px"){
            $.each($('.map_box > div'), function(){
              $(this).css("border","")
              $(this).css("margin", "0px")
            });
          }
          else{
            $.each($('.map_box > div'), function(){
              $(this).css("border","1px solid #000")
              $(this).css("margin","1px")
            });
          }
        }
          
      function make_solids(){
        $('.mode').text('Solidize');
        $.each($('.map_box > div'), function(){
          $(this).attr('onClick', 'toggle_solid();');
        });
      }

      function toggle_solid(){
        if($(event.target).attr('class') == 'tile-solid'){
          $(event.target).remove();
        }
        else
        {
          $(event.target).append('<div class="tile-solid"></div>');
        }
      }

      function tile_placer(){
        $('.mode').text('Tile Placer');
        $.each($('.map_box > div'), function(){
          $(this).attr('onClick', 'place_tile();');
        });
        $.each($('.tile-solid'), function(){
        });
      }

      function save_map(){
        var tile = new Array();
        var solid;
        $.each($('.map_box > div:not(.jquery-drag-to-select)'), function(i, x){
          solid=0;
          if($(this).children('.tile-solid').length>0){
            solid=1;
          }
          tile[i] = {'class' : $(this).attr('class'),'solid_state' : solid};
        });
        tile = YAHOO.lang.JSON.stringify(tile);
        
        $.ajax({
          type: 'post',
          cache: false,
          url: 'exportxml.php',
          data: tile,
          processData: false,
          contentType: 'application/json',
        });
        alert('Mapa Salvo');
        }

  </script>

</head>
<body>
  <center>
    <h1>Map Creator</h1>
    <div style="width:549px; height:549; overflow:auto;" class="map_box">
      <?php
        for($x=1; $x<=100; $x++){
          echo '<div id="tile" onmousedown="place_tile();" style="width:50px; height:50px; border:black solid thin; float:left; margin:1px;"></div>';
        }
      ?>
    </div>
    <div>
      <select onchange="change_tile($(this).val());">
          <option value="grass">Grass</option>
          <option value="tree">Tree</option>
          <option value="darkgrass">Dark Grass</option>
          <option value="water">Water</option>
          <option value="rock">Rock</option>
          <option value="sand">Sand</option>
          <option value="build">Building</option>
          <option value="build2">Building 2</option>
          <option value="houses">Houses</option>
          <option value="wall">Wall</option>
          <option value="block">Block</option>
      </select>
      <p>
        <div id="js_tile_hold" style="width:50px; height:50px;" class="grass"></div>
      </p>
      <p>
        Mode: <span class="mode"> Tile Placer </span>
      </p>
      <input type="button" onclick="tile_placer();" value="Tile Placer"/>
      <input onclick="make_solids();" type="button"  value="Change Solid Tiles"/>
      <input onclick="toggle_grid();" type="button" name="toggle_grid" value="Toggle Grid"/>
      <input onclick="save_map();" type="button" value="Salvar"/>
    </div>
  </center>
</body>
</html>