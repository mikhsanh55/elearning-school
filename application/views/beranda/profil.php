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
  .grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(16rem, 1fr));
    grid-gap: 15px;
    width: 100%;
    align-items: start;
  }
  .card {
    transition: ease .2s;
  }
  .card:hover {
    box-shadow: 0 0 5px 3px #ccc;
  }

</style>

<div class="col-md-9 page-content mb-4">
    <header>
        <h3>Semua Mata Pelajaran Kelas <?= $kelas->nama_kelas; ?></h3>
    </header>

    <main class="grid-container">
        <?php foreach($mapels as $mapel): 
            $sumMateri = $this->m_materi->get_many_by_join([
                'mt.id_mapel' => $mapel->dmapel,
                'guru.id' => $mapel->id_guru,
            ]);
        ?>
            <div class="card d-inline-block" style="width: 16rem;">
              <a href="<?= base_url('Materi/lists/') . md5($mapel->dmapel).'/'.encrypt_url($mapel->idguru).'/'.encrypt_url($mapel->id_kelas) . '/' . 0; ?>">
                  <img class="card-img-top" src="<?= is_null($mapel->file) ? base_url('assets/img/courses/6.png') : base_url('upload/mapel/' . $mapel->file); ?>" alt="Card image cap">
                  <div class="card-body d-flex justify-content-between">
                    <p class="card-text text-dark" style="font-size: 110%;">
                        <strong><?= $mapel->nama_mapel; ?></strong>
                    </p>
                    <p class="text-secondary">
                        <small><?= count($sumMateri); ?> item</small>
                    </p>
                  </div>
              </a>  
            </div>
        <?php endforeach; ?>
    </main>
</div>


<script type="text/javascript">
	$(document).ready(function(){
        var self, photoUser = null, photoFileName, photoExt, photoSize, maxSize, formData;
        const enableExtPictures = ['jpg', 'jpeg', 'png', 'gif', 'svg'];

        $('#lightslider').lightSlider({
            item:1,
            slideMargin:0,
            loop:true,
            controls:true 
        })
        $('.img-slider').click(function() {
            // $(this).toggleClass('zoom');
            var src = $(this).attr('src')
            $('#sliderModal .modal-body').html(`
                <img src="${src}" class="img-thumbnail mx-auto d-block img-zoom" />
            `)
            $('#sliderModal').modal('show')
        })

        $('#info-user tr td:last-child ').on('click', function() {
            $(this).children(':first').toggleClass('d-none')
            $(this).children(':last').toggleClass('d-none')

            // Visible/unvisible input
            $(this).prev().children(':first').toggleClass('d-none')
            $(this).prev().children(':last').toggleClass('d-none')
        })

        $('.in-edit').on('keydown', function(e) {
            
            if($(this).val() != '' && e.keyCode == 13) {
                e.preventDefault()
                self = this

                // Update button
                $(this).parent().next().find('.btn-outline-danger').toggleClass('d-none')
                $(this).parent().next().find('.spin-icon').toggleClass('d-none')
                $.ajax({
                    type: 'post',
                    url: "<?= base_url('pengusaha/update_profile') ?>",
                    data: {
                        id: $('#id').val(),
                        key: $(this).data('key'),
                        value: $(this).val(),
                        '<?= $csrf['name'] ?>': '<?= $csrf['token'] ?>'
                    },
                    dataType: 'json',
                    success: function(res) {
                        // Update button
                        $(self).parent().next().find('.fa-edit').toggleClass('d-none')
                        $(self).parent().next().find('.spin-icon').toggleClass('d-none')
                        
                        // Update field
                        $(self).toggleClass('d-none')
                        $(self).prev().text(res.value)
                        $(self).parent().children(':first').toggleClass('d-none')
                    },
                    error: function(e) {
                        alert('Gagal update profil')
                        // Update button
                        $(self).parent().next().find('.fa-edit').toggleClass('d-none')
                        $(self).parent().next().find('.spin-icon').toggleClass('d-none')
                        
                        // Update field
                        $(self).toggleClass('d-none')
                        $(self).parent().children(':first').toggleClass('d-none')
                        return false
                    }
                })
            }
        })

		$('#logo').change(function(e){

            var fileName = e.target.files[0].name;

            var files = e.target.files; 

            var name = '';

            for (var i = 0, file; file = files[i]; i++) {

            	console.log(file);

            	name += file.name + '';

            }

            $('.file-logo').text(name)
        });

        $('#photo-file').change(function(e) {
            photoUser = e.target.files[0];
            photoFileName = photoUser.name
            photoFileName = photoFileName.split('.')
            photoExt = photoFileName[ photoFileName.length - 1 ]
            photoSize = photoUser.size
            maxSize = 3145728

            // console.log(photoUser)
            if(!enableExtPictures.includes(photoExt)) {
                alert('Harap upload photo');
                photoUser = null;
                $(this).val('');
                return false;
            }
            else if(photoSize > maxSize) {
                alert('Maksimal Foto 3 MB');
                photoUser = null;
                $(this).val('');
                return false;   
            }
        });

        $('#upload-photo').on('click', function() {
            if(photoUser === null) {
                alert('Harap upload photo');
                return false;
            }
            // set loading button
            $(this).prop('disabled', true);
            $(this).find('#upload').toggleClass('d-none');
            $(this).find('.fa-spinner').toggleClass('d-none');
            formData = new FormData();
            formData.append('id', $('#id').val());
            formData.append('photo', photoUser);
            formData.append('<?= $csrf['name'] ?>', '<?= $csrf['token'] ?>')
            self = this;
            $.ajax({
                type: 'post',
                url: "<?= base_url('pengusaha/update_photo'); ?>",
                data: formData,
                dataType: 'json',
                contentType:false,
                processData:false,
                success:function(res) {
                    $(self).prop('disabled', false);
                    $(self).find('#upload').toggleClass('d-none');
                    $(self).find('#spinner').toggleClass('d-none');

                    $('#avatar').attr('src', res.url);
                },
                error:function(e) {
                    $(self).prop('disabled', false);
                    $(self).find('#upload').toggleClass('d-none');
                    $(self).find('#spinner').toggleClass('d-none');
                    alert(e.responseJSON.msg);
                    console.error(e.responseText);             
                    return false;       
                }
            })
        });

        $('#video').change(function(e){
            var fileName = e.target.files[0].name;
            var files = e.target.files; 
            var name = '';
            for (var i = 0, file; file = files[i]; i++) {
            	console.log(file);
            	name += file.name + '';
            }

            $('.file-video').text(name)
        });
	});
</script>