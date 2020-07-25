$(document).ready(function() {
	
	$('.gambar').each(function(){
		var url = $(this).attr("src");
		$(this).zoom({url: url});
	});

	$('.only-number').keypress(function(evt){
             var charCode = (evt.which) ? evt.which : event.keyCode
             if (charCode > 31 && (charCode < 48 || charCode > 57))

            return false;
        return true;
    });

    $('.uang').keyup(function(){
      var isi = $(this).val().replace(/\./g, '');
      $(this).val(formatAngka(isi))
    });

    function formatAngka(angka) {
      if (typeof(angka) != 'string') angka = angka.toString();
      var reg = new RegExp('([0-9]+)([0-9]{3})');
      while(reg.test(angka)) angka = angka.replace(reg, '$1.$2');
      return angka;
    }

	var url = get_url(parseInt(uri_js));
	var url2 = get_url((parseInt(uri_js)+1));
	var url3 = get_url((parseInt(uri_js)+2));
	var url4 = get_url((parseInt(uri_js)+3));
	var url5 = get_url((parseInt(uri_js)+4));
   
	if (url == "m_siswa") {
		pagination("datatabel", base_url+"pengusaha/m_siswa/data", []);
	} else if (url == "m_guru") {
		pagination("datatabel", base_url+"trainer/m_guru/data", []);
	} else if (url == "m_mapel") {
		pagination("datatabel", base_url+"dtest/m_mapel/data", []);		
	}else if (url == "chats") {
		setInterval('data_realtime()', 1000);
	} else if (url == "m_test") {
		pagination("datatabel", base_url+"soal/m_test/data", []);	
	}	
	else if(url == 'm_ujian') {
		if(url3 == 'lihat_soal') {
			pagination("datatabel", base_url+"ujian/get_soal", []);
		}else{
			pagination("datatabel", base_url+"soal/m_ujian/data/" +url3, []);
		}
	}
	 else if (url == "m_soal") {
		pagination("datatabel", base_url+"soal/m_soal/data/"+url5, []);

		if (url2 == "edit") {
			if (editor_style == "inline") {
				CKEDITOR.inline('editornya');
				CKEDITOR.inline('editornya_a');
				CKEDITOR.inline('editornya_b');
				CKEDITOR.inline('editornya_c');
				CKEDITOR.inline('editornya_d');
				CKEDITOR.inline('editornya_e');
			} else if (editor_style == "replace") {
				CKEDITOR.replace('editornya');
				CKEDITOR.replace('editornya_a');
				CKEDITOR.replace('editornya_b');
				CKEDITOR.replace('editornya_c');
				CKEDITOR.replace('editornya_d');
				CKEDITOR.replace('editornya_e');
			}
		}
	}
	 else if (url == "h_ujian") {
		if (url2 == "det") {
			pagination("datatabel", base_url+"hasil/h_ujian/data_det/"+url3, []);
		} else {
			pagination("datatabel", base_url+"hasil/h_ujian/data", []);	
		}
	} else if (url == "m_ujian") {
		if (url2 == "det") {
			pagination("datatabel", base_url+"ujian/m_ujian/data_det/"+url3, []);
		} 
		else {
			pagination("datatabel", base_url+"soal/m_ujian/data/"+url3, []);	
		}
	} else if (url == "ikut_ujian") {
		if (url2 == "token") {
			timer();
		} 
		else if(url2 == 'uts') {

		}
	} 
});

function timer() {
	var tgl_sekarang = $("#_tgl_sekarang").val();
	var tgl_mulai = $("#_tgl_mulai").val();
    var tgl_terlambat = $("#_terlambat").val();
	var id_ujian = $("#id_ujian").val();
	var statuse = $("#_statuse").val();
	statuse = parseInt(statuse);

	if (statuse == 1) {
		$("#btn_mulai").html('<a href="javascript:void(0);" class="btn btn-primary btn-lg" id="tbl_mulai" onclick="return konfirmasi_token('+id_ujian+')"><i class="fa fa-check-circle"></i> Ashiap</a>');
		
		$('#waktu_akhir_ujian').countdowntimer({
	        startDate : tgl_sekarang,
	        dateAndTime : tgl_terlambat,
	        size : "lg",
	        labelsFormat : true,
	 		timeUp : hilangkan_tombol,
	    });
	} else if (statuse == 0) {
		$("#btn_mulai").addClass("btn btn-primary btn-lg");
		$("#waktu_").hide();
		$('#akan_mulai').countdowntimer({
	        startDate : tgl_sekarang,
	        dateAndTime : tgl_mulai,
	        size : "lg",
	        labelsFormat : true,
	 		timeUp : timeIsUp,
	    });
	} else if (statuse == 2) {
		hilangkan_tombol();
	} else {
		hilangkan_tombol();
	}
}

