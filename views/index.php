<?php
require_once 'core/init.php';

?>

<!doctype html>
<html>
<head>
<base href="/">
<meta charset="utf-8">
<title>DELIVERY METHODS</title>
<link rel="stylesheet" type="text/css" href="css.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<script type="text/javascript"
    src="http://code.jquery.com/jquery-1.10.1.min.js"></script>

</head>
<script>

	$(document).ready(function(){
/* slide div with show ranges data : */
	 $("#show,#add_ranges").click(function(){
		$("#input_range").slideToggle("slow").html();
	 });
/* slide div with delivery data :   */ 
	 $("#click").click(function(){
		$("#for_hidden").slideToggle("slow").html();
	 });
	 
	});


</script>

<body>
<div id="wrap">
<a name="top"></a>
	<header>
   
<div id="nav">
  <ul>
 <li><a href="Site/Index"><i class="fa fa-header" aria-hidden="true"></i>ome</a></li>
 <li><a href="Site/About"><i class="fa fa-home"></i> about</a></li>
 <li><a href="Site/Blog"><i class="fa fa-newspaper-o"></i> blog</a></li>
 
 </ul>
 </div>
 </header><!--kraj header-->
 
 <!-- pocetak glavne forme za delivery -->
 
 	<form action="index.php" method="GET">
 <div id="front">
 
<!-- pocetak -->

<div id="table">

 <!--start input forma -->
 <div class="row">
 <p>Delivery Method 0</p>
<input type="text" name="method0" placeholder="<?php echo $data->name; ?>">$
 </div>
 
  <div class="row">
 <p>Delivery Method 1</p>
<div id="show" tabindex="1">Show Ranges</div>
 </div>
 
 <?php
 // kod koji regulise hidden content:
 if(isset($_GET["new"]) or isset($_GET["drop"])){
//upotreba session kako bi se regulisao stalni prikaz delivery data u postupu unosa podataka sa Add new:
@$_SESSION["new"]=$_GET["new"];
 @$_SESSION["drop"]=$_GET["drop"];
 }else{session_destroy();}
 
 if(isset($_SESSION["drop"]) or isset($_SESSION["new"])){
	  echo "<div class='row' style='display:inline_block' id='input_range' >";
 }else{echo "<div class='row' style='display:none' id='input_range'>";}
 foreach($data_range as $range){
	 echo "<form action='index.php' method='GET'>
			<p>From</p>
			<input type='text' name='from' placeholder='".$range['price_from']."'>$
			<p>to</p>
			<input type='text' name='to' placeholder='".$range['price_to']."'>$
			<input type='text' name='price' placeholder='".$range['price']."'>$
			<input type='submit' class='new' name ='new' value='Add new'>
			<input type='submit' class='new' name='drop' value='Delete'>
			<input type='hidden' name='mark' value='".$range['id']."'>
			</form>";
 }
 if(isset($_GET["new"])){
//provera input data da bude numeric:
if(is_numeric($_GET["from"])==true and is_numeric($_GET["to"])==true and is_numeric($_GET["price"])==true){
	
// kreiranje objekta $insert i instanciranje metode insert iz class Entity (glavna klasa):

	$insert = new Content;
	$insert->price_from=$_GET["from"];
	$insert->price_to=$_GET["to"];
	$insert->price=$_GET["price"];
	$insert->insert();
	header("Location:/");
}else{
	echo"just numbers!";
}

 }
 if(isset($_GET["drop"])){
//instanciranje metode remove iz class Entity (glavna klasa):
	Content::remove($_GET["mark"]);
	 header("Location:/");
 }
	echo "</div>";//end of class row
 ?>
		
  <div class="row" id="showit">
 <p>Delivery Method 3</p>
			<?php
//prikaz last delivery form database:
//instanciranje metode getLast iz class Entity (glavna klasa):
			$last = Content::getLast();
			?>
<input type="text" name="method0" placeholder="<?php echo $last->price;?>" >$
<div class="new" id="range"><div id="add_ranges">Add ranges</div></div>

<div class="button_blue" id="click"> Show Opttions </div>

 </div>
 <!-- div za delivery data: -->
 <?php
 //pritiskom dugmeta Save ponovo menja css za hidden:
 if(isset($_GET["save"])){
	  echo "<div class='row' style='display:inline_block' id='for_hidden' >";
 }else{echo "<div class='row' style='display:none' id='for_hidden'>";}
?>

			<p>Delivery URL</p>
		
			<input type="text" name="method3_sredina" placeholder="<?php echo $last->delivery_url;?>" >
			
			<br>
			
			<p>Weight(accepted deliveries in KG)</p>
			<p>From</p>
			<input type="text" name="from_3" placeholder="<?php echo $last->from_kg;?>" >
			<p>to</p>
			<input type="text" name="to_3" placeholder="<?php echo $last->to_kg;?>" >KG
			<br>
			<p>Notes</p>
			<input type="text" name="notes" placeholder="<?php echo $last->notes;?>" >
		
			</div>
 <!-- kraj div.a za delivery data -->
  <div class="row">
 <p>Delivery Method 4</p>
<div id="show">Show Ranges</div>
 </div>
 
</div>

<!-- kraj -->	
	
   <input type="submit" class="button_gray" name="save" value="Save Form">
</form> <!--end of save Form -->
<?php
//koda za update delivery data:

if(isset($_GET["save"])){
	
	if(isset($_GET["method3_sredina"])and isset($_GET["notes"])){
		if($_GET["method3_sredina"]!= "" and $_GET["notes"]!=""){
//instanciranje metode update class iz Entity (glavna klasa):
		Content::update($last->id,array('delivery_url'=>trim($_GET["method3_sredina"]),'notes'=>trim($_GET["notes"])));
		}
	}
	if(isset($_GET["from_3"]) and isset($_GET["to_3"])){
		if(is_numeric($_GET["from_3"])==true and is_numeric($_GET["to_3"])==true){
				$params = array('from_kg'=>$_GET["from_3"],'to_kg'=>$_GET["to_3"]);

				Content::update($last->id,$params);
		}else if(is_numeric($_GET["from_3"])==null and is_numeric($_GET["to_3"])==null){
			echo "ok";
		}else{
				echo"bad data, insert numbers!";
				die();
		}
	}

	header("Location:/");
}
	

?>

	</div>
    
   <div id="footer">
   	Copyright &copy; milosvtsl
	</div>
      <a href="#top"><div id="point"><i class="fa fa-hand-pointer-o fa-2x"></i></div></a>
</div> <!--kraj wrap -->
</body>
</html>
