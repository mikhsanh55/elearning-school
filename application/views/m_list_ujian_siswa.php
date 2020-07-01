<div class="row col-md-12 ini_bodi">
  <div class="panel panel-info">
    <div class="panel-heading">Daftar Ujian / Tes</div>
    <div class="panel-body">
      <div style="overflow: auto">
           <?php  if ($this->session->userdata('admin_level') == 'siswa'): ?>
        <a href="<?=base_url('ujian/export_pdf/'.$this->uri->segment(3).'');?>" class="btn btn-danger mb-4">Export PDF</a>
      <?php endif;?>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th width="5%">No</th>
              <th width="20%">Nama Tes</th>
              <th width="20%">Materi / Trainer</th>
              <th width="10%">Jumlah Soal</th>
              <th width="10%">Waktu</th>
             <?php  if ($sess_level == 'siswa'): ?>
                <th>Hasil</th>
             <?php endif;?>
              <th width="15%">Opsi</th>
            </tr>
          </thead>

          <tbody>
            <?php 
             $total = 0;
              if (!empty($data)) {
                $no = 1;
               
                foreach ($data as $d) {
                  $where = array(
                    'id_tes'  => $d->id, 
                    'id_user' => $sess_konid,
                    'status'  => 'N'
                  );


                  $checking = $this->db->select("
                                  count(ujian.id) as jmlh,
                              ")
                              ->from('tr_ikut_ujian ujian')
                              ->join('tr_guru_tes tes',' tes.id = ujian.id_tes ','inner')
                              ->where($where)
                              ->get()
                              ->row();

                  echo '<tr>
                        <td class="ctr">'.$no.'</td>
                        <td>'.$d->nama_ujian.'</td>
                        <td>'.$d->nmmapel .' ('.$d->nmguru.')</td>
                        <td class="ctr">'.$d->jumlah_soal.'</td>
                        <td class="ctr">'.$d->waktu.' menit</td>';
                     if ($sess_level == 'siswa'):
                        echo '<td>'.$d->hasil.'</td>';
                        $total += $d->hasil;
                     endif;

                      echo  '<td class="d-flex justify-content-center">';
                  
                    if ($checking->jmlh > $this->jumlah_pengecekan_ujian_selesai) {
                      echo '<a href="javascript:void(0);" data-jumlah="'.$checking->jmlh.'" class="block-act btn btn-info btn-sm mr-2"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff" ></i> &nbsp;&nbsp;Ikuti Tes</a>';
                    }else{
                        echo '<a href="'.base_url().'ujian/ikut_ujian/token/'.$d->id.'/'.$d->penggunaan.'" target="_blank" class="btn btn-success btn-sm mr-2"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Ikuti Tes</a>';
                    }
                  

                    echo '<a href="'.base_url().'ujian/sudah_selesai_ujian/'.$d->id.'/'.$id_mapel.'" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-ok" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Lihat Hasil</a>';

                  echo '</td></tr>';
                $no++;
                }
              } else {
                echo '<tr><td colspan="7">Belum ada data</td></tr>';
              }
            ?>
          </tbody>
        </table>
        <?php if ($sess_level == 'siswa'): ?>
           <p class="btn btn-success">Total Nilai : <?=$total;?></p>
        <?php endif ?>
       
        </div>  
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$('.block-act').click(function(){
    jumlah = $(this).data('jumlah');
    alert('Maksimal mengikuti test hanya '+ <?=$this->total_tes_only;?>+' kali!');
});
</script>