function timer2() {
	var tgl_sekarang = $("#_tgl_sekarang").val();
	var tgl_mulai = $("#_tgl_mulai").val();
    var tgl_terlambat = $("#_terlambat").val();
	var id_ujian = $("#id_ujian").val();
	var statuse = $("#_statuse").val();
	statuse = parseInt(statuse);
	if (statuse == 1) {
		$("#btn_mulai").html(`<a href="javascript:void(0);" class="btn btn-primary btn-block" id="tbl_mulai" onclick="return konfirmasi_token2('` + id_ujian + `')"><i class="fa fa-check-circle"></i> MULAI</a>`);
		
		$('#waktu_akhir_ujian').countdowntimer({
	        startDate : tgl_sekarang,
	        dateAndTime : tgl_terlambat,
	        size : "lg",
	        labelsFormat : true,
	 		timeUp : hilangkan_tombol,
	    });
	} else if (statuse == 0) {
		$("#btn_mulai").addClass("btn btn-success btn-lg");
		$("#waktu_").hide();
		$('#akan_mulai').countdowntimer({
	        startDate : tgl_sekarang,
	        dateAndTime : tgl_mulai,
	        size : "lg",
	        labelsFormat : true,
	 		timeUp : timeIsUp,
	    });
	} else if (statuse == 2) {
		hilangkan_tombol();
	} else {
		hilangkan_tombol();
	}
}

function timer3() {
	var tgl_sekarang = $("#_tgl_sekarang").val();
	var tgl_mulai = $("#_tgl_mulai").val();
    var tgl_terlambat = $("#_terlambat").val();
	var id_ujian = $("#id_ujian").val();
	var statuse = $("#_statuse").val();
	statuse = parseInt(statuse);

	if (statuse == 1) {
		$("#btn_mulai").html(`<a href="javascript:void(0);" class="btn btn-success btn-sm" id="tbl_mulai" onclick="return konfirmasi_token3('` + id_ujian + `')"><i class="fa fa-check-circle"></i> MULAI</a>`);
		
		$('#waktu_akhir_ujian').countdowntimer({
	        startDate : tgl_sekarang,
	        dateAndTime : tgl_terlambat,
	        size : "lg",
	        labelsFormat : true,
	 		timeUp : hilangkan_tombol,
	    });
	} else if (statuse == 0) {
		$("#btn_mulai").addClass("btn btn-success btn-lg");
		$("#waktu_").hide();
		$('#akan_mulai').countdowntimer({
	        startDate : tgl_sekarang,
	        dateAndTime : tgl_mulai,
	        size : "lg",
	        labelsFormat : true,
	 		timeUp : timeIsUp,
	    });
	} else if (statuse == 2) {
		hilangkan_tombol();
	} else {
		hilangkan_tombol();
	}
}


function timer4() {
	var tgl_sekarang = $("#_tgl_sekarang").val();
	var tgl_mulai = $("#_tgl_mulai").val();
    var tgl_terlambat = $("#_terlambat").val();
	var id_ujian = $("#id_ujian").val();
	var statuse = $("#_statuse").val();
	statuse = parseInt(statuse);
	console.warn(id_ujian)
	if (statuse == 1) {
		$("#btn_mulai").html(`<a href="javascript:void(0);" class="btn btn-success btn-block" id="tbl_mulai" onclick="return konfirmasi_token4('` + id_ujian + `')"><i class="fa fa-check-circle"></i> MULAI</a>`);
		
		$('#waktu_akhir_ujian').countdowntimer({
	        startDate : tgl_sekarang,
	        dateAndTime : tgl_terlambat,
	        size : "lg",
	        labelsFormat : true,
	 		timeUp : hilangkan_tombol,
	    });
	} else if (statuse == 0) {
		$("#btn_mulai").addClass("btn btn-success btn-block");
		$("#waktu_").hide();
		$('#akan_mulai').countdowntimer({
	        startDate : tgl_sekarang,
	        dateAndTime : tgl_mulai,
	        size : "lg",
	        labelsFormat : true,
	 		timeUp : timeIsUp,
	    });
	} else if (statuse == 2) {
		hilangkan_tombol();
	} else {
		hilangkan_tombol();
	}
}


function timeIsUp() {
	var id_ujian = $("#id_ujian").val();
	$("#btn_mulai").html('<a href="#" class="btn btn-success btn-lg" id="tbl_mulai" onclick="return konfirmasi_token('+id_ujian+')"><i class="fa fa-check-circle"></i> MULAI</a>');

	var tgl_sekarang = $("#_tgl_sekarang").val();
	var tgl_mulai = $("#_tgl_mulai").val();
    var tgl_terlambat = $("#_terlambat").val();
}

function hilangkan_tombol() {
	$("#btn_mulai").hide();
	$("#waktu_").hide();
	$("#waktu_game_over").html('<a class="btn btn-danger btn-lg" onclick="return alert(\'Waktu selesai..!\');">Waktu Ujian Selesai</a>');
}

/* FUNGSI BERSAMA */
function get_url(segmen) {
	var url1 = window.location.protocol;
	var url2 = window.location.host;
	var url3 = window.location.pathname;
	var pathArray = window.location.pathname.split('/');
	return pathArray[segmen];
}
function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};
    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });
    return indexed_array;
}

function pagination(indentifier, url, config, prop = {}) {
    $('#'+indentifier).DataTable({
        "language": {
            "url": base_url+"assets/plugin/datatables/Indonesian.json"
        },
        "ordering": false,
        "columnDefs": config,
        "bProcessing": true,
        "serverSide": true,
        "bDestroy" : true,
        "ajax":{
            url : url, // json datasource
			type: "post",  // type of method  , by default would be get
			data: {
				prop
			},
            error: function(){  // error handling code
                $("#"+indentifier).css("display","none");
            }
        }
    }); 
}

