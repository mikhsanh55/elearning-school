	</aside>
</div>

<div class="col-md-9">
		<div class="inner-box">
			<header><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<button class="btn btn-success btn-sm mt-4" id="showModal">Tambah Jenis Usaha</button>
			</header>
			<div id="accordion" class="panel-group">
				<table class="table table-bordered table-striped mt-4">
				<thead>
					<tr>
						<th width="20">No</th>
						<th>Nama</th>
						<th class="text-center w-25">Aksi</th>
					</tr>
				</thead>
				<tbody id="sa">
				</tbody>
			</table>
			</div>
		</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-jenis-usaha">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Jenis Usaha</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<input type="text" name="title" class="form-control mb-3" id="nama-usaha" placeholder="Jenis Usaha">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm btn-modal" id="tambah-usaha">Tambah <i id="spin-icon" class="ml-2 hide fas fa-spinner"></i></button>
        <button type="button" class="d-none btn btn-primary btn-sm btn-modal" id="update-usaha">Update <i id="spin-icon" class="ml-2 hide fas fa-spinner"></i></button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		let no = 0, html = '';

		function putData(url, data) {
			$.ajax({
				type:"POST",
				url:url,
				data:data,
				dataType:"JSON",
				success:function(res) {
				    console.log(res);
					$('#modal-jenis-usaha').modal('hide');
					window.location.reload();
				}
			});
		}

		function postData(url, data) {
			$.ajax({
				type:"POST",
				url:url,
				data:data,
				dataType:"JSON",
				success:function(res) {
					$('#modal-jenis-usaha').modal('hide');
					getData("<?= base_url('pengusaha/get_jenis_usaha_ajax'); ?>");
				}
			});
		}
		
		function deleteData(url, data) {
		    let conf = confirm('Anda Yakin!');
		    if(conf) {
		        $.ajax({
		            type:"POST",
		            url:url,
		            data:data,
		            dataType:"JSON",
		            success:function(res) {
		                $('#modal-jenis-usaha').modal('hide');
					    getData("<?= base_url('pengusaha/get_jenis_usaha_ajax'); ?>");
		            }
		        });
		    }
		}
		function getData(url) {
			html = '', no = 0;
			$('tbody').empty();
			$.ajax({
				type:"GET",
				url:url,
				dataType:"JSON",
				success:function(res) {
				    $('tbody').empty();
					res.data.forEach(function(d) {
						html += `<tr>
							<td>${++no}</td>
							<td>${d.nama}</td>
							<td class="text-center">
								<a href="#" data-ju="${d.id}" class="btn btn-primary btn-sm mr-3 edit-usaha">Edit</a> 
								<a href="#" data-ju="${d.id}" class="btn btn-danger btn-sm delete-usaha">Hapus</a>
							</td>
						</tr>`;
					});

					$('#sa').html(html);
					$('.edit-usaha').on('click', function(e) {
						e.preventDefault();
						
				        $('#tambah-usaha').addClass('d-none');
				        $('#update-usaha').removeClass('d-none');
						$('#modal-jenis-usaha').modal('show');
						let ju = this.getAttribute('data-ju'),
						nodeVal = $(this).parent().prev().text();
						$('input[type=text][name=title]').val(nodeVal);

                        console.log(ju);
						$('#update-usaha').click( function(e) {
							e.preventDefault();

							if($('#nama-usaha').val() != '') {
							    putData("<?= base_url('pengusaha/put_jenis_usaha_ajax') ?>", { nama:$('#nama-usaha').val(), ju:ju });
							}
							else {
								alert('Isi nama usaha anda !');
								$('#modal-jenis-usaha').modal('hide');
								return false;
							}
						});
					});
					
					$('.delete-usaha').click(function(e) {
					    e.preventDefault();
					    
					    let ju2 = this.getAttribute('data-ju');
					    deleteData("<?= base_url('pengusaha/delete_jenis_usaha_ajax') ?>", {ju:ju2});
					})
				}
			});
		}

		getData("<?= base_url('pengusaha/get_jenis_usaha_ajax') ?>");

		$('#tambah-usaha').click(function(e) {
			e.preventDefault();

			if($('#nama-usaha').val() != '') {
				postData("<?= base_url('pengusaha/post_jenis_usaha_ajax') ?>", {nama:$('#nama-usaha').val()});
			}
			else {
				alert('Isi nama usaha anda !');
				return false;
			}
		});

		$('#showModal').click(function(e) {
			e.preventDefault();
			
			$('#tambah-usaha').removeClass('d-none');
		    $('#update-usaha').addClass('d-none');
		    $('#modal-jenis-usaha').modal('show');
		});
	})
</script>