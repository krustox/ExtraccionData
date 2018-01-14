/**
 * @author Diego
 */

$(document).ready(function(){
	$("#trescinco").change(function() {
  		if($("#trescinco").is(':checked')){
  			//window.alert($("#trescinco").val());
  			$('#datetimepicker1').prop('disabled',true);
  			$('#datetimepicker1').val("");
  			$('#datetimepicker2').prop('disabled',true);
  			$('#datetimepicker2').val("");
  		}else{
  			//window.alert($("#trescinco").val());
  			$('#datetimepicker1').prop('disabled',false);
  			$('#datetimepicker2').prop('disabled',false);
  		}
	});
});

function bloquea(user){
	output = fecha();
  	var cpu="",memoria="",disco="",ecol="",concu="",servidor="",linux="",trescinco="",pordia="",fechai="",fechaf="",bdserv="",bdstatus="",bdsql="",bderror="",wassesiones="",wasstatus="",apachestatus="",brokerstatus="",brokermq="",mqstatus="",mqcolas="",heapusado="",wasjvm="",discoio="",ping="";
  	if($('#cpu').is(':checked')){cpu = "1";}
  	if($('#memoria').is(':checked')){memoria = "1";}
  	if($('#disco').is(':checked')){disco = "1";}
  	if($('#ecol').is(':checked')){ecol = "1";}
  	if($('#concu').is(':checked')){concu = "1";}
  	servidor = $('#servidor').val().trim();
  	linux = $('#linux').val().trim();
  	if($('#trescinco').is(':checked')){trescinco = "1";}
  	if($('#pordia').is(':checked')){pordia = "1";}
  	fechai = $('#datetimepicker1').val();
  	fechaf = $('#datetimepicker2').val();
  	if($('#bdserv').is(':checked')){bdserv = "1";}
  	if($('#bdstatus').is(':checked')){bdstatus = "1";}
  	if($('#bdsql').is(':checked')){bdsql = "1";}
  	if($('#bderror').is(':checked')){bderror = "1";}
  	if($('#wassesiones').is(':checked')){wassesiones = "1";}
  	if($('#wasstatus').is(':checked')){wasstatus = "1";}
  	if($('#apachestatus').is(':checked')){apachestatus = "1";}
  	if($('#brokerstatus').is(':checked')){brokerstatus = "1";}
  	if($('#brokermq').is(':checked')){brokermq = "1";}
  	if($('#mqstatus').is(':checked')){mqstatus = "1";}
  	if($('#mqcolas').is(':checked')){mqcolas = "1";}
  	if($('#heapusado').is(':checked')){heapusado = "1";}
  	if($('#wasjvm').is(':checked')){wasjvm = "1";}
  	if($('#discoio').is(':checked')){discoio = "1";}
  	if($('#ping').is(':checked')){ping = "1";}
  	if((cpu === "1" || memoria === "1" || disco  === "1" || ecol === "1" || concu === "1" || bdserv === "1" || bdstatus === "1" || bdsql === "1" || bderror === "1" 
  	||  wassesiones === "1" || wasstatus === "1" || apachestatus === "1" || brokerstatus === "1" || mqstatus === "1" || mqcolas === "1" || heapusado === "1" 
  	|| wasjvm === "1" || discoio === "1" || ping === "1") 
  	&& (servidor !== "" || linux !== "") 
  	&& (fechaf !== "" || trescinco === "1")){				
  		output2 = output.replace(".",":");
  		output2 = output2.replace(".",":");
  		$.get("http://vs2k8-monbdbc01/SegundoPlano/ajax/insert.php?user="+user+"&server="+servidor+"]"+linux+"]"+trescinco+"]"+fechai+"]"+fechaf+"&fecha="+output2);
  	$.ajax({
  			async:true,
            type: "POST",
            url: "report.php",
            data: {cpu: cpu, memoria: memoria, disco: disco, ecol: ecol, concu: concu, servidor: servidor, linux: linux, trescinco: trescinco, pordia: pordia, fechai: fechai, fechaf: fechaf, bdserv: bdserv, bdstatus: bdstatus, bdsql: bdsql, bderror: bderror, wassesiones: wassesiones, wasstatus: wasstatus, apachestatus: apachestatus, brokerstatus: brokerstatus, brokermq: brokermq, mqstatus: mqstatus, mqcolas: mqcolas, heapusado: heapusado, wasjvm: wasjvm, discoio: discoio, fecha: output, ping: ping, fechax: output2},
            success: function (html) {
            	$.get("http://vs2k8-monbdbc01/SegundoPlano/ajax/fin.php?user="+user+"&server="+servidor+"]"+linux+"]"+trescinco+"]"+fechai+"]"+fechaf+"&fecha="+output2);
				//window.open('http://localhost/ExtraccionData/Data/data_'+output+'_'+user+'.xlsx','_blank' );
				window.open('http://vs2k8-monbdbc01/ExtraccionData/Data/data_'+output+'_'+user+'.xlsx','_blank' );
			desbloquea();
            }
        });
	$('#bloquea').delay(5).queue(function(){
  		$('#bloquea').show();
	});
	//window.alert("Proceso Creado");
	}else{
		window.alert("Debe selecionar alguna de las opciones superiores");
	}
}

function desbloquea(){
  	$('#bloquea').hide();
}

$(document).ready(function(){
	$('#datetimepicker1').datetimepicker({
		format:'Y-m-d H:i:s'
	});
});
$(document).ready(function(){
	$('#datetimepicker2').datetimepicker({
		format:'Y-m-d H:i:s'
	});
});

function logout(){
	if (confirm("Desea cerrar sesion?")) {
        // your deletion code
	var response;
	$.ajax({ type: "GET",   
     url: "/ExtraccionData/ajax/logout.php",   
     async: false,
	 datatype: "html",
     success : function(data)
     {
        response= data;
        window.location.replace(data);
     }
	});	
}
    return false;	
}

function fecha(){
	var d= new Date();
	var month = d.getMonth()+1;
	var day = d.getDate();
	var hour = d.getHours();var min = d.getMinutes(); var seg = d.getSeconds();
	var output = d.getFullYear() + '-' +(month<10 ? '0' : '') + month + '-' +(day<10 ? '0' : '') + day +' ' +(hour<10 ? '0':'')+hour+'.'+ (min<10 ? '0':'')+min+'.'+ (seg<10 ? '0':'')+seg;
	return output;
}
