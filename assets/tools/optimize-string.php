<body style="text-align: center;">
<?php
$string="";
$string=$_POST['string'];
if($string!=''){
$newstring = str_replace("\r", "", $string);
?>

La tua stringa è:<hr>
<?=$newstring?><hr>
<form method="post">
<input type="hidden" id="string" name="string" value="">
<input type="submit" value="Ottimizza un'altra stringa">
</form>
<?php
}else{
?>
<body style="text-align: center;margin-top:40px">
<form method="post" style="
    border: 1px solid #bbb;
    margin: auto;
    width: 600px;
    padding: 20px;
    border-radius: 15px;
">
  <label for="string">Incolla la stringa da ottimizzare</label><br>
  <input type="text" width="800" height="500" id="string" name="string" value="" style="
    width: 100%;
    height: 400px;
    margin-bottom: 20px;
    background-color: #dddddd29;
    text-align: center;
    color: #378707;
    border: 1px solid #bbbbbb3b;
"><br>
  <input type="submit" value="Ottimizza">
</form> 

<?php } ?>
</body>
