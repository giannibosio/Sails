$(function () {


	var confiGuid = $("h5").text();
	localStorage.clear();
	localStorage.setItem("colorAltoNosePE", '');
	localStorage.setItem("colorAltoNosePD", '');
	localStorage.setItem("modelHG", document.getElementById('modelHG').value);
						// pannello selezionato da colorare
						var selSide = 1;   // 0 top   1 btm
						var selInd = 0;      // no selection
						var selCode = "";
						var selColor = "";
						var nameColor = "";
						var classelector = "";

						// --------- toggle definition
						$('#toggle-one').bootstrapToggle({
							size: "small",
							onstyle: "primary",
							offstyle: "default",
						});

						// inizializzo bottom display hide all palettes
						$('#toggle-one').bootstrapToggle("toggle");
						$('#drwTop').hide();
						$("g").hide();

						$('#toggle-one').change(function () {
							////////$('#btnPdf').click();
							autosave(selSide);
							//////////////////
							if ($('#toggle-one').prop('checked')) {
								$('#drwTop').show();
								$('#drwBtm').hide();
								$("g").hide();
								selSide = 0;
							}
							else {
								$('#drwTop').hide();
								$('#drwBtm').show();
								$("g").hide();
								selSide = 1;
							}
						});

						// inizializzo palette strokes
						$("rect").attr("stroke", "gray");
						$("rect").attr("stroke-width", "1");

						// click su un panel deve visualizzarlo con bordo spesso (selezionato) e mostrare la palette giusta
						$("path").on("click", function () {

							if($(this).attr("selectable")=='false'){

								console.log('panelCode='+$(this).attr("panelCode"));
								
								
								return;
							}

							if($(this).attr("class")=='tpth-1217 BN selectable'){
								if(localStorage.getItem("colorAltoNosePD")=='' || localStorage.getItem("colorAltoNosePE")==''){
									alert('To select the nose color you must first select the colors in Panels D and E');
									return;
								}
							}

							if ($(this).attr("stroke-width") == "3") { //deselect this
								$(this).attr("stroke-width", "1");
								// hide all palettes
								$("g").hide();
								selInd = -1;
								//nessuna palette visualizzata
							}
							else { // select new
								$("path").attr("stroke-width", "1");  // reset tutti a 1
								$(this).attr("stroke-width", "3");
								selInd = $(this).index();
								selCode = this.classList[1];

								

								$("g").hide();
								if (selSide === 0) { classelector = ".tbz-"; } else { classelector = ".bbz-"; };
								classelector = classelector + selInd;
								$(classelector).show();
							}
						});
						// click su una palette > devo colorare il panel poi deselezionarlo *e nascondere la palette(
						$("rect").on("click", function () {
							

							createSpecialPalette(localStorage.getItem("modelHG"),selCode,$(this).attr("fill"),$(this).find("title").text());

							$("." + selCode).attr("fill", $(this).attr("fill")).attr("stroke-width", "1");

							//aggiorno curr fill in tabella
							selColor = $(this).attr("fill");
							nameColor = selColor;
							//console.log("nameColor ."+ nameColor);
							
							if (selColor.substr(0, 3) === "url") {
								nameColor = selColor.slice(5, -1);   //tolgo  url(#  e   )
							}
							else {
								nameColor = $(this).find("title").text();   // trovo nome
								nameColor = $.trim(nameColor.substring(0, nameColor.search(":")));
							};



							localStorage.setItem("tableType", "buyer");
							currFillIndex = 4;
							currCodeIndex = 1;
							if ($("th:first").text().substr(1, 7) === "sail ID") {
								localStorage.setItem("tableType", "admin");
								currFillIndex = 6;
								currCodeIndex = 2;
							}
							//
							$('tr').filter(function () {
								var $this = $(this);
								// Search for code
								if ($.trim($this.children('td').eq(currCodeIndex).text()) == selCode) {
									$this.children('td').eq(currFillIndex).css('background-color', 'yellow').text(nameColor);   //
								}
							});

							$("g").hide();

							//verifico quanti sono i selezionati. Se son tutti selezionati abilito pulsante pdf
							panelsOnTable = document.getElementsByClassName("bz");
							choichesNull=0;
							for (var i=0;i<panelsOnTable.length;i++) {
								if(panelsOnTable[i].innerHTML==''){
									choichesNull++;
								}
							}; 
							
							if(choichesNull==0){

								if(localStorage.getItem("side0")=='null' || localStorage.getItem("side1")=='null'){
									alert('Please, Check TOP and BOTTOM again');

								}else{
									//console.log('side0:'+localStorage.getItem("side0"));
									//console.log('side1:'+localStorage.getItem("side1"));
									//console.log('Abilito pulsante PDF');
									//autosave(0);
									//autosave(1);
									document.getElementById("btnPDF").innerHTML='<a id="btnPDFon" href="./includes/pdf-exp.php" target="_blank" class="btn btn-success btn-small">Check-Print PDF Document</a>';
								}
								
							}else{
								//console.log('Mancano ancora '+choichesNull+' selezioni. PDF disabilitato');
								document.getElementById("btnPDF").innerHTML='<a id="btnPDFoff" href="javascript:void(0)" target="_self" class="btn btn-secondary btn-small" onClick="alert(\'Still missing '+choichesNull+' colors to choose from.\') ">Check-Print PDF Document</a>';
							}
							autosave(selSide);

						});

						var btn = document.querySelector('#btnPdf');
						var svg = document.querySelector('svg');
						var canvas = document.querySelector('canvas');
						//
						$("#btnCheck").on("click", function () {
							var href = $(this).attr("data-href");
							//autosave(selSide);
							$('#toggle-one').bootstrapToggle("toggle");
							$('#toggle-one').bootstrapToggle("toggle");
							//
							$("#lnkCheck").get(0).click();

						});


						function createSpecialPalette(modelHG,selCode,colorFill,nameColor){
							//change altonose
							var colorPal='';
							if(modelHG=='alto' && selCode=='PE'){
								localStorage.setItem("colorAltoNosePE", colorFill);
								document.querySelector('[sbid="altonose-65"]').setAttribute('fill',colorFill);
								//document.querySelector('[class="tpth-1217 BN selectable"]').setAttribute('fill',"#fff");

								$('tr').filter(function () {
									var $this = $(this);
									// Search for code
									if ($.trim($this.children('td').eq(1).text()) == 'BN') {
										$this.children('td').eq(4).css('background-color', 'PINK').text('');   //
									}
								});

							}
							if(modelHG=='alto' && selCode=='PD'){
								localStorage.setItem("colorAltoNosePD", colorFill);
								document.querySelector('[sbid="altonose-35"]').setAttribute('fill',colorFill);
								//document.querySelector('[class="tpth-1217 BN selectable"]').setAttribute('fill',"#fff");

								$('tr').filter(function () {
									var $this = $(this);
									// Search for code
									if ($.trim($this.children('td').eq(1).text()) == 'BN') {
										$this.children('td').eq(4).css('background-color', 'PINK').text('');   //
									}
								});
							}
							
							if(localStorage.getItem("colorAltoNosePD")!='' && localStorage.getItem("colorAltoNosePE")!=''){
								
							}
							return;
						}


						function autosave(selSide) {
							//console.log('autosave->'+selSide);
							var canvas = document.getElementById('canvas');
							var ctx = canvas.getContext('2d');

							ctx.clearRect(0, 0, canvas.width, canvas.height);           //reinizializzo canvas
							$("g").hide();
							//
							var data = (new XMLSerializer()).serializeToString(svg);
							var DOMURL = window.URL || window.webkitURL || window;
							var img = new Image();
							var svgBlob = new Blob([data], { type: 'image/svg+xml;charset=utf-8' });
							var url = DOMURL.createObjectURL(svgBlob);
							img.onload = function () {
								ctx.drawImage(img, 0, 0);
								DOMURL.revokeObjectURL(url);
								var imgURI = canvas
								.toDataURL('image/png')
								.replace('image/png', 'image/octet-stream');
								//triggerDownload(imgURI);
								/////


								localStorage.setItem("confiGuid", confiGuid);

								localStorage.setItem("model", document.getElementById('model').value);
								localStorage.setItem("modelHG", document.getElementById('modelHG').value);

								var imgKey = "side" + selSide
								localStorage.setItem(imgKey, imgURI);

								var table = $('table').tableToJSON({
									//ignoreColumns: [4, 7]
									ignoreColumns: [7]
								});
								localStorage.setItem('JSONtable', JSON.stringify(table));
								//alert("JSONtable > " + JSON.stringify(table))
								localStorage.setItem('JSONtableLen', $('table tr').length);

								//console.log('localStorage: '+localStorage.getItem("JSONtable"));
								//console.log('localStorage: '+localStorage.getItem("side0"));
								//console.log('localStorage: '+localStorage.getItem("side1"));
								//console.log('model: '+localStorage.getItem("model"));

							};
							img.src = url;
							//console.log('img.src '+img.src);
							// quando clicco SAVE -sempre- giro la flag corrispondente
							if (selSide === 0) {
								$("#flag1").toggleClass("btn-success").text("SAVED");
							} else {
								$("#flag2").toggleClass("btn-success").text("SAVED");
							};
						}
						
					});