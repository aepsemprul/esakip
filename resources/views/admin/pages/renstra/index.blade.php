@extends('admin.layouts.app')

@section('style')
    <style>
        @media print {
            #thead {
                background-color: red;
            }
        }
        
        @media screen {
            #thead {
                background-color: red;
            }
        }
    </style>
@endsection

@section('content')
    
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Manage RENSTRA
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">RENSTRA</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12"> 
            @if(session('status'))
                <div class="alert alert-success">
                    {{session('status')}}
                </div>
            @endif
            <div class="box">
                    <div class="box-header header-tahun-hide">
                        <div class="form-group form-horizontal">
                            <label for="tahun_awal" class="col-sm-1 control-label">Tahun</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="tahun_awal" placeholder="Mulai">
                            </div>
                            <label for="tahun_akhir" class="col-sm-1 control-label">Sampai</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="tahun_akhir" placeholder="Selesai" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="box-header header-opd-hide">
                        <div class="form-group form-horizontal">
                            <label for="opd" class="col-sm-1 control-label">OPD</label>
                            <div class="col-sm-5">
                                <select class="form-control" id="opd">
                                    <option value="">--Pilih OPD--</option>
                                    @foreach ($opds as $opd)
                                        <option value="{{ $opd->id }}">{{ $opd->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                <!-- /.box-header -->
                <hr>
                <div class="box-header header-button-hide">
                    <a
                        href="#"
                        class="btn btn-info btn-cari"
                        ><i class="fa fa-search"></i> Cari</a>
                    <a
                        href="#"
                        class="btn btn-info btn-cetak"
                        ><i class="fa fa-file-pdf-o"></i> Cetak</a>
                    <a
                        href="#"
                        class="btn btn-info btn-tambah"
                        ><i class="fa fa-plus"></i> Tambah Data</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <button id="showAfterPrint">Load</button>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead style="background-color: #428bca;" id="thead">
                            <tr>
                                <th style="color: #ffffff; text-align: center;" rowspan="2">No</th>
                                <th style="color: #ffffff; text-align: center;" rowspan="2">Sasaran</th>
                                <th style="color: #ffffff; text-align: center;" rowspan="2">Indikator Kinerja</th>
                                <th style="color: #ffffff; text-align: center;" rowspan="2">Satuan</th>
                                <th style="color: #ffffff; text-align: center;" rowspan="2">Kinerja Eksiting</th>
                                <th style="color: #ffffff; text-align: center; border-bottom: solid #fff 0px; border-right: solid #fff 0px;" colspan="5">Target</th>
                                <th style="color: #ffffff; text-align: center; border-left: solid #fff 1px;" rowspan="2" id="action">Action</th>
                            </tr>
                            <tr id="head-target">
                                
                            </tr>
                        </thead>
                        <tbody id="tabeldata">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal form-create">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data RENSTRA</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tahun_awal" class="col-sm-3 control-label">Tahun Awal</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="input-tahun-awal" placeholder="Tahun Awal">
                        </div>
                        <label for="tahun_akhir" class="col-sm-3 control-label">Tahun Akhir</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="input-tahun-akhir" placeholder="Tahun Akhir">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="opd" class="col-sm-3 control-label">OPD</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="input-opd-text" placeholder="OPD">
                            <input type="hidden" class="form-control" id="input-opd-id" placeholder="OPD">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sasaran" class="col-sm-3 control-label">Sasaran</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="input-sasaran" name="sasaran">
                                <option value="">--Pilih Sasaran--</option>
                                @foreach ($sasarans as $sasaran)
                                    <option value="{{ $sasaran->id }}">{{ $sasaran->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="indikator" class="col-sm-3 control-label">Indikator</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="input-indikator" name="indikator">
                                <option value="">--Pilih indikator--</option>
                                @foreach ($indikators as $indikator)
                                    <option value="{{ $indikator->id }}">{{ $indikator->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <label for="sasaran" class="col-sm-3 control-label">Sasaran</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="input-sasaran" placeholder="Sasaran">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="indikator" class="col-sm-3 control-label">Indikator</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="input-indikator" placeholder="Indikator">
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <label for="satuan" class="col-sm-3 control-label">Satuan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="input-satuan" placeholder="satuan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kinerja-eksiting" class="col-sm-3 control-label">Kinerja Eksiting</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="input-kinerja-eksiting" placeholder="kinerja ksiting">
                        </div>
                    </div>
                    <div id="input-target">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal form-edit">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Data RENSTRA</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="edit-id">
                    <div class="form-group">
                        <label for="tahun_awal" class="col-sm-3 control-label">Tahun Awal</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="edit-tahun-awal" placeholder="Tahun Awal" disabled>
                        </div>
                        <label for="tahun_akhir" class="col-sm-3 control-label">Tahun Akhir</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="edit-tahun-akhir" placeholder="Tahun Akhir" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="opd" class="col-sm-3 control-label">OPD</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit-opd-text" placeholder="OPD" disabled>
                            <input type="hidden" class="form-control" id="edit-opd-id" placeholder="OPD">
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <label for="tujuan" class="col-sm-3 control-label">Tujuan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit-tujuan-text" placeholder="Tujuan">
                            <input type="hidden" class="form-control" id="edit-tujuan-id">
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <label for="sasaran" class="col-sm-3 control-label">Sasaran</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit-sasaran-text" placeholder="Sasaran">
                            <input type="hidden" class="form-control" id="edit-sasaran-id" placeholder="Sasaran">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="indikator" class="col-sm-3 control-label">Indikator</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit-indikator-text" placeholder="Indikator">
                            <input type="hidden" class="form-control" id="edit-indikator-id" placeholder="Indikator">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="satuan" class="col-sm-3 control-label">satuan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit-satuan" placeholder="satuan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kinerja_eksiting" class="col-sm-3 control-label">kinerja_eksiting</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit-kinerja-eksiting" placeholder="kinerja_eksiting">
                        </div>
                    </div>
                    <div id="edit-target">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Sasaran -->
<div class="modal fade" id="modalSasaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal form-sasaran">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Sasaran RENSTRA</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="edit-id">
                    <div class="form-group">
                        <label for="tahun_awal" class="col-sm-3 control-label">Tahun Awal</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="edit-tahun-awal" placeholder="Tahun Awal" disabled>
                        </div>
                        <label for="tahun_akhir" class="col-sm-3 control-label">Tahun Akhir</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="edit-tahun-akhir" placeholder="Tahun Akhir" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="opd" class="col-sm-3 control-label">OPD</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit-opd-text" placeholder="OPD" disabled>
                            <input type="hidden" class="form-control" id="edit-opd-id" placeholder="OPD">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tujuan" class="col-sm-3 control-label">Tujuan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit-tujuan-text" placeholder="Tujuan" disabled>
                            <input type="hidden" class="form-control" id="edit-tujuan-id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sasaran" class="col-sm-3 control-label">Sasaran</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit-sasaran-text" placeholder="Sasaran">
                            <input type="hidden" class="form-control" id="edit-sasaran-id" placeholder="Sasaran">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="indikator" class="col-sm-3 control-label">Indikator</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit-indikator-text" placeholder="Indikator">
                            <input type="hidden" class="form-control" id="edit-indikator-id" placeholder="Indikator">
                        </div>
                    </div>
                    <div id="edit-target">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Indikator -->
<div class="modal fade" id="modalIndikator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal form-indikator">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Indikator RENSTRA</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="edit-id">
                    <div class="form-group">
                        <label for="tahun_awal" class="col-sm-3 control-label">Tahun Awal</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="edit-tahun-awal" placeholder="Tahun Awal" disabled>
                        </div>
                        <label for="tahun_akhir" class="col-sm-3 control-label">Tahun Akhir</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="edit-tahun-akhir" placeholder="Tahun Akhir" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="opd" class="col-sm-3 control-label">OPD</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit-opd-text" placeholder="OPD" disabled>
                            <input type="hidden" class="form-control" id="edit-opd-id" placeholder="OPD">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tujuan" class="col-sm-3 control-label">Tujuan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit-tujuan-text" placeholder="Tujuan" disabled>
                            <input type="hidden" class="form-control" id="edit-tujuan-id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sasaran" class="col-sm-3 control-label">Sasaran</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit-sasaran-text" placeholder="Sasaran" disabled>
                            <input type="hidden" class="form-control" id="edit-sasaran-id" placeholder="Sasaran">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="indikator" class="col-sm-3 control-label">Indikator</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit-indikator-text" placeholder="Indikator">
                            <input type="hidden" class="form-control" id="edit-indikator-id" placeholder="Indikator">
                        </div>
                    </div>
                    <div id="edit-target">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>
    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('.btn-cari').on('click', function(e) {
            e.preventDefault();
            $('#tabeldata').empty();

            var tahun_awal = $('#tahun_awal').val();
            var tahun_akhir = $('#tahun_akhir').val();
            var opd = $('#opd').children("option:selected").val();

            showData(tahun_awal, tahun_akhir, opd);
        });

        $('#showAfterPrint').hide();
        $('#showAfterPrint').on('click', function() {
            location.reload();
        });

        $('.btn-cetak').on('click', function(e) {
            e.preventDefault();
            $('.header-tahun-hide').hide();
            $('.header-opd-hide').hide();
            $('.header-button-hide').hide();
            $('table #trLast').hide();
            $('table #action').hide();
            $('table #tdAction').hide();
            $('hr').hide();
            
            window.print();

            $('#showAfterPrint').show();
        });

        $('#tahun_awal').keyup(function() {
            $('#head-target').empty();
            $('#tahun_akhir').val(parseInt($('#tahun_awal').val()) + 4);
            var tahun = $('#tahun_awal').val();

            if(tahun == null) {
                tahun = 1;
            }
            var head_target = [];
            for(i = 0; i < 5; i++) {
                var th = parseInt(tahun) + parseInt(i);
                head_target +=   "<th style=\"color: #ffffff; text-align: center;\">" + th + "</th>";
            }
            $('#head-target').append(head_target);
        });

        $('.btn-tambah').on('click', function() {
            $('#modalCreate').modal();
        });

        $('.btn-secondary').on('click', function() {
            var tahun_awal = $('#tahun_awal').val();
            var tahun_akhir = $('#tahun_akhir').val();
            var opd = $('#opd').children("option:selected").val();

            showData(tahun_awal, tahun_akhir, opd);
        });

        function showData(data_tahun_awal, data_tahun_akhir, data_opd) {
            var tahun_awal = data_tahun_awal;
            var tahun_akhir = data_tahun_akhir;
            var opd = data_opd;

            $.ajax({
                url: 'cariRenstra',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    tahun_awal: tahun_awal,
                    tahun_akhir: tahun_akhir,
                    opd: opd
                },
                success: function(response) {
                    console.log(response);                    
                    $.each(response.data, function(i, value){
                        var tr = "<tr></tr>";
                            tr += "<td>" + parseInt(i + 1) + "</td>";
                            // tr += "<td>" + value.deskripsi + "</td>";

                        var sasaran = '';
                        
                        $.each(value.data_layout, function(i, value_layout) {
                            // console.log(value_layout.id); 
                            if(sasaran == value_layout.sasaran_id) {
                                tr += "<td></td>";
                            } else {
                                tr += "<td>" + value_layout.data_sasaran.nama + "</td>";
                            }                          
                            
                            tr += "<td>" + value_layout.data_indikator.nama + "</td>";
                            tr += "<td>" + value_layout.satuan + "</td>";
                            tr += "<td>" + value_layout.kinerja_eksiting + "</td>";
                            
                            var isLastElement = i == value.data_layout.length -1;

                            if (isLastElement) {                                
                                for(a = 0; a < value_layout.data_target.length; a++) {
                                    var b = value_layout.data_target[a];
                                    tr += "<td>" + b.nilai + "</td>";
                                }
                                tr +=   "<td style=\"width: 90px;\" id=\"tdAction\">" + 
                                            "<div class=\"col-xs-6\" style=\"padding-right: 5px; padding-left: 0;\">" +
                                                "<button class=\"btn btn-info btn-sm btn-block btn-edit\" data-id=\"" + value_layout.id + "\"><i class=\"fa fa-edit\"></i></button>" +
                                            "</div>" +
                                            "<div class=\"col-xs-6\" style=\"padding-right: 5px; padding-left: 0;\">" +
                                                "<button class=\"btn btn-danger btn-sm btn-block btn-delete\" data-id=\"" + value_layout.id + "\"><i class=\"fa fa-trash\"></i></button>" +
                                            "</div>" +
                                        "</td>";
                                tr +=   "</tr>";
                                tr +=   "<tr id=\"trLast\">" +
                                            "<td></td>" +
                                            "<td><button class=\"btn btn-success btn-sasaran\" style=\"padding: 3px 8px 3px 8px;\" data-id=\"" + value_layout.id + "\"><i class=\"fa fa-plus\"></i></button></td>" +
                                            "<td><button class=\"btn btn-success btn-indikator\" style=\"padding: 3px 8px 3px 8px;\" data-id=\"" + value_layout.id + "\"><i class=\"fa fa-plus\"></i></button></td>" +
                                            "<td colspan=\"6\"></td>" +
                                        "</tr>";
                            } else {
                                for(a = 0; a < value_layout.data_target.length; a++) {
                                    var b = value_layout.data_target[a];
                                    tr += "<td>" + b.nilai + "</td>";
                                }
                                tr +=   "<td style=\"width: 90px;\" id=\"tdAction\">" + 
                                            "<div class=\"col-xs-6\" style=\"padding-right: 5px; padding-left: 0;\">" +
                                                "<button class=\"btn btn-info btn-sm btn-block btn-edit\" data-id=\"" + value_layout.id + "\"><i class=\"fa fa-edit\"></i></button>" +
                                            "</div>" +
                                            "<div class=\"col-xs-6\" style=\"padding-right: 5px; padding-left: 0;\">" +
                                                "<button class=\"btn btn-danger btn-sm btn-block btn-delete\" data-id=\"" + value_layout.id + "\"><i class=\"fa fa-trash\"></i></button>" +
                                            "</div>" +
                                        "</td>";
                                tr +=   "</tr><td></td>";
                            }

                            sasaran = value_layout.sasaran_id;
                        });

                        $('#tabeldata').append(tr);
                    });
                }
            });
        }

        // modal create show
        $('#modalCreate').on('show.bs.modal', function() {

            $('#tabeldata').empty();

            var tahun_awal = $('#tahun_awal').val();
            var tahun_akhir = $('#tahun_akhir').val();
            var opd_text = $('#opd').children("option:selected").text();
            var opd_id = $('#opd').children("option:selected").val();

            $('#input-tahun-awal').val(tahun_awal);
            $('#input-tahun-akhir').val(tahun_akhir);
            $('#input-opd-text').val(opd_text);
            $('#input-opd-id').val(opd_id);

            $('#input-target').append().empty();

            var form_target_index = parseInt($('#tahun_akhir').val()) - parseInt($('#tahun_awal').val());
            // console.log(form_target_index);
            for(i = 0; i <= form_target_index; i++) {
                var label = parseInt(tahun_awal) + parseInt(i);
                $('#input-target').append(  "<div class=\"form-group form-horizontal\" name=\"form-target\">" +
                                                "<label for=\"indikator\" class=\"col-sm-3 control-label\" style=\"text-align: right;\">" + label + "</label>" +
                                                "<div class=\"col-sm-9\">" +
                                                    "<input type=\"number\" class=\"form-control\" id=\"input-target-" + i + "\" name=\"\" placeholder=0>" +
                                                    "<input type=\"hidden\" class=\"form-control\" id=\"input-target-tahun-" + i + "\" name=\"\" value=\"" + label + "\">" +
                                                "</div>" +
                                            "</div>");
            }            
        });

        // simpan data renstra
        $('.form-create').on('submit', function(e) {
            e.preventDefault();
            var tahun_awal = $('#input-tahun-awal').val();
            var tahun_akhir = $('#input-tahun-akhir').val();
            var opd_id = $('#input-opd-id').val();
            // var tujuan = $('#input-tujuan').val();
            var sasaran = $('#input-sasaran').val();
            var indikator = $('#input-indikator').val();
            var satuan = $('#input-satuan').val();
            var kinerja_eksiting = $('#input-kinerja-eksiting').val();
            var target = [];

            for(i = 0; i < 5; i++) {
                var nilai = $("#input-target-" + i).val();
                var tahun = $("#input-target-tahun-" + i).val();
                // console.log(text);
                target.push({
                    tahun: tahun,
                    nilai: nilai
                });
            }

            // console.log(target);
            
            $.ajax({
                url: 'renstra',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    tahun_awal: tahun_awal,
                    tahun_akhir: tahun_akhir,
                    opd_id: opd_id,
                    // tujuan: tujuan,
                    sasaran: sasaran,
                    indikator: indikator,
                    satuan: satuan,
                    kinerja_eksiting: kinerja_eksiting,
                    target: target
                },
                success: function(response) {
                    console.log(response);
                    if(response.success) {
                        $('#modalCreate').modal('hide');
                        tujuan = $('#input-tujuan').val("");
                        sasaran = $('#input-sasaran').val("");
                        indikator = $('#input-indikator').val("");
                    }
                    var tahun_awal = $('#tahun_awal').val();
                    var tahun_akhir = $('#tahun_akhir').val();
                    var opd = $('#opd').children("option:selected").val();

                    showData(tahun_awal, tahun_akhir, opd);
                }
            });
        });

        // Edit Data
        $("#tabeldata").on('click', '.btn-edit', function() {
            $('#edit-target').empty();
            $('#tabeldata').empty();

            var id = $(this).data('id');
            
            $.ajax({
                    url: '{{ URL::route('renstra.edit', 'id') }}',
                    type: 'GET',
                    data: {
                        _token: CSRF_TOKEN,
                        id: id
                        },
                    success: function(response) {
                        // console.log(response.renstra);
                        $('#modalEdit').modal();
                        $('#edit-tahun-awal').val(response.renstra.data_tujuan.data_renstra.tahun_awal);
                        $('#edit-id').val(response.renstra.id);
                        $('#edit-tahun-akhir').val(response.renstra.data_tujuan.data_renstra.tahun_akhir);
                        $('#edit-opd-text').val(response.renstra.data_tujuan.data_renstra.data_opd.nama);
                        $('#edit-opd-id').val(response.renstra.data_tujuan.data_renstra.opd_id);
                        // $('#edit-tujuan-text').val(response.renstra.data_tujuan.deskripsi);
                        // $('#edit-tujuan-id').val(response.renstra.tujuan_id);
                        $('#edit-sasaran-text').val(response.renstra.data_sasaran.deskripsi);
                        $('#edit-sasaran-id').val(response.renstra.sasaran_id);
                        $('#edit-indikator-text').val(response.renstra.data_indikator.deskripsi);
                        $('#edit-indikator-id').val(response.renstra.indikator_id);
                        $('#edit-satuan').val(response.renstra.satuan);
                        $('#edit-kinerja-eksiting').val(response.renstra.kinerja_eksiting);

                        for(i = 0; i < response.renstra.data_indikator.data_renstra_target.length; i++) {
                            // console.log(i);
                            var label = parseInt(response.renstra.data_tujuan.data_renstra.tahun_awal) + parseInt(i);
                            $('#edit-target').append(   "<div class=\"form-group form-horizontal\" name=\"form-target\">" +
                                                            "<label for=\"indikator\" class=\"col-sm-3 control-label\" style=\"text-align: right;\">" + label + "</label>" +
                                                            "<div class=\"col-sm-9\">" +
                                                                "<input type=\"number\" class=\"form-control\" id=\"edit-target-" + i + "\" name=\"\" value=\"" + response.renstra.data_indikator.data_renstra_target[i].nilai + "\" placeholder=0>" +
                                                                "<input type=\"hidden\" class=\"form-control\" id=\"edit-target-tahun-" + i + "\" name=\"\" value=\"" + label + "\">" +
                                                            "</div>" +
                                                        "</div>");
                        }
                    }
            });
        });

        // update data
        $('.form-edit').on('submit', function(e) {
            e.preventDefault();

            var id = $('#edit-id').val();
            var tahun_awal = $('#edit-tahun-awal').val();
            var tahun_akhir = $('#edit-tahun-akhir').val();
            var opd_id = $('#edit-opd-id').val();
            // var tujuan_text = $('#edit-tujuan-text').val();
            // var tujuan_id = $('#edit-tujuan-id').val();
            var sasaran_text = $('#edit-sasaran-text').val();
            var sasaran_id = $('#edit-sasaran-id').val();
            var indikator_text = $('#edit-indikator-text').val();
            var indikator_id = $('#edit-indikator-id').val();
            var satuan = $('#edit-satuan').val();
            var kinerja_eksiting = $('#edit-kinerja-eksiting').val();
            var target = [];

            for(i = 0; i < 5; i++) {
                var nilai = $("#edit-target-" + i).val();
                var tahun = $("#edit-target-tahun-" + i).val();
                // console.log(text);
                target.push({
                    tahun: tahun,
                    nilai: nilai
                });
            }

            $.ajax({
                url: '{{ URL::route('renstra.update', 'id') }}',
                type: 'PUT',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                    tahun_awal: tahun_awal,
                    tahun_akhir: tahun_akhir,
                    opd_id: opd_id,
                    // tujuan_text: tujuan_text,
                    // tujuan_id: tujuan_id,
                    sasaran_text: sasaran_text,
                    sasaran_id: sasaran_id,
                    indikator_text: indikator_text,
                    indikator_id: indikator_id,
                    satuan: satuan,
                    kinerja_eksiting: kinerja_eksiting,
                    target: target
                },
                success: function(response) {
                    // console.log(response);
                    if(response.success) {
                        $('#modalEdit').modal('hide');
                        tujuan = $('#input-tujuan').val("");
                        sasaran = $('#input-sasaran').val("");
                        indikator = $('#input-indikator').val("");
                    }
                    var tahun_awal = $('#tahun_awal').val();
                    var tahun_akhir = $('#tahun_akhir').val();
                    var opd = $('#opd').children("option:selected").val();

                    showData(tahun_awal, tahun_akhir, opd);
                }
            });
        });

        // delete data
        $("#tabeldata").on('click', '.btn-delete', function() {
            $('#tabeldata').empty();
            
            var id = $(this).data('id');
            if (confirm("Yakin akan menghapus?")) {
                $.ajax({
                    url: 'hapusRenstra',
                    type: 'POST',
                    data: {
                        _token: CSRF_TOKEN,
                        id: id
                    },
                    success: function(response) {
                        var tahun_awal = $('#tahun_awal').val();
                        var tahun_akhir = $('#tahun_akhir').val();
                        var opd = $('#opd').children("option:selected").val();

                        showData(tahun_awal, tahun_akhir, opd);
                    }
                });
            } else {
                var tahun_awal = $('#tahun_awal').val();
                var tahun_akhir = $('#tahun_akhir').val();
                var opd = $('#opd').children("option:selected").val();

                showData(tahun_awal, tahun_akhir, opd);
            }            
        });

        // tambah sasaran
        $('#tabeldata').on('click', '.btn-sasaran', function() {
            $('#modalSasaran #edit-target').empty();
            $('#tabeldata').empty();

            var id = $(this).data('id');

            $.ajax({
                url: 'tambahSasaranRenstra',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id:id
                },
                success: function(response) {
                    // console.log(response.data.data_tujuan.data_renstra.data_opd.nama);
                    $('#modalSasaran').modal();
                    $('#modalSasaran #edit-tahun-awal').val(response.data.data_tujuan.data_renstra.tahun_awal);
                    $('#modalSasaran #edit-tahun-akhir').val(response.data.data_tujuan.data_renstra.tahun_akhir);
                    $('#modalSasaran #edit-opd-text').val(response.data.data_tujuan.data_renstra.data_opd.nama);
                    $('#modalSasaran #edit-tujuan-text').val(response.data.data_tujuan.deskripsi);
                    $('#modalSasaran #edit-tujuan-id').val(response.data.data_tujuan.id);

                    var form_target_index = parseInt($('#modalSasaran #edit-tahun-akhir').val()) - parseInt($('#modalSasaran #edit-tahun-awal').val());
                    console.log(form_target_index);
                    for(i = 0; i <= form_target_index; i++) {
                        var label = parseInt($('#modalSasaran #edit-tahun-awal').val()) + parseInt(i);
                        $('#modalSasaran #edit-target').append(  "<div class=\"form-group form-horizontal\" name=\"form-target\">" +
                                                                    "<label for=\"indikator\" class=\"col-sm-3 control-label\" style=\"text-align: right;\">" + label + "</label>" +
                                                                    "<div class=\"col-sm-9\">" +
                                                                        "<input type=\"number\" class=\"form-control\" id=\"edit-target-" + i + "\" name=\"\" placeholder=0>" +
                                                                        "<input type=\"hidden\" class=\"form-control\" id=\"edit-target-tahun-" + i + "\" name=\"\" value=\"" + label + "\">" +
                                                                    "</div>" +
                                                                "</div>");
                    }
                }
            });
        });

        // simpan data sasaran
        $('.form-sasaran').on('submit', function(e) {
            e.preventDefault();

            var id = $('#modalSasaran #edit-id').val();
            var tujuan_text = $('#modalSasaran #edit-tujuan-text').val();
            var tujuan_id = $('#modalSasaran #edit-tujuan-id').val();
            var sasaran_text = $('#modalSasaran #edit-sasaran-text').val();
            var sasaran_id = $('#modalSasaran #edit-sasaran-id').val();
            var indikator_text = $('#modalSasaran #edit-indikator-text').val();
            var indikator_id = $('#modalSasaran #edit-indikator-id').val();
            var target = [];

            for(i = 0; i < 5; i++) {
                var nilai = $("#modalSasaran #edit-target-" + i).val();
                var tahun = $("#modalSasaran #edit-target-tahun-" + i).val();
                // console.log(text);
                target.push({
                    tahun: tahun,
                    nilai: nilai
                });
            }

            $.ajax({
                url: 'masukkanSasaranRenstra',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    tujuan_text: tujuan_text,
                    tujuan_id: tujuan_id,
                    sasaran_text: sasaran_text,
                    sasaran_id: sasaran_id,
                    indikator_text: indikator_text,
                    indikator_id: indikator_id,
                    target: target
                },
                success: function(response) {
                    console.log(response);
                    if(response.success) {
                        $('#modalSasaran').modal('hide');
                        tujuan = $('#modalSasaran #edit-tujuan-text').val("");
                        sasaran = $('#modalSasaran #edit-sasaran-text').val("");
                        indikator = $('#modalSasaran #edit-indikator-text').val("");
                    }
                    var tahun_awal = $('#tahun_awal').val();
                    var tahun_akhir = $('#tahun_akhir').val();
                    var opd = $('#opd').children("option:selected").val();

                    showData(tahun_awal, tahun_akhir, opd);
                }
            });
        });

        // tambah indikator
        $('#tabeldata').on('click', '.btn-indikator', function() {
            $('#modalIndikator #edit-target').empty();
            $('#tabeldata').empty();

            var id = $(this).data('id');

            $.ajax({
                url: 'tambahIndikatorRenstra',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id:id
                },
                success: function(response) {
                    // console.log(response.data.data_tujuan.data_renstra.data_opd.nama);
                    $('#modalIndikator').modal();
                    $('#modalIndikator #edit-tahun-awal').val(response.data.data_tujuan.data_renstra.tahun_awal);
                    $('#modalIndikator #edit-tahun-akhir').val(response.data.data_tujuan.data_renstra.tahun_akhir);
                    $('#modalIndikator #edit-opd-text').val(response.data.data_tujuan.data_renstra.data_opd.nama);
                    $('#modalIndikator #edit-tujuan-text').val(response.data.data_tujuan.deskripsi);
                    $('#modalIndikator #edit-tujuan-id').val(response.data.data_tujuan.id);
                    $('#modalIndikator #edit-sasaran-text').val(response.data.data_sasaran.deskripsi);
                    $('#modalIndikator #edit-sasaran-id').val(response.data.data_sasaran.id);

                    var form_target_index = parseInt($('#modalIndikator #edit-tahun-akhir').val()) - parseInt($('#modalIndikator #edit-tahun-awal').val());
                    console.log(form_target_index);
                    for(i = 0; i <= form_target_index; i++) {
                        var label = parseInt($('#modalIndikator #edit-tahun-awal').val()) + parseInt(i);
                        $('#modalIndikator #edit-target').append(  "<div class=\"form-group form-horizontal\" name=\"form-target\">" +
                                                                    "<label for=\"indikator\" class=\"col-sm-3 control-label\" style=\"text-align: right;\">" + label + "</label>" +
                                                                    "<div class=\"col-sm-9\">" +
                                                                        "<input type=\"number\" class=\"form-control\" id=\"edit-target-" + i + "\" name=\"\" placeholder=0>" +
                                                                        "<input type=\"hidden\" class=\"form-control\" id=\"edit-target-tahun-" + i + "\" name=\"\" value=\"" + label + "\">" +
                                                                    "</div>" +
                                                                "</div>");
                    }
                }
            });
        });

        // simpan data indikator
        $('.form-indikator').on('submit', function(e) {
            e.preventDefault();

            var id = $('#modalIndikator #edit-id').val();
            var tujuan_text = $('#modalIndikator #edit-tujuan-text').val();
            var tujuan_id = $('#modalIndikator #edit-tujuan-id').val();
            var sasaran_text = $('#modalIndikator #edit-sasaran-text').val();
            var sasaran_id = $('#modalIndikator #edit-sasaran-id').val();
            var indikator_text = $('#modalIndikator #edit-indikator-text').val();
            var indikator_id = $('#modalIndikator #edit-indikator-id').val();
            var target = [];

            for(i = 0; i < 5; i++) {
                var nilai = $("#modalIndikator #edit-target-" + i).val();
                var tahun = $("#modalIndikator #edit-target-tahun-" + i).val();
                // console.log(text);
                target.push({
                    tahun: tahun,
                    nilai: nilai
                });
            }

            $.ajax({
                url: 'masukkanIndikatorRenstra',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    tujuan_text: tujuan_text,
                    tujuan_id: tujuan_id,
                    sasaran_text: sasaran_text,
                    sasaran_id: sasaran_id,
                    indikator_text: indikator_text,
                    indikator_id: indikator_id,
                    target: target
                },
                success: function(response) {
                    console.log(response);
                    if(response.success) {
                        $('#modalIndikator').modal('hide');
                        tujuan = $('#modalIndikator #edit-tujuan-text').val("");
                        sasaran = $('#modalIndikator #edit-sasaran-text').val("");
                        indikator = $('#modalIndikator #edit-indikator-text').val("");
                    }
                    var tahun_awal = $('#tahun_awal').val();
                    var tahun_akhir = $('#tahun_akhir').val();
                    var opd = $('#opd').children("option:selected").val();

                    showData(tahun_awal, tahun_akhir, opd);
                }
            });
        });
    });
</script>

@endsection