function login(e) {
	e = e || window.event;
	var data 	= $('#f_login').serialize();
	$("#konfirmasi").html("<div class='alert alert-info'><i class='icon icon-spinner icon-spin'></i> Checking...</div>")
	$.ajax({
		type: "POST",
		data: data,
		url: base_url+"login/act_login",
		success: function(r) {
			if (r.log.status == 0) {
				$("#konfirmasi").html("<div class='alert alert-danger'>"+r.log.keterangan+"</div>");
			} else {
				$("#konfirmasi").html("<div class='alert alert-success'>"+r.log.keterangan+"</div>");
				window.location.assign(base_url+"beranda"); 
			}
		}
	});
	return false;
}
/* 
=======================================
=======================================
*/
function konfirmasi_token(id) {
	var token_asli = $("#_token").val();
	var token_input = $("#token").val();
	var id_pengguna = $("#penggunaan").val();

	if (token_asli != token_input) {
		alert("Token salah..!");
		return false;
	} else {
		
		/*var stateObj = { foo: "bar" };
  		history.replaceState(stateObj,'base_url+"ujian/ikut_ujian/_/"+id+"/"+id_pengguna' ,base_url+"ujian/ikut_ujian/_/"+id+"/"+id_pengguna);*/
		OpenWindow(base_url+"ujian/ikut_ujian/_/"+id+"/"+id_pengguna); //window.location.assign(base_url+"ujian/ikut_ujian/_/"+id+"/"+id_pengguna); 
	}
}

function konfirmasi_token2(id) {
	var token_asli = $("#_token").val();
	var token_input = $("#token").val();

	if (token_asli != token_input) {
		alert("Token salah..!");
		return false;
	} else {
		$('#disclaimer-tugas').modal('show')
		/*var stateObj = { foo: "bar" };
  		history.replaceState(stateObj,'base_url+"ujian/ikut_ujian/_/"+id+"/"+id_pengguna' ,base_url+"ujian/ikut_ujian/_/"+id+"/"+id_pengguna);*/
		  $('#link-tugas').on('click', function(e) {
			e.preventDefault()
			OpenWindow(base_url+"ujian_real/ikut_ujian/"+id); 
		  })
		//window.location.assign(base_url+"ujian/ikut_ujian/_/"+id+"/"+id_pengguna); 
	}
}

function konfirmasi_token3(id) {
	var token_asli = $("#_token").val();
	var token_input = $("#token").val();

	if (token_asli != token_input) {
		alert("Token salah..!");
		return false;
	} else {
		
		/*var stateObj = { foo: "bar" };
  		history.replaceState(stateObj,'base_url+"ujian/ikut_ujian/_/"+id+"/"+id_pengguna' ,base_url+"ujian/ikut_ujian/_/"+id+"/"+id_pengguna);*/
		OpenWindow(base_url+"penilaian/ikut_ujian/"+id); //window.location.assign(base_url+"ujian/ikut_ujian/_/"+id+"/"+id_pengguna); 
	}
}

function konfirmasi_token4(id) {
	var token_asli = $("#_token").val();
	var token_input = $("#token").val();

	if (token_asli != token_input) {
		alert("Token salah..!");
		return false;
	} else {
		$('#disclaimer-tugas').modal('show')
		/*var stateObj = { foo: "bar" };
  		history.replaceState(stateObj,'base_url+"ujian/ikut_ujian/_/"+id+"/"+id_pengguna' ,base_url+"ujian/ikut_ujian/_/"+id+"/"+id_pengguna);*/
		  $('#link-tugas').on('click', function(e) {
			e.preventDefault()
			OpenWindow(base_url+"ujian_essay/ikut_ujian/"+id);
		  })
		   //window.location.assign(base_url+"ujian/ikut_ujian/_/"+id+"/"+id_pengguna); 
	}
}

var MyPopUp = false;
function OpenWindow(url){
  //checks to see if window is open
  if(MyPopUp && !MyPopUp.closed)
  {
  	alert("ujian sedang buka  ..!");
    winPop.focus(); //If already Open Set focus
  }
  else
  {
  	// alert("Akses Diizinkan ..!");
    MyPopUp = window.open(url,"MyPopUp");//Open a new PopUp window
  }
}


// function m_soal_h(id) {
// 	if (confirm('Anda yakin..?')) {
// 		$.ajax({
// 			type: "GET",
// 			url: base_url+"soal/m_soal/hapus/"+id,
// 			success: function(response) {
// 				if (response.status == "ok") {
// 				// 	window.location.assign(base_url+"soal/m_soal/"+url3+"/"+url3); 
// 				window.location.reload(); 
// 				} else {
// 					console.log('gagal');
// 				}
// 			}
// 		});
// 	}
	
// 	return false;
// }

function m_ujian_soal(id) {
    	$("#form_uji").modal('show');
    // window.location.assign(base_url+"soal/m_soal/edit/0/");
	$.ajax({
		type: "GET",
		url: base_url+"soal/m_soal/det1/"+id,
		success: function(data) {
			$("#id_mapel").val(data.id_mapel);
			$("#id_guru").val(data.id_guru);
		
		}
	});
	
	return false;
}
function hapus_file(id,no) {
	if (confirm('Anda yakin mau menghapus file ini..?')) {
		$.ajax({
			type: "GET",
			url: base_url+"soal/m_soal/file_hapus/"+id+"/"+no,
			success: function(response) {
				if (response.status == "ok") {
					// pageLoad(1,'soal/m_soal/edit/'+id);
					window.location.assign(base_url+'soal/m_soal/edit/'+id);
				} else {
					window.location.assign(base_url+'soal/m_soal/edit/'+id);
					// pageLoad(1,'soal/m_soal/edit/'+id);
					// console.log('gagal');
				}
			}
		});
	}
	return false;
}

