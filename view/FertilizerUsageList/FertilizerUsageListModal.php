<!---------------------  Modal ADD --------------------->
<div class="modal fade" id="modal-4" role="dialog">
        <form method="post" enctype="multipart/form-data" id="form">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header header-modal">
                        <h4 class="modal-title setTextEdit">เพิ่มการใส่ปุ๋ย</h4>
                    </div>
                    <div class="modal-body">
                        <div class="main">
                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>วันที่</span>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-xl-8 col-12">
                                    <input class="form-control" width="auto" id="p_date" name="p_date" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>สวน</span>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-xl-8 col-12">
                                    <select class="js-example-basic-single" id="p_farm" name="p_farm">

                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>แปลง</span>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-xl-8 col-12">
                                    <select class="js-example-basic-single" id="p_subfarm" name="p_subfarm">

                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>ชนิดปุ๋ย</span>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-xl-8 col-12">
                                    <select class="js-example-basic-single" id="p_fertilizer" name="p_fertilizer">

                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>ปริมาณปุ๋ยที่ใส่ (ก.ก.)</span>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-xl-8 col-12">
                                    <input placeholder="ปริมาณปุ๋ยที่ใส่" type="text" class="form-control" id="p_vol" name="p_vol" onblur="check_num();" value="">

                                    </input>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>จำนวนต้น</span>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-xl-8 col-12">
                                    <input placeholder="จำนวนต้น" type="text" class="form-control" id="p_tree" name="p_tree" onblur="check_num();" value="">

                                    </input>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-xl-3 col-12 text-right">
                                    <span>รูปภาพ</span>
                                </div>
                                <div class="col-xl-9 col-12">
                                    <div class="grid-img-multiple" id="p_insert_img">

                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="pestAlarmID" id="pestAlarmID" value="0" />
                        </div>
                        <div class="crop-img">
                            <center>
                                <div id="upload-demo" class="center-block"></div>
                            </center>
                        </div>
                        <input type="hidden" id="hidden_id" name="photo" value="insert" />
                        <div class="modal-footer normal-button">
                            <button id="m_success" type="button" class="btn btn-success">ยืนยัน</button>
                            <button id="m_not_success" type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                        </div>
                        <div class="modal-footer crop-button">
                            <button type="button" class="btn btn-success btn-crop">ยืนยัน</button>
                            <button type="button" class="btn btn-danger btn-cancel-crop">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>



    <!---------------------  Modal Button --------------------->
    <div class="modal fade" id="modal-3" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h4 class="modal-title">ข้อมูลสำคัญของศัตรูพืช</h4>
                </div>
                <div class="modal-body" id="noteModalBody">
                    <span id="Note"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    