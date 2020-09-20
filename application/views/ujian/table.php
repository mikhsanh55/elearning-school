<style>
	.opsi {
		max-width: 200px;
		overflow: auto;
	}
</style>
<table class="table table-bordered table-striped table-hovered" id="ujian-table">
	<thead>
		<tr>
			<th class="frist"><input type="checkbox" name="checkall" id="checkall"></th>
			<th class="frist">No</th>
			<th>Tipe Ujian</th>
			<th>Nama Ujian</th>
			<?php if($this->log_lvl === 'siswa') : ?>
				<th>Guru</th>
				<th>Mata Pelajaran</th>	
			<?php endif; ?>
			<th>Waktu Mulai</th>
			<th class="frist">Opsi</th>
		</tr>
	</thead>
	<tbody>
		<?php $i= $page_start; foreach ($paginate['data'] as $rows):
			$soal = $this->m_soal_ujian->count_by(['id_ujian'=>$rows->id]);
			if (!empty($rows->tgl_mulai) && $rows->tgl_mulai != '0000-00-00 00:00:00') {
				$datetime1 = explode(' ', $rows->tgl_mulai);
				$date = longdate_indo($datetime1[0]).' Pukul '.$time = time_short($datetime1[1]);
				
			}else{
				$date = NULL;
			}

			// Button for Guru
			$tambahKelasBtn = '<a href="javascript:void(0);" class="btn btn-primary btn-sm ml-2 mr-2 mb-2 show-kelas" data-guru="'.$rows->id_guru.'" data-ujian="'.$rows->id.'">Tambah Kelas</a>';
			$soalPg = '<a href="'.base_url('ujian_real/data_soal/'.encrypt_url($rows->id)).'" class="btn btn-primary btn-sm ml-2 mr-2 mb-2">Soal PG</a>';
			$soalEssay = '<a href="'.base_url('ujian_essay/data_soal/'.encrypt_url($rows->id)).'" class="btn btn-primary btn-sm ml-2 mr-2  mb-2">Soal Essay</a>';
			$cekHasilPg = $this->m_ikut_ujian->count_by(['id_ujian'=>$rows->id,'status'=>'N']);
			$cekHasilEssay = $this->m_ikut_ujian_essay->count_by(['id_ujian'=>$rows->id,'status'=>'N']);

			$ulangUjianBtn = ($cekHasilEssay > 0 || $cekHasilPg > 0) ? '<a href="javascript:void(0);" class="btn btn-danger btn-sm mr-2  mb-2 ulang-ujian" data-id="'.$rows->id.'" data-izin="'.$rows->izin.'" data-soal="'.$soal.'">Ulang ujian</a>' : NULL;
			$cekHasilPg = $cekHasilPg > 0 ? '<button type="button" class="btn btn-info btn-sm mr-2  mb-2" onclick="window.location = `'.base_url('ujian_real/result/'.encrypt_url($rows->id)).'`"  data-toggle="tooltip" title="">Hasil PG</button>' : NULL;

			
			$cekHasilEssay = $cekHasilEssay > 0 ? '<button type="button" class="btn btn-info btn-sm mr-2  mb-2" onclick="window.location = `'.base_url('ujian_essay/result/'.encrypt_url($rows->id)).'`"  data-toggle="tooltip" title="">Hasil Essay</button>' : NULL;
			

			// Button for Admin
			$izinUjian = $rows->izin === 0 ? '<a href="javascript:void(0);" class="btn btn-success btn-sm mr-2  mb-2 izinkan" data-id="'.$rows->id.'" data-izin="'.$rows->izin.'" data-soal="'.$soal.'">Izinkan Ujian</a>' : '<a href="javascript:void(0);" class="btn btn-danger btn-sm mr-2  mb-2 izinkan" data-id="'.$rows->id.'" data-izin="'.$rows->izin.'" data-soal="'.$soal.'">Batalkan Ujian</a>';
			$noSoal = '<button type="button" class="btn btn-danger btn-sm mr-2  mb-2" disabled data-toggle="tooltip" title="Soal Belum Tersedia">Soal Belum Ada</button>';

			// Button for Siswa
			$jumlah_soal_pg = $this->m_soal_ujian->count_by(['id_ujian' => $rows->id]);
			$cekSudahPg = $this->m_ikut_ujian->count_by(['id_ujian'=>$rows->id,'id_user'=>$this->akun->id,'status'=>'N']);
			$cekSudahPg = $cekSudahPg > 0 ? '<button type="button" class="btn btn-success btn-sm mr-2  mb-2" onclick="window.location = `'.base_url('ujian_real/ikuti_ujian/'.encrypt_url($rows->id)).'`"  data-toggle="tooltip" title="" disabled>Sudah PG</button>' : ($jumlah_soal_pg  > 0 ? '<a class="btn btn-success btn-sm mr-2  mb-2" href="'.base_url('ujian_real/ikuti_ujian/'.encrypt_url($rows->id)).'"  data-toggle="tooltip" title="">Mulai PG</a>' : '<span class="btn btn-danger btn-sm text-center">Belum ada soal</span>');

			$jumlah_soal_essay = $this->m_soal_ujian_essay->count_by(['id_ujian' => $rows->id]);
			$cekSudahEssay = $this->m_ikut_ujian_essay->count_by(['id_ujian'=>$rows->id,'id_user'=>$this->akun->id,'status'=>'N']);
			$cekSudahEssay = $cekSudahEssay > 0 ? '<button class="btn btn-success btn-sm mr-2  mb-2" data-toggle="tooltip" title="" disabled>Sudah Essay</button>' : ( $jumlah_soal_essay > 0 ? ' <a class="btn btn-success btn-sm mr-2  mb-2" href="'.base_url('ujian_essay/ikuti_ujian/'.encrypt_url($rows->id)).'" data-toggle="tooltip" title="">Mulai Essay</a> ' : '<span class="btn btn-danger btn-sm text-center">Belum ada soal</span>' );
			$noJadwal = '<span class="btn btn-danger btn-sm text-center">Belum masuk jadwal</span>';


		?>
			<tr>
				<td><input type="checkbox" name="checklist[]" class="checklist" data-id= "<?=encrypt_url($rows->id);?>" value="<?=$rows->id;?>"></td>
				<td align="center" class="frist"><?=$i;?></td>
				<td>
					<?= $rows->type_ujian == 'uas' ? 'UAS' : ($rows->type_ujian == 'uts' ? 'UTS' : 'Ujian Harian') ?>		
				</td>
				
				<td><?=$rows->nama_ujian;?></td>
				<?php if($this->log_lvl === 'siswa') : 
					$nama_guru = $this->m_guru->get_by(['id' => $rows->id_guru]);
					$nama_guru = (!empty($nama_guru)) ? $nama_guru->nama : '';
				?>	
					<td><?= $nama_guru; ?></td>
					<td><?= $rows->nama_mapel; ?></td>
				<?php endif; ?>
				<td><?=$date;?></td>

				<!-- New Refactored -->
				<td class="opsi text-center">
					<?php switch($this->log_lvl) { 
						case 'guru' :
							echo $tambahKelasBtn;
							echo $soalPg;
							echo $soalEssay;
							echo $cekHasilPg;
							echo $cekHasilEssay;
							echo $ulangUjianBtn;
						break;

						case 'admin':
						case 'instansi':
							if($soal > 0) {
								echo $izinUjian;
							}
							else {
								echo $noSoal;
							}
							echo $tambahKelasBtn;
							echo $soalPg;
							echo $soalEssay;
							echo $cekHasilPg;
							echo $cekHasilEssay;
							echo $ulangUjianBtn;
						break;

						case 'siswa':
							if($rows->in_jadwal === TRUE) {
								echo $cekSudahPg;
								echo $cekSudahEssay;
							}
							else {
								echo $noJadwal;
							} 
						break;
					}
					?>
					
				</td>
			</tr>
		<?php $kelasNama = NULL; $i++;endforeach ?>
	</tbody>
