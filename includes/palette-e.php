<?php 
//genero html della palette per class

function loadPalette($indexPanel,$class){
    $arrPalette = json_decode(utf8_encode(file_get_contents("./json/palette-global.json")));

    foreach($arrPalette->palette as $pal)
    {   
        if($pal->class==$class){
            
                $id = $pal->id;
                $_SESSION[$pal->class]=$pal->choice;
                $gtext ='<g class="'.$indexPanel.'" palette-id="'.$id.'" palette-class="'.$pal->class.'" style="display: none;">'."\n";
                $choices = $pal->choice;
                $choices = explode(",", trim($choices));
                $fill = $pal->fill;
                $filles = explode(",", trim($fill));
                $indexChoice=0;
                $x=35;$step=30;
                if($pal->fill!=''){
                    foreach($choices as $choice){
                        $fill=trim($filles[$indexChoice]);
                        if(substr($fill,0,1)!='#'){$fill="url(#".$fill.")";}
                        $gtext.='<rect x="'.$x.'" y="0" height="20" width="20" fill="'.$fill.'" sbid="'.$pal->class."-".$x.'" stroke="gray" stroke-width="1">'."\n";
                        $gtext.='<title>'.$choice.': '.$fill.'</title>'."\n";
                        $gtext.='</rect>'."\n";
                        $x=$x+$step;
                        $indexChoice++;
                    }
                }
                $gtext.="</g>"."\n";
                return $gtext;
            
        }   
    }
}

// recupero side e class delle palette dalla scheda del modello 
$indexPanel=0;
foreach($panelsArray as $panel){
    if($side=='' && $panel->side=='top'){
        $side="top";
        $indexPanel=0;
        $prefix="tbz-";
    }
    if($side=='top' && $panel->side=='bott'){
        $side="bott";
        $indexPanel=0;
        $prefix="bbz-";
    }
    echo loadPalette($prefix.$indexPanel,$panel->palette);
    $indexPanel++;
}
?>


