<?php
// recupero i dati per comporre il tracciato svg del modello selezionato 

$bgcolorNeutral='#f0fff078'; ///colore dell'ala non selezionato
$paths = '';
$pathsTop = '';
$pathsBottom = '';
foreach($panelsArray as $pan){

		$fill=$bgcolorNeutral;
		$selectable='true';
		$classSel="selectable";
		if(isset($pan->fixed) && $pan->fixed<>''){
			if($pan->fixed=='transparent'){
				$fill='#f0fff0';
				$selectable='true';
				$classSel="selectable";
			}else{
			
				$selectable='false';
				$classSel="";
				if(substr($pan->fixed,0,1)=='#'){
					$fill='url('.$pan->fixed.')';
				}else{
					$fill=$pan->fixed;
				}
			}
			
		}
		
		//trovo tutti i pannelli top
		if($pan->side=='top'){
			$pathsTop .= '<path class="tpth-'.$pan->id.' '.$pan->code.' '.$classSel.'" d="'.$pan->svg.'" panelcode="'.$pan->code.'" selectable="'.$selectable.'" fill="'.$fill.'" stroke="gray" stroke-width="1">'."\n";
			$pathsTop .= '<title>'.$pan->name.'</title>'."\n";
			$pathsTop .= '</path>'."\n";
		}
		//trovo tutti i pannelli bottom
		if($pan->side=='bott'){ 
			$pathsBottom .= '<path class="tpth-'.$pan->id.' '.$pan->code.' '.$classSel.'" d="'.$pan->svg.'" panelcode="'.$pan->code.'" selectable="'.$selectable.'" fill="'.$fill.'" stroke="gray" stroke-width="1">'."\n";
			$pathsBottom .= '<title>'.$pan->name.'</title>'."\n";
			$pathsBottom .= '</path>'."\n";
		}

}
//genero la pagina dei tracciati
$paths .= '<svg id="drwTop" x="10" y="0" style="display: none;">'."\n"; ///top
$paths .= $pathsTop."\n";
$paths .= '</svg>'."\n";
$paths .= '<svg id="drwBtm" x="10" y="0">'."\n"; //bottom
$paths .= $pathsBottom."\n";
$paths .= '</svg>'."\n";
echo $paths; //stampo
?>