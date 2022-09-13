@extends('admin.layouts.app')
@section('css')

@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive " style="margin-top:15px;">
            <table id="data_table" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <thead>
                    <tr>
                        <th>Nomor Surat</th>
                        <th>Kategori</th>
                        <th>Judul</th>
                        <th>Waktu Pengesahan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        <button type="button" onclick="addPage()" class="btn btn-success mt-4">Arsipkan Surat</button>
    </div>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content" id="modal-content">

        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    function formatTime(dateTimeString) {
    const date = new Date(dateTimeString);

    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    const monthIndex = date.getMonth();
    const year = date.getFullYear();

    return (
        `${date.getDate()}-${monthNames[monthIndex]}-${year}`
    );
    }

    let table;
    const initializeTable = () => {
        table = $('#data_table').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            searching: true,
            ajax: "{{ route('arsip.index') }}",
            columns: [
                {
                    data: 'no_document',
                    name: 'no_document'
                },
                {
                    data: 'category',
                    name: 'category'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        return table;
    }

    $(document).ready(function () {
        initializeTable()
        $('#data_table tfoot th').each(function () {
            var title = $('#data_table thead th').eq($(this).index()).text();
            $(this).html('<input type="text" class="form-control" placeholder="Search ' + title +
                '" />');
        });
        $('tfoot').each(function () {
            $(this).insertAfter($(this).siblings('thead'));
        });

        table.columns().eq(0).each(function (colIdx) {
            $('input', table.column(colIdx).footer()).on('keyup change', function () {
                console.log(colIdx + '-' + this.value);
                table
                    .column(colIdx)
                    .search(this.value)
                    .draw();
            });
        });
    });

</script>
<script>

    let viewData;
    function formatDate(date){
        let tanggal = moment(date, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
        return tanggal;
    }

    function validation(val) {
        alerr = "";
        sts = false;

        if(val.files[0].type != "application/pdf"){
            alerr += "Jenis file bukan .pdf";
            alert(alerr);
            val.value = ''
        }
    }

    const addComponent = () => {
        return (
            `
            <form id="form-data" enctype="multipart/form-data">
                    <label for="no_document"> Nomor Surat</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="no_document" class="form-control" placeholder="Nomor Surat" autocomplete="off" required>
                        </div>
                    </div>

                    <label for="category"> Kategori</label>
                    <div class="form-group">
                        <select class="choices form-select" name="category" id="category">
                            <option value="undangan">Undangan</option>
                            <option value="pengumuman">Pengumuman</option>
                            <option value="nota-dinas">Nota Dinas</option>
                            <option value="pemberitahuan">Pemberitahuan</option>
                        </select>
                    </div>


                    <label for="title"> Judul</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="title" class="form-control" placeholder="Judul" autocomplete="off" required>
                        </div>
                    </div>

                    <label for="file"> File</label>

                    <div class="form-group">
                        <img class="img-preview img-fluid mb-3 col-sm-2">
                        <div class="form-line">
                            <input type="file" id="file" onchange="validation(this)" class="form-control" name="file" accept="application/pdf">
                        </div>
                    </div>
                    <a id="btn-cancel"class="btn btn-light-secondary" onclick="tablePage()">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Kembali</span>
                    </a>
                    <div id="btn-loader" class="loader d-none"></div>
                    <a id="btn-action" onclick="addData()" class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block" >Simpan</span>
                    </a>
                </form>
            `
        )
    }

    const viewComponent = (data) => {
        viewData = data;
        return (
            `
            <form id="form-data" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <p>Nomor: ${data.no_document}</p>
                            <p>Kategori: ${data.category}</p>
                            <p>Judul: ${data.title}</p>
                            <p>Waktu Unggah: ${formatDate(data.created_at)}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <embed src="${data.file}" width="100%" style="height:100vw">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <a id="btn-cancel"class="btn btn-light-secondary" onclick="tablePage()">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Kembali</span>
                            </a>
                            <div id="btn-loader" class="loader d-none"></div>
                            <a id="btn-action" href="${data.file}" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block" >Unduh</span>
                            </a>
                            <a id="btn-action" onclick="editPage()" class="btn btn-success ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Edit/Ganti File</span>
                            </a>
                        </div>
                    </div>
                </form>
            `
        )
    }

    const editComponent = (data) => {
        $('#category option[value="' + data.category + '"]').attr('selected', 'selected');
        return (
            `
            <form id="form-data" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="${data.id}">
                    <label for="no_document"> Nomor Surat</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="no_document" class="form-control" placeholder="Nomor Surat" autocomplete="off" value="${data.no_document}">
                        </div>
                    </div>

                    <label for="category"> Kategori</label>
                    <div class="form-group">
                        <select class="choices form-select" name="category" id="category">
                            <option value="undangan">Undangan</option>
                            <option value="pengumuman">Pengumuman</option>
                            <option value="nota-dinas">Nota Dinas</option>
                            <option value="pemberitahuan">Pemberitahuan</option>
                        </select>
                    </div>

                    <label for="title"> Judul</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="title" class="form-control" placeholder="Judul" autocomplete="off" value="${data.title}">
                        </div>
                    </div>

                    <label for="file"> File</label>

                    <div class="form-group">
                        <img class="img-preview img-fluid mb-3 col-sm-2">
                        <div class="form-line">
                            <input type="file" id="file" onchange="validation(this)" class="form-control" name="file" accept="application/pdf,application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        </div>
                    </div>
                    <a id="btn-cancel"class="btn btn-light-secondary" onclick="tablePage()">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Kembali</span>
                    </a>
                    <div id="btn-loader" class="loader d-none"></div>
                    <a id="btn-action" onclick="editData()" class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block" >Update</span>
                    </a>
                </form>
            `
        )
    }

    const tableComponent = () => {
        return (`
            <div class="table-responsive " style="margin-top:15px;">
                <table id="data_table" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                    <thead>
                        <tr>
                            <th>Nomor Surat</th>
                            <th>Kategori</th>
                            <th>Judul</th>
                            <th>Waktu Pengesahan</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
            <button type="button" onclick="addPage()" class="btn btn-success mt-4">Arsipkan Surat</button>
        `)
    }

    function addPage()
    {
        let html = addComponent();
        $('.card-body').html(html)
    }

    function tablePage()
    {
        let html = tableComponent();
        $('.card-body').html(html)
        initializeTable()
    }

    function viewPage(data)
    {
        let html = viewComponent(data);
        $('.card-body').html(html)
    }

    function editPage()
    {
        let html = editComponent(viewData);
        $('.card-body').html(html)
    }


    function deleteModal(data)
    {
        let html = `<div class="modal-body">
                <div class="row">
                    <div class="col-md-12"><h3>Alert</h3></div>
                    <div class="col-md-12"><p>Apakah Anda yakin ingin menghapus arsip ini?</p></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <div id="btn-loader" class="loader d-none"></div>
                <button id="btn-action" onclick="deleteData(${data.id})" class="btn btn-danger ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block" >Delete</span>
                </button>
            </div>`
        $('#modal-content').html(html)
    }

    function addData()
    {
        $('#btn-loader').removeClass('d-none')
        $('#btn-action').addClass('d-none')
        $('#btn-cancel').addClass('d-none')
        let data = new FormData($('#form-data')[0]);
        $.ajax({
            url: '{{route('arsip.store')}}',
            type: "POST",
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            statusCode: {
                500: function(response) {
                    console.log(response)
                    Toastify({
                        text: 'Document add unsuccessful',
                        backgroundColor: '#d74d4d',
                    }).showToast();
                    $('#btn-loader').addClass('d-none')
                    $('#btn-cancel').removeClass('d-none')
                    $('#btn-action').removeClass('d-none')
                },
            },
            success: function(data) {
                $("#form-data")[0].reset()
                Toastify({
                    text: 'Document add successful',
                    backgroundColor: '#435ebe',
                }).showToast();
                $('#btn-loader').addClass('d-none')
                $('#btn-cancel').addClass('d-none')
                tablePage()
            }
        });
    }

    function editData(id)
    {
        $('#btn-loader').removeClass('d-none')
        $('#btn-action').addClass('d-none')
        $('#btn-cancel').addClass('d-none')
        let data = new FormData($('#form-data')[0]);
        data.append('_method', 'PATCH');
        $.ajax({
            url: `{{route('arsip.update','id')}}`,
            type: 'POST',
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            statusCode: {
                500: function(response) {
                    console.log(response)
                    Toastify({
                        text: 'Document edit unsuccessful',
                        backgroundColor: '#d74d4d',
                    }).showToast();
                    $('#btn-loader').addClass('d-none')
                    $('#btn-cancel').removeClass('d-none')
                    $('#btn-action').removeClass('d-none')
                },
            },
            success: function(data) {
                Toastify({
                    text: 'Document edit successful',
                    backgroundColor: '#435ebe',
                }).showToast();
                $('#btn-loader').addClass('d-none')
                $('#btn-cancel').addClass('d-none')
                tablePage()
            }
        });
    }

    function deleteData(id)
    {
        $('#btn-loader').removeClass('d-none')
        $('#btn-action').addClass('d-none')
        $.ajax({
            url: `{{route('arsip.destroy','id')}}`,
            type: "DELETE",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'id': id,
            },
            statusCode: {
                500: function(response) {
                    console.log(response)
                    Toastify({
                        text: 'Document delete unsuccessful',
                        backgroundColor: '#d74d4d',
                    }).showToast();
                    $('#btn-loader').addClass('d-none')
                    $('#btn-action').removeClass('d-none')
                },
            },
            success: function(data) {
                Toastify({
                    text: 'Document delete successful',
                    backgroundColor: '#435ebe',
                }).showToast();
                $('#btn-loader').addClass('d-none')
                tablePage()
                $('#exampleModalCenter').modal('hide');
            }
        });
    }
</script>
@endsection