function hapus_file_ujian(id,no) {
	if (confirm('Anda yakin mau menghapus file ini..?')) {
		$.ajax({
			type: "GET",
			url: base_url+"ujian/file_hapus_ujian/"+id+"/"+no,
			success: function(response) {
				if (response.status == "ok") {
					// pageLoad(1,'soal/m_soal/edit/'+id);
					window.location.reload();
				} else {
					window.location.reload();
					// pageLoad(1,'soal/m_soal/edit/'+id);
					// console.log('gagal');
				}
			}
		});
	}
	return false;
}
function data_realtime(){
	var f_asal	= $("#f_chat");
	var form	= getFormData(f_asal);
	var id = $("#id").val();
	
	$.ajax({
		type: "GET",
		url: base_url+"dtest/m_mapel/chats/"+id,
		success: function(data) {  
			 addData(data.chat, data.nama, data.scrol);
			 userOnline(data.online);
			 judulChat(data.judul);
			 userNotif(data.notif);
			//  console.log(data.level);
		}
	});
	
	return false;
}

function judulChat(judul){
	var str = '';
	
	  for (let i = 0; i < judul.length; i++) {
		str += `<p>`+judul[i].nama+`</p>`
		// console.log(judul[i].nama);
	}
	$(".contact-profile").html(str);	
}

function clearNotif(id){
	$.ajax({
		type: "POST",
		url: base_url+"dtest/m_mapel/clear/"+id,
		success: function(data) {  
			window.location.assign(base_url+"dtest/chats/"+id);
	   }
	});
	
	return false;
}
function userNotif(notif){
	var str = '';
	
	  for (let i = 0; i < notif.length; i++) {
		str += notif[i].notif
		// console.log(chat[i].nama);
	}
	$("#notif").html(str);	
}
function userOnline(online){
	var str = '';
	var id = $("#id_user").val();
	
	  for (let i = 0; i < online.length; i++) {
		
		if(online[i].kon_id == id){
			str += `<ul>
		 <li class="contact active">
			 <div class="wrap">
				 <div class="meta">
					<p class="name">Saya</p>
				 </div>
			 </div>
		 </li>
	 </ul>`
		}else{
			str += `<ul>
			<li class="contact active">
				<div class="wrap">
					<div class="meta">
					   <p class="name">`+online[i].nama+`</p>
					</div>
				</div>
			</li>
		</ul>`
		}
			// console.log(chat[i].nama);
	}
	$("#contacts").html(str);	
}
function addData(chat, nama, scrol){
	var str = '';
	var str1 = '';
	var str2 = '';
	for (let i = 0; i < nama.length; i++) {
		str1 += nama[i].nama
		// console.log(nama[i].nama);
	}
	  for (let i = 0; i < chat.length; i++) {
		if(chat[i].pengirim == str1){
			str += `<ul><li class="sent">
			<p>Saya</br>`+chat[i].chat+`</br></br></br>`+chat[i].wkt+          `</p>
		</li>  </ul>`;
		}else{
			str += `<ul><li class="replies">
			<p>`+chat[i].pengirim+` - `+chat[i].level+`</br>`+chat[i].chat+`</br></br></br>`+chat[i].wkt+          `</p>
		</li>  </ul>`;
			}
		// console.log(nama[i].nama);
	}
	$(".messages").html(str);
	for (let i = 0; i < scrol.length; i++) {
		str2 += scrol[i].scrol
		// console.log(nama[i].nama);
	}
	if(str2 == str1){
	var elmnt = document.getElementById("messages");
	elmnt.scrollTop += 10000; 
	}
	 
}

$('.submit').click(function() {
	newMessage();
  });
	

  function newMessage() {
	//   message = $(".message-input input").val();
	  var elmnt = document.getElementById("messages");
	  elmnt.scrollTop += 10000; 
	  var f_asal	= $("#f_chat");
		var form	= getFormData(f_asal);
		document.getElementById('message').value = ''
	  if($.trim(message) == '') {
		  return false;
	  }
	  $.ajax({		
		type: "POST",
		url: base_url+"dtest/m_mapel/simpan1",
		data: JSON.stringify(form),
		dataType: 'json',
		contentType: 'application/json; charset=utf-8'
	}).done(function(response) {
		if (response.status == "ok") {
			// window.location.reload();
			// m_mapel_chat(form.id);
			
			// console.log(form);
		} else {
			alert(response.caption);
		}
	});
	return false;
	// $(".messages").animate({ scrollTop: $(document).height() }, "fast");
  };
  
  $(window).on('keydown', function(e) {
	if (e.which == 13) {
	  newMessage();
	  return false;
	}
  });

function m_ujian_v(id) {
	
	if (confirm('Anda yakin Memverifikasi Ujian..?')) {
$.ajax({
	type: "GET",
	url: base_url+"soal/m_ujian/verifikasi/"+id,
	success: function(response) {
		if (response == true) {
		
			window.location.reload();
		} else {
			console.log('gagal');
		}
	}
	
});
	}

return false;
}

function m_ujian_soal(id) {
    	$("#form_uji").modal('show');
	$.ajax({
		type: "GET",
		url: base_url+"soal/m_soal/det1/"+id,
		success: function(data) {
			$("#id_mapel").val(data.id_mapel);
			$("#id_guru").val(data.id_guru);
		
		}
	});
	
	return false;
	
		$.ajax({
		type: "GET",
		url: base_url+"soal/m_soal/det2/"+id,
		success: function(data) {
			$("#id_mapel").val(data.id_mapel);
			$("#id_guru").val(data.id_guru);
		
		}
	});
	
	return false;
}

