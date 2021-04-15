<div id="addEvent" class="modal fade modal-flex" role="dialog">
    <form id="addFormEvent" method="post" action="">
        @csrf
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Tambah
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="input_hidden"></div>
                            <div class="form-group bmd-form-group">
                                <label id="label_title" class="bmd-label-floating">Event Title</label>
                                <input type="text" name="title" id="title" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label id="label_start_date" class="bmd-label-floating">Start Date</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label id="label_end_date" class="bmd-label-floating">End Date</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label id="label_start_clock" class="bmd-label-floating">Start At</label>
                                        <input type="text" name="start_clock" id="start_clock" class="form-control clockpicker">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        <label id="label_end_clock" class="bmd-label-floating">End At</label>
                                        <input type="text" name="end_clock" id="end_clock" class="form-control clockpicker">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <select class="form-control form-control-sm" data-style="btn select-with-transition" title="Prioritas" data-size="7" name="prioritas" id="prioritas">
                                    <option selected="true" disabled>Prioritas</option>
                                    <option value="Sangat Penting">Sangat Penting</option>
                                    <option value="Penting">Penting</option>
                                    <option value="Wajib Datang">Wajib Datang</option>
                                    <option value="Tidak Diwajibkan Datang">Tidak Diwajibkan Datang</option>
                                    <option value="Diharapkan Datang">Diharapkan Datang</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-outline-success" style="margin-right: 10px;" id="btnEvent">Simpan</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
                    <div id="deleteEvent" class="text-left"></div>
                </div>
            </div>
        </div>
    </form>
</div>