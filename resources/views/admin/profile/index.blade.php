@extends('admin.layouts.app')
@section('css')

@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-2">
                <img src="{{ url('assets/images/foto.jpg') }}" alt="" style="width: 10vw">
            </div>
            <div class="col-md-3">
                <p>Aplikasi ini dibuat oleh:</p>
                <p>Nama : Yoga Meleniawan Pamungkas</p>
                <p>NIM : 1931710083</p>
                <p>Tanggal : 12 September 2022</p>
            </div>
        </div>
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
@endsection
