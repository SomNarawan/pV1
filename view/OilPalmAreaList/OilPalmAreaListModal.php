<div class="modal" id="addModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-signin" method="POST" action='manage.php'>
                <div class="modal-header header-modal">
                    <h4 class="modal-title">เพิ่มสวนปาล์ม</h4>
                </div>
                <div class="modal-body" id="addModalBody">
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ชื่อสวนปาล์ม</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" name="namefarm" id="rank3">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ชื่อย่อสวนปาล์ม</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" name="aliasfarm" id="rank4">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ที่อยู่</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <input type="text" class="form-control" name="addfarm" id="rrr">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>จังหวัด</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <select id="province1" class="form-control" name="province">
                                <option disabled selected id="province_list">เลือกจังหวัด</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>อำเภอ</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <select id="amp1" name="amphur" class="form-control">
                                <option selected="" disabled="">เลือกอำเภอ</option>

                            </select>

                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>ตำบล</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <select id="subamp" name="subdistrinct" class="form-control">
                                <option selected="" disabled="">เลือกตำบล</option>

                            </select>
                        </div>
                    </div>


                    <div class="row mb-4">
                        <div class="col-xl-3 col-12 text-right">
                            <span>เจ้าของสวนปาล์ม</span>
                        </div>
                        <div class="col-xl-9 col-12">
                            <select class="form-control" id="farmer" name="farmer">
                                <option selected="" disabled="">เลือกเจ้าของสวน</option>

                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="add">

                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-md" style="float:right;" type="submit">ยืนยัน</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>
</div>