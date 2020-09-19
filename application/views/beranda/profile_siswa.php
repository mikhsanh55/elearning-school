<style type="text/css">

	.success{

		background: #c4ffbb;

		padding: 10px;

		border: 3px solid #000;

		border-radius: 10px;

		text-align: center;

		width: 500px;

		margin:auto;
	}

	.errors{

		background: #ffc8bb;

		padding: 10px;

		border: 3px solid #000;

		border-radius: 10px;

		text-align: center;

		width: 500px;

		margin:auto;
	}

	.center {

		margin: auto;

		width: 60%;

		border: 3px solid #73AD21;

		padding: 10px;

	}

    .title-profile{
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        text-rendering: auto;
        line-height: 1;
        margin-right:1rem !important;
        width:150px;
        border:0px solid #000;
    }

    .fa-edit:hover {
        cursor:pointer;
    }

    @keyframes rot {
      0% {
          transform:rotate(0deg);
      }
      100% {
          transform:rotate(360deg);
      }
  }
  .spin-icon {
      animation:rot 1s linear infinite;   
  }
  .round {
    border-radius: 50%;
  }
</style>

<div class="col-md-9 page-content">
	<div class="inner-box">
        <h2>Profile</h2>
        <div id="msg">
            <?= $this->session->flashdata('msg'); ?>
        </div>
        <header class="row align-items-center">
            <div class="col-sm-12 d-flex justify-content-start col-md-6 mb-4">
                <div class="ml-2 mr-4">
                    <img class="round" src="<?= is_null($data->image) ? 'assets/img/avatar-default.jpg' : base_url($data->image); ?>" alt="" width="110" height="110" id="avatar">
                </div>
                <div>
                    <h3 style="padding-bottom:10px;"><?= $data->nama; ?></h3>
                    <p class="text-secondary p-0">
                        <span class="text-secondary d-block mb-1" style="font-size: 110%;"><?= ($this->log_lvl) . ' - ' . $kelas->nama_kelas; ?></span>
                        <small class="text-primary d-block"><?= $data->nim; ?></small>
                    </p>
                    <section class="btn-section d-flex">
                        <button class="btn btn-outline-primary btn-sm  mr-2 pl-2 pr-2 pt-1 pb-1" id="edit-profile">
                            Edit Profile
                        </button>
                        <a href="<?= base_url('kelas/siswa'); ?>" class="btn btn-outline-info btn-sm btn-block">
                            Mulai Belajar
                        </a>
                    </section>
                </div>
            </div>
            <!-- Info lainnya -->
            <div class="col-md-6" style="border-left: 1px solid #ccc;">
                <table class="table table-borderless">
                    <tr>
                        <th>NIS</th>
                        <td><?= $data->nrp; ?></td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td><?= $data->username; ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= $data->email; ?></td>
                    </tr>
                    <tr>
                        <th>No. Telpon</th>
                        <td><?= $data->no_telpon; ?></td>
                    </tr>
                </table>
            </div>
        </header>

    </div>
</div>
<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="edit-profile-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" id="form-edit-profile" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">Edit Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center" id="img-edit-modal">
             <img class="round" src="<?= is_null($data->image) ? 'assets/img/avatar-default.jpg' : base_url($data->image) ?>" alt="" width="110" height="110" id="avatar">
        </div>
            <input type="hidden" name="id" id="id" value="<?= encrypt_url($data->id); ?>">
            <div class="form-group">
                <label for="">Nama<strong class="text-danger">*</strong></label>
                <input type="text" class="form-control" name="nama" id="nama-input" value="<?= $data->nama; ?>" required>
            </div>
            <div class="form-group">
                <label for="">Agama<strong class="text-danger">*</strong></label>
                <input type="text" class="form-control" name="agama" id="agama-input" value="<?= $data->nim; ?>" required>
            </div>
            <div class="form-group">
                <label for="">Email<strong class="text-danger">*</strong></label>
                <input type="text" class="form-control" name="email" id="email-input" value="<?= $data->email; ?>" required>
            </div>
            <div class="form-group">
                <label for="">No.Telpon<strong class="text-danger">*</strong></label>
                <input type="text" class="form-control" name="no_telpon" id="no-telpon-input" value="<?= $data->no_telpon; ?>" required>
            </div>
            <div class="form-group">
                <label for="">Foto</label>
                <input type="file" class="form-control" name="image" id="image-input">
            </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
      </form>
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
        let formData;
        $('#edit-profile').click(e => {
            e.preventDefault();
            $('#edit-profile-modal').modal('show');
        });

        $('#form-edit-profile').on('submit', function(e) {
            e.preventDefault();
            formData = new FormData();
            formData.append('id', $('#id').val());
            formData.append('nama', $('#nama-input').val());
            formData.append('agama', $('#agama-input').val());
            formData.append('email', $('#email-input').val());
            formData.append('no_telpon', $('#no-telpon-input').val());

            if($('#image-input').prop('files').length > 0) {
                formData.append('image', $('#image-input').prop('files')[0]);
            }

            $.ajax({
                type: 'post',
                url: "<?= base_url('profile/update'); ?>",
                processData: false,
                contentType: false,
                data: formData,
                dataType: 'json',
                success: res => {
                    $('#edit-profile-modal').modal('hide');
                    window.location.reload();
                },
                error: e => {
                    console.error(e.responseText);
                    alert(e.responseJSON.msg);
                    return false;
                }
            });
        });
    });
</script>