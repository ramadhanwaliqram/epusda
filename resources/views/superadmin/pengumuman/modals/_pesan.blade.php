<div class="modal fade modal-flex p-0" id="modal-pesan" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header p-4">
        <h4 class="modal-title">
          Tambah Pesan
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-4">
        <form id="form-pesan" action="">
          @csrf

          <div class="row">
            <input type="hidden" name="hidden_id" id="hidden_id" class="form-control form-control-sm">

            <div class="col-md-12">
              <div class="form-group bmd-form-group">
                <label class="bmd-label-floating">Judul</label>
                <input type="text" name="title" id="title" class="form-control form-control-sm" placeholder="Judul">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3 my-2">
              <label><b>Pengaturan Pesan</b></label>
              <div class="form-check">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox" value="Notification Message" name="message_option[]" checked>Notifikasi Pesan
                  <span class="form-check-sign">
                    <span class="check"></span>
                  </span>
                </label>
              </div>

              <div class="form-check">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox" value="Dashboard Notification" name="message_option[]">Dashboard Notifikasi
                  <span class="form-check-sign">
                    <span class="check"></span>
                  </span>
                </label>
              </div>
            </div>

            <div class="col-md-3 my-2">
              <label>Set Waktu</label>
              <div class="form-check">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="message_time" value="Permanen" checked>Permanen
                  <span class="circle">
                    <span class="check"></span>
                  </span>
                </label>
              </div>

              <div class="form-check">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="message_time" value="Using Time">Jangka Waktu
                  <span class="circle">
                    <span class="check"></span>
                  </span>
                </label>
              </div>
            </div>

            <div class="col-md-6 my-2">
              <label>Pengaturan Jangka Waktu</label>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="start_date" class="bmd-label-floating">Start Date</label>
                    <input type="text" class="form-control form-control-sm" id="start_date" name="start_date" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="end_date" class="bmd-label-floating">End Date</label>
                    <input type="text" class="form-control form-control-sm" id="end_date" name="end_date" readonly>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <label>Pesan</label>
              <div class="form-group">
                <textarea class="form-control form-control-sm" name="message" id="message" rows="10" placeholder="Pesan"></textarea>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="d-flex justify-content-between align-items-center">
                <button class="btn btn-sm btn-warning mr-3" type="reset" for="resetBtn">Reset</button>
                <div>
                  <button type="submit" id="button" class="btn btn-sm btn-success">Simpan</button>
                  <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>