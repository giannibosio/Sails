<div id="grid">
	<table class="grid">
		<thead>
			<tr class="gridheader">
				<th scope="col" class="small">Side</th>
				<th scope="col" class="small">Code</th>
				<th style="display:none" scope="col" class="small">ID</th>
				<th scope="col" class="medium">Panel</th>
				<th scope="col" class="medium">Fill</th>
				<th scope="col">Choices</th>
			</tr>
		</thead>

		<?php
				// recupero i dati per comporre la table dalla scheda del modello selezionato 
		$indexPanel=0;
		$table = '<tbody>';
		foreach($panelsArray as $panel){  


			$fill='';
			$style='';
			if(isset($panel->fixed) && $panel->fixed<>''){$fill=$_SESSION[$panel->palette];$style='style="background-color: yellow;"';}

			$table .= '<tr'.$class.'>';
			$table .=  '<td class="gridcolint">'.$panel->side.'</td>';
			$table .=  '<td class="gridcolint">'.$panel->code.'</td>';
			$table .=  '<td style="display:none" class="gridcolint">'.$panel->id.'</td>';
			$table .=  '<td>'.$panel->name.'</td>';
			$table .=  '<td class="bz" '.$style.'>'.$fill.'</td>';
			$table .=  '<td class="myWidth">'.$_SESSION[$panel->palette].'</td>';
			$table .=  '</tr>'."\n";
			if($class==''){$class=' class="alternate"';}else{$class='';}
		}
		echo $table .= '</tbody>';
		?>
	</table>
</div>