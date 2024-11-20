<?php #CONFIGURATORE 
if (!session_id()) {
	session_start();
}
include("./includes/header.php");

if(!isset($_POST['id']) && isset($_GET['model']) && $_GET['model']!=''){
	$model=$_GET['model'];
	$_SESSION['id']='';

}
if(isset($_POST['id']) && $_POST['id']!=''){
	$id=$_SESSION['id']=$_POST['id'];
}

///nessun model selezionato, quindi apro prima pagina
if(!isset($id) && !isset($model)){
	//apro tutti i modelli 
	$arr = json_decode(utf8_encode(file_get_contents("./json/sails.json")));
	?>
	
	<div id="main" class="row-fluid">
		<div class="span8 offset2 selectModel">
			<h1>Hanggliders Sails Configurator</h1>
			<hr>
			<form action="" method="post">
				<?php foreach($arr->sails as $sail)
				{
					echo '<button type="submit" name="id" value='.$sail->id.' class="btn-link">'.$sail->title.'</button><br>';
				}
				?>
			</form>
		</div>
	</div>
	<?php
	
}
if(isset($model) && $model!=''){
	$arr = json_decode(utf8_encode(file_get_contents("./json/sails.json")));
	$totList=0;
	$idSel='';
	foreach($arr->sails as $sail)
		{	
			if($sail->model==$model){
				$idSel=$sail->id;
				$totList++;
				$list.='<button type="submit" name="id" value='.$sail->id.' class="btn-link">'.$sail->title.'</button><br>';
			}
		}

		if($totList==0){
			echo '<button class="btn-link">Sorry! Model '.$model.' not found!</button><br><input type="button" value="Back to the list" class="btn btn-secondary" onclick="location.href = \'./\'">';
			exit;
		}
		if($totList>1){
			?>
			<div id="main" class="row-fluid">
				<div class="span8 offset2 selectModel">
					<h1>Please select the <?=$model?> sail type</h1>
					<hr style="border: 5px solid #e7e7e7">
					<form action="https://www.weflylaveno.com/icaro2000/sails/" method="post">
						<?=$list;?>
					</form>
				</div>
			</div>
			<?php
			exit;
		}
		if($totList==1){

			$id=$_SESSION['id']=$idSel;
		}
	
}

if(isset($id) && $id!=''){

//apro modello $model
	$arr = json_decode(utf8_encode(file_get_contents("./json/sails.json")));
	foreach($arr->sails as $sail)
	{
		if($sail->id == $id){
			$title = $sail->title;
			$model = $sail->model;
			$svgFile = $sail->svgFile;
			$tableFile = $sail->tableFile;
			$paletteFile = $sail->paletteFile;
			$panelsArray = $sail->panels;
			break;   
		}
	}
	?>

	<div id="main" class="row-fluid">

		<!-- Modal -->
		<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Sail Configurator Help</h3>
			</div>
			<div class="modal-body">
				<?php include("./includes/help.php");?>
			</div>
		</div>

		<input type="hidden" id="model" name="model" value="<?=$title?>">
		<input type="hidden" id="modelHG" name="modelHG" value="<?=$model?>">

		<div class="row helpBtn">
			<!--header-->
			<div class="span11">
				<!-- Button to trigger modal -->
				<div class="span3 pull-right">
					<a href="#myModal" role="button" class="span2 btn btn-small pull-right" data-toggle="modal">Help</a>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="span11">
				<div style="text-align: center;margin: auto;"><h3><b style="margin: auto;"><?=$title?></b></h3></div>
			</div>
		</div>

		<div class="row">
			<div class="span11" style="text-align: center;">
				<div class="alert-error text-align-center">
					click sail elements to toggle <b>select-unselect</b> and <b>show-hide </b>its related colors palette
				</div>
			</div>
		</div>

		

		<!--- SVG GLOBAL -->
		<svg id="svg" class="sailPanel" width="100%" height="100%" viewBox="0 0 1280 600" xmlns="http://www.w3.org/2000/svg">
			<!-- pattern -->
			<defs>
				<pattern id="Technora" width="10" height="10" patternUnits="userSpaceOnUse">
					<path d="M 0 0 l 10 10 m -10 0 l 10 -10" fill="red" stroke="gray" stroke-width="2" />
				</pattern>
				<pattern id="PX10" width="10" height="10" patternUnits="userSpaceOnUse">
					<path d="M 0 0 l 10 10 m -10 0 l 10 -10" stroke="lightgray" stroke-width="2" />
				</pattern>
				<pattern id="PXB" width="10" height="10" patternUnits="userSpaceOnUse">
					<path d="M 0 0 l 10 10 m -10 0 l 10 -10" stroke="gray" stroke-width="2" />
				</pattern>
				<pattern id="PBX" width="10" height="10" patternUnits="userSpaceOnUse">
					<path d="M 0 0 l 10 10 m -10 0 l 10 -10" stroke="lightgray" stroke-width="2" />
				</pattern>
			</defs>
			<!-- //pattern -->

			<!-- palette --><?php include("./includes/palette-e.php");?><!-- //palette -->

			<!-- svg --><?php include("./includes/svg-e.php");?><!-- //svg -->
		</svg>

		<div class="row">
			<div class="span11 toggleButton" style="text-align: center;">
				<input id="toggle-one" type="checkbox" data-on="TOP" data-off="BOTTOM" checked>
			</div>
		</div>
		<!--- //SVG GLOBAL -->
		
		<canvas id="canvas" width="1280" height="600" style="display:none"></canvas>

		<!-- table --><?php include("./includes/table-e.php");?><!-- //table -->

		<div class="row">
			<div class="span11" style="text-align: center">
				<div style="margin: auto;">
					<span id="btnPDF">
						<a id="btnPDFoff" href="javascript:void(0)" target="_self" class="btn btn-secondary" onClick="alert('Please choose all the colors of the sail') ">Check-Print PDF Document</a>
					</span>
					<input type="button" value="Close" class="btn btn-inverse" onclick="location.href = './'">
				</div>
			</div>
		</div>


	</div>
	<script src="./assets/js/configurator.js?<?=time()?>"></script>
	<?php
}
include("./includes/footer.php");?>