</table>
<script src="<?=base_url();?>assets/js/jquery/jquery-3.3.1.min.js"></script>
<script src="<?= base_url('assets/plugin/datatables/jquery.dataTables.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script>
    $(document).ready(function() {
    	var conf = '';
    	$('[data-toggle="tooltip"]').tooltip();   
        $('#ujian-table').DataTable({
            responsive: true,
            paging: false,
            info: false
        });
        $(document).on('click', '.ulang-ujian', function() {
			conf = confirm('Seluruh data hasil ujian akan terhapus, yakin?');
			if(conf) {
				$.ajax({
					type:'post',
					url : '<?=base_url('ujian/batalkan-ujian');?>',
					dataType : 'json',
					data : {
						id   : $(this).data('id'),
						izin : $(this).data('izin'),
						soal : $(this).data('soal'),
					},
					success:function(response){
						alert(response.msg);
						pageLoad(1,'ujian_real/page_load');
					}
				})
			}
			else {
				return false;
			}
		});

		$(document).on('click','.izinkan',function(){
			conf = confirm('Apakah anda yakin akan mengizinkan ujian ?');
			if (conf == true) {
				$.ajax({
					type:'post',
					url : '<?=base_url('ujian_real/izinkan');?>',
					dataType : 'json',
					data : {
						id   : $(this).data('id'),
						izin : $(this).data('izin'),
						soal : $(this).data('soal'),
					},
					success:function(response){
						alert(response.message);
						pageLoad(1,'ujian_real/page_load');
					}
				})
			}else{
				return false;
			}
		})
    });
</script>