function import_soal(id) {
    	$("#form_soal").modal('show');
	$.ajax({
		type: "GET",
		url: base_url+"soal/m_soal/det1/"+id,
		success: function(data) {
			$("#id_mapel2").val(data.id_mapel);
			$("#id_guru2").val(data.id_guru);
		
		}
	});
}


function m_ujian_edit(id) {
    	$("#form_uji").modal('show');
	$.ajax({
		type: "GET",
		url: base_url+"soal/m_soal/det2/"+id,
		success: function(data) {
		    $("#id").val(data.id);
			$("#mode").val(data.mode);
			$("#id_guru").val(data.id_guru);
			$("#id_mapel").val(data.id_mapel);
			$("#gambar_soal").val(data.file);
			$(".editornya").val(data.soal);
			$(".editornya_a").val(data.opsi_a);
			$(".editornya_b").val(data.opsi_b);
			$(".editornya_c").val(data.opsi_c);
			$(".editornya_d").val(data.opsi_d);
			$(".editornya_e").val(data.opsi_e);
			$("#jawaban").val(data.jawaban);
			$("#bobot").val(data.bobot);
		
		}
	});
	
	return false;
}



//ujian
function m_ujian_e(id) {
	$("#ujian_modal").modal('show');
	$.ajax({
		type: "GET",
		url: base_url+"soal/m_ujian/det/"+id,
		success: function(data) {
			$("#id").val(data.id);
			$("#mapel").val(data.id_mapel);
			$("#nama_ujian").val(data.nama_ujian);
			$("#jumlah_soal").val(data.jumlah_soal);
			$("#waktu").val(data.waktu);
			$("#terlambat").val(data.terlambat);
			$("#terlambat2").val(data.terlambat2);
			$("#tgl_mulai").val(data.tgl_mulai);
			$("#wkt_mulai").val(data.wkt_mulai);
			$("#acak").val(data.jenis);
			$("#token").val(data.status_token);
			__ambil_jumlah_soal(data.id_mapel);
		}
	});
	
	return false;
}

function m_ujian_a(id) {
	$("#ujian_modal").modal('show');
	document.getElementById("nama_ujian").value = '';
	document.getElementById("jumlah_soal").value = '';
	document.getElementById("waktu").value = '';
	document.getElementById("terlambat").value = '';
	document.getElementById("tgl_mulai").value = '';
	document.getElementById("acak").value = '';
	document.getElementById("token").value = '';

	$.ajax({
		type: "GET",
		url: base_url+"soal/m_ujian/det1/"+id,
		success: function(data) {
			$("#mapel").val(data.id_mapel);
			$("#terlambat2").val(data.terlambat2);
			$("#wkt_mulai").val(data.wkt_mulai);
			__ambil_jumlah_soal(data.id_mapel);
		}
	});
	
	return false;
}


function m_ujian_s() {
	console.log('ddd');
	var f_asal	= $("#f_ujian");
	var form	= getFormData(f_asal);
	$.ajax({		
		type: "POST",
		url: base_url+"soal/m_ujian/simpan",
		data: JSON.stringify(form),
		dataType: 'json',
		contentType: 'application/json; charset=utf-8'
	}).done(function(response) {
		if (response.status == "ok") {
// 			window.location.assign(base_url+"soal/m_ujian");
            window.location.reload(); 
		} else {
         alert(response.caption);
		}
	});
	return false;
}


function m_ujian_h(id) {
	if (confirm('Anda yakin..?')) {
		$.ajax({
			type: "GET",
			url: base_url+"soal/m_ujian/hapus/"+id,
			success: function(response) {
				if (response.status == "ok") {
				// 	window.location.assign(base_url+"soal/m_ujian/"+url3); 
					window.location.reload();
				} else {
					console.log('gagal');
				}
			}
		});
	}
	
	return false;
}
function refresh_token(id) {
	$.ajax({
		type: "GET",
		url: base_url+"soal/m_ujian/refresh_token/"+id,
		success: function(response) {
			if (response.status == "ok") {
				window.location.reload();	
			} else {
				console.log('gagal');
			}
		}
	});
	
	return false;
}

/* admindos las puerta conos il grande partite */
//siswa
function m_siswa_e(id) {
	$("#m_siswa_modif").modal('show');

	$("#id").val('');
	$("#kelompok").val('');
	$("#nama").val('');
	$("#username").val('');
	$("#pangkat").val('');			
	$("#nrp").val('');
	$("#telp").val('');
	$("#tempat").val('');
	$("#tanggal").val('');
	$("#nim").val('');
	$("#nik").val('');
	$("#email").val('');
	$("#alamat").val('');
	$("#id_jurusan").val('');
	$("#tahun_ajaran").val('');
	$("#nama").focus();
	
	return false;
}

