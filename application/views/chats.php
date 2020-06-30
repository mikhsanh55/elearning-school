<div id="frame">
        <div id="sidepanel">

            <div id="profile">
                <p>User Online</p>
            </div>

            <div id="contacts">    
            </div>

        </div>
        <div class="content">

            <div class="contact-profile">
            </div>

            <div class="messages" id="messages">
                
            </div>
            <div class="message-input">
                <div class="wrap">
                <form id="f_chat" name="f_chat" onsubmit="return newMessage();">
                <input type="text" name="message" id="message" placeholder="Masukan Pesan..."  />
                <input type="hidden" name="id" id="id" value="<?= $this->uri->segment(3); ?>" >
                <input type="hidden" name="id_user" id="id_user"  value="<?= $this->session->userdata('admin_konid'); ?>">
                <!-- <input type="hidden" name="mapel" id="mapel" value="<?= $this->session->userdata('admin_nama'); ?>" > -->
                
                <button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                </form>
                </div>
            </div>
        </div>
    </div>