function m_siswa_s() {
	var f_asal	= $("#f_siswa");
	var form	= getFormData(f_asal);
	$.ajax({		
		type: "POST",
		url: base_url+"pengusaha/m_siswa/simpan",
		data: JSON.stringify(form),
		dataType: 'json',
		contentType: 'application/json; charset=utf-8'
	}).done(function(response) {
		if (response.status == "ok") {
			window.location.assign(base_url+"pengusaha/data"); 
		} else {
			alert(response.caption);
		}
	});
	return false;
}
function m_siswa_h(id) {
	if (confirm('Anda yakin mau menghapus user ini..?')) {
		$.ajax({
			type: "GET",
			url: base_url+"pengusaha/m_siswa/hapus/"+id,
			success: function(response) {
				if (response.status == "ok") {
					window.location.assign(base_url+"pengusaha/data"); 
				} else {
					console.log('gagal');
				}
			}
		});
	}
	return false;
}
function m_siswa_u(id) {
	if (confirm('Anda yakin akan membuatkan password user ini ? ')) {
		$.ajax({
			type: "GET",
			url: base_url+"pengusaha/m_siswa/user/"+id,
			success: function(response) {
				if (response.status == "ok") {
					pageLoad(1,'pengusaha/page_load');
				} else {
					alert(response.caption);
				}
			}
		});
	}
	return false;
}

function m_siswa_ak(id,kondisi) {
	if (kondisi == 1) {
		y = confirm('Anda yakin akan mengaktifkan user ini ? ')
	}else{
		y = confirm('Anda yakin akan menonaktifkan user ini ? ')
	}
	if (y) {
		$.ajax({
			type: "GET",
			url: base_url+"pengusaha/aktif_non/"+id+"/"+kondisi,
			success: function(response) {
				if (response.status == "ok") {
					pageLoad(1,'pengusaha/page_load');
				} else {
					alert(response.caption);
				}
			}
		});
	}
	return false;
}
function m_siswa_ur(id) {
	if (confirm('Password akan sesuai dengan username !! ..!')) {
		$.ajax({
			type: "GET",
			url: base_url+"pengusaha/m_siswa/user_reset/"+id,
			success: function(response) {
				if (response.status == "ok") {
					pageLoad(1,'pengusaha/page_load');
				} else {
					alert(response.caption);
				}
			}
		});
	}
	return false;
}
function m_siswa_non_aktif(id) {
	if (confirm('Anda yakin akan menonaktifkan user ini..?')) {
		$.ajax({
			type: "GET",
			url: base_url+"pengusaha/m_siswa/non_aktifkan/"+id,
			success: function(response) {
				if (response.status == "ok") {
					window.location.assign(base_url+"pengusaha/m_siswa"); 
				} else {
					alert(response.caption);
				}
			}
		});
	}
	return false;
}
function m_guru_t() {
	$("#m_guru").modal('show');
}
//guru
function m_guru_e(id) {
	$('#m_siswa_modif').modal({backdrop: 'static', keyboard: false})  

	$("#id").val('');
	$("#ta").val('');
	$("#nidn").val('');
	$("#nrp").val('');
	$("#nama").val('');
	$("#username").val('');
	$("#pangkat").val('');
	$("#ja").val('');
	$("#tempat").val('');
	$("#tanggal").val('');
	$("#alamat").val('');
	$("#email").val('');
	$("#telp").val('');
	$("#status").val('');
	$("#put").val('');
	$("#pmt").val('');
	$("#ta").focus();
	
	return false;
}
function m_guru_detail(id) {
	$("#guru_profil").modal('show');
	$.ajax({
		type: "POST",
		url: base_url+"trainer/profil/",
		data : {
			id : id
		},
		success: function(response) {
			$('#profile-photo').attr('src',response.location + response.data.photo)
			$("#profile-nip").text(response.data.nip);
			$("#profile-nama").text(response.data.nama);
			if(response.data.jenis_kelamin == 1){
				jk = 'Laki-Laki';
			}else if(response.data.jenis_kelamin == 2){
				jk = 'Prempun'
			}else{
				jk = '';
			}

			$("#profile-jk").text(jk);
			$("#profile-telp").text(response.data.no_tlp);
			$("#profile-pekerjaan").text(response.data.pekerjaan);
		
			$("#profile-cv").text(response.data.cv);
		}
	});
	return false;
}
function m_guru_profil(id) {
	$("#guru_profil").modal('show');
	
}
// function m_guru_s() {
// 	var f_asal	= $("#f_guru");
// 	var form	= getFormData(f_asal);
// 	$.ajax({		
// 		type: "POST",
// 		url: base_url+"trainer/m_guru/simpan",
// 		data: JSON.stringify(form),
// 		dataType: 'json',
// 		contentType: 'application/json; charset=utf-8'
// 	}).done(function(response) {
// 		if (response.status == "ok") {
// 			window.location.assign(base_url+"trainer/m_guru"); 
// 		} else {
// 			alert(response.caption);
// 		}
// 	});
// 	return false;
// }

function m_guru_s(){
	  
	var f_asal	= $("#f_guru")[0];
    var formData = new FormData(f_asal);

    $.ajax({
		url: base_url+"trainer/m_guru/simpan",
		type: 'POST',
		enctype: 'multipart/form-data',
        data: formData,
        success: function (response) {
            	alert(response.caption);
            if (response.status == "ok") {
				window.location.assign(base_url+"trainer/m_guru"); 
			} else {
				alert(response.caption);
			}
        },
        cache: false,
        contentType: false,
        processData: false
	});
	
	return false;
}

function m_guru_h(id) {
	if (confirm('Anda yakin..?')) {
		$.ajax({
			type: "GET",
			url: base_url+"trainer/m_guru/hapus/"+id,
			success: function(response) {
				if (response.status == "ok") {
					pageLoad(1,'trainer/page_load');
				} else {
					console.log('gagal');
				}
			}
		});
	}
	return false;
}
function m_guru_u(id) {
	if (confirm('Anda yakin..? untuk mengaktifkan akun ini ')) {
		$.ajax({
			type: "GET",
			url: base_url+"trainer/m_guru/user/"+id,
			success: function(response) {
				if (response.status == "ok") {
					pageLoad(1,'trainer/page_load');
				} else {
					alert(response.caption);
				}
			}
		});
	}
	return false;
}
function m_guru_ur(id) {
	if (confirm('Anda yakin..? username dan Password otomatis adalah username ..!')) {
		$.ajax({
			type: "GET",
			url: base_url+"trainer/m_guru/user_reset/"+id,
			success: function(response) {
				if (response.status == "ok") {
					alert(response.caption);
					pageLoad(1,'trainer/page_load');
				} else {
					alert(response.caption);
				}
			}
		});
	}
	return false;
}
function m_guru_matkul(id) {
	$.ajax({
		type: "GET",
		url: base_url+"trainer/m_guru/ambil_matkul/"+id,
		success: function(data) {
			if (data.status == "ok") {
				var jml_data	= Object.keys(data.data).length;
				var hate 	= '<div class="modal fade" id="m_siswa_matkul" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog modal-sm" role="document"><div class="modal-content"><div class="modal-header">&times;<h4 id="myModalLabel">Setting Materi</h4></div><div class="modal-body"><form name="f_siswa_matkul" id="f_siswa_matkul" method="post" onsubmit="return m_guru_matkul_s();"><input type="hidden" name="id_mhs" id="id_mhs" value="'+id+'"><div id="konfirmasi"></div>';
				
				if (jml_data > 0) {
					$.each(data.data, function(i, item) {
						if (item.ok == "1") {
							hate += '<label><input type="checkbox" value="'+item.id+'" name="id_mapel_'+item.id+'" checked> &nbsp;'+item.nama+'</label> &nbsp;&nbsp; ';
						} else {
							hate += '<label><input type="checkbox" value="'+item.id+'" name="id_mapel_'+item.id+'"> &nbsp;'+item.nama+'</label> &nbsp;&nbsp; ';
						}
					});				
				} else {
					hate += 'Belum ada data..';
				}
				hate += '<div class="modal-footer"><button class="btn btn-primary" type="submit">Simpan</button><button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button></div></form></div></div></div>';
				$("#tampilkan_modal").html(hate);
				$("#m_siswa_matkul").modal('show');
			} else {
				console.log('gagal');
			}
		}
	});
	return false;
}
function m_guru_matkul_s() {
	var f_asal	= $("#f_siswa_matkul");
	var form	= getFormData(f_asal);
	$.ajax({		
		type: "POST",
		url: base_url+"trainer/m_guru/simpan_matkul",
		data: JSON.stringify(form),
		dataType: 'json',
		contentType: 'application/json; charset=utf-8'
	}).done(function(response) {
		if (response.status == "ok") {
			alert(response.caption);
			pageLoad(1,'trainer/page_load'); 
			$("#m_siswa_matkul").modal('hide');
		} else {
			console.log('gagal');
		}
	});
	
	return false;
}
//mapel
function m_mapel_e(id) {
	$("#m_mapel").modal('show');
	$.ajax({
		type: "GET",
		url: base_url+"dtest/m_mapel/det/"+id,
		success: function(data) {
			$("#id").val(data.id);
			$("#nama").val(data.nama);
			$("#nama").focus();

			$("#kd_mp").val(data.kd_mp);
			$("#sks").val(data.sks);
			$("#semester").val(data.semester);
			$("#angkatan").val(data.angkatan);
		}
	});
	return false;
}
function m_mapel_s() {
	var f_asal	= $("#f_mapel");
	var form	= getFormData(f_asal);
	$.ajax({		
		type: "POST",
		url: base_url+"dtest/m_mapel/simpan",
		data: JSON.stringify(form),
		dataType: 'json',
		contentType: 'application/json; charset=utf-8'
	}).done(function(response) {
		if (response.status == "ok") {
			pageLoad(1,'dtest/page_load'); 
			$("#m_mapel").modal('hide');
		} else {
			console.log('gagal');
		}
	});
	return false;
}
function get_mapel(id) {
    return new Promise(function(resolve, reject) {
        let options = '';
        $.get(base_url + "/Materi/get_mapel/true/" + id, function(res) {
            if(res != null) {
                resolve(res);
            }
            else {
                reject(res);
            }
        });
    });
}
function m_mapel_h(id) {
    let options = '', data='';
	if (confirm('Anda yakin?')) {
		$.post(base_url + 'dtest/m_mapel/hapus/', {id:id}, function(res) {
           pageLoad(1,'dtest/page_load');
       });
	   // $.get(base_url + "Materi/check_sub_modul/" + id, function(res) {
    //        res = JSON.parse(res);
    //        if(res.sum_data > 0) {
    //     	   $('input[name=aksi_hapus_modul]').on('change', function(e) {
    //     	       // Jika Hapus sub modul semua FALSE
    //     	       if(this.value == 0) {
    //     	           get_mapel(id).then(function(res) {
    //     	               res = JSON.parse(res);
    //     	               res.data.forEach(function(option) {
    //     	                   options += `<option class="ganti-modul" value="${option.id}">${option.nama}</option>`;
    //     	               });
    //                        $('select[name=id_pindah_modul]').html(options); 
    //                        $('select[name=id_pindah_modul]').removeClass('d-none'); 
                           
    //                        $('#label-pindah-modul').removeClass('d-none'); 
    //     	           }).then(function() {
    //     	               data = {id:id, modul:$('#select-ganti-modul option:selected').val()};     
    //     	           });        
        	           
    //     	       }
    //     	       else {
    //     	           $('select[name=id_pindah_modul]').html(''); 
    //                    $('select[name=id_pindah_modul]').addClass('d-none'); 
    //                    $('#label-pindah-modul').addClass('d-none'); 
    //     	           data = {id:id};
    //     	       }
        	       
    //     	       $('#hapus-modul').click(function(e) {
    //     	           e.preventDefault();
    //     	           $.post(base_url + 'dtest/m_mapel/hapus/', data, function(res) {
    //         	           pageLoad(1,'dtest/page_load');
    //         	            $('#hapus_mapel').modal('toggle');
    //         	       });
    //     	       });
    //     	   });        
    //        }
    //        else {
    //            data = {id:id};
    //            $.post(base_url + 'dtest/m_mapel/hapus/', data, function(res) {
    // 	          pageLoad(1,'dtest/page_load');
    // 	           $('#hapus_mapel').modal('toggle');
    // 	       });
    //        }
    //     });
	   
	   // if(confirm('Semua sub modul akan terhapus!, anda yakin?'))
    // 		$.ajax({
    // 			type: "GET",
    // 			url: base_url+"dtest/m_mapel/hapus/"+id,
    // 			success: function(response) {
    // 				if (response.status == "ok") {
    // 					window.location.assign(base_url+"dtest/m_mapel"); 
    // 				} else {
    // 					console.log('gagal');
    // 				}
    // 			}
    // 		});
	}
	return false;
}
function __ambil_jumlah_soal(id_mapel) {
	$.ajax({
		type: "GET",
		url: base_url+"soal/m_ujian/jumlah_soal/"+id_mapel,
		success: function(response) {
			$("#jumlah_soal1").val(response.jumlah);	
		}
	});
	return false;
}

//rubah  password modal show
function rubah_password() {
	$.ajax({
		type: "GET",
		url: base_url+"adm/rubah_password/",
		success: function(response) {
			// var teks_modal = '<div class="modal fade" id="m_ubah_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header">&times;<h4 id="myModalLabel">Update password</h4></div><div class="modal-body"><form name="f_ubah_password" id="f_ubah_password" onsubmit="return rubah_password_s();" method="post"><input type="hidden" name="id" id="id" value="'+response.id+'"><div id="konfirmasi"></div><table class="table table-form"><tr><td style="width: 25%">Username</td><td style="width: 75%"><input type="text" class="form-control" name="u1" id="u1" required value="'+response.username+'" readonly></td></tr><tr><td style="width: 25%">Password lama</td><td style="width: 75%"><input type="password" class="form-control" name="p1" id="p1" required></td></tr><tr><td style="width: 25%">Password Baru</td><td style="width: 75%"><input type="password" class="form-control" name="p2" id="p2" required></td></tr><tr><td style="width: 25%">Ulangi Password</td><td style="width: 75%"><input type="password" class="form-control" name="p3" id="p3" required></td></tr></table></div><div class="modal-footer"><button class="btn btn-primary" onclick="return rubah_password_s();"><i class="fa fa-check"></i> Simpan</button><button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button></div></form></div></div></div>';
			var teks_modal = `
				<div class="modal fade" id="modalpassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Ubah Password</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
						<form name="f_ubah_password" id="f_ubah_password" onsubmit="return rubah_password_s();" method="post">
							${response.csrf}
							<input type="hidden" name="id" id="id" value="${response.data.id}">
							<div id="konfirmasi"></div>
								<table class="table table-form">
									<tr>
										<td style="width: 25%">Username</td>
										<td style="width: 75%"><input type="text" class="form-control" name="u1" id="u1" required value="${response.data.usernames}" readonly></td>
									</tr>
									<tr>
										<td style="width: 25%">Password lama</td><td style="width: 75%"><input type="password" class="form-control" name="p1" id="p1" required></td>
										</tr>
										<tr><td style="width: 25%">Password Baru</td><td style="width: 75%">
										<input type="password" class="form-control" name="p2" id="p2" required></td>
									</tr>
									<tr>
										<td style="width: 25%">Ulangi Password</td>
										<td style="width: 75%"><input type="password" class="form-control" name="p3" id="p3" required></td>
									</tr>
								</table>
							</div>
							<div class="modal-footer">
								<button class="btn btn-primary" onclick="return rubah_password_s();"><i class="fa fa-check"></i> Simpan</button>
								<button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button>
							</div>
						</form>
						</div>
						</div>
					</div>
				</div>
			`;
			
			$("#tampilkan_modal").html(teks_modal);
			$("#modalpassword").modal('show');
			$("#p1").focus();
		}
	});
	return false;
}
//rubah password Simpan
function rubah_password_s() {
	var f_asal	= $("#f_ubah_password");
	var form	= getFormData(f_asal);
	$.ajax({		
		type: "POST",
		url: base_url+"adm/rubah_password/simpan",
		data: JSON.stringify(form),
		dataType: 'json',
		contentType: 'application/json; charset=utf-8'
	}).done(function(response) {
		if (response.status == "ok") {
			$("#konfirmasi").html('<div class="alert alert-success">'+response.msg+'</div>');
			$("#m_ubah_password").modal('hide');
			alert(response.msg);
		} else {
			$("#konfirmasi").html('<div class="alert alert-danger">'+response.msg+'</div>');
		}
	});
	return false;
}