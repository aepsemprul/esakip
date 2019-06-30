@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h5 class="section-heading text-uppercase">Perjanjian Kinerja</h5>
            <h3 class="section-subheading text-muted"></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>Tahun</label>
                <input type="text" class="form-control" id="tahun_awal" placeholder="Mulai">
            </div>
        </div>
        <div class="col-sm-4">
            <label>Sampai</label>
            <input type="text" class="form-control" id="tahun_akhir" placeholder="Selesai" disabled>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label>OPD</label>
            <select class="form-control" id="opd">
                <option value="">--Pilih OPD--</option>
                @foreach ($opds as $opd)
                    <option value="{{ $opd->id }}">{{ $opd->nama }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-sm-8">
            <a
                href="#"
                class="btn btn-info btn-cari"
                ><i class="fa fa-search"></i> Cari</a>
            {{-- <a
                href="#"
                class="btn btn-info btn-cetak"
                ><i class="fa fa-file-pdf-o"></i> Cetak</a> --}}
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-sm-12">
            <table id="example1" class="table table-bordered table-striped">
                <thead style="background-color: #428bca;" id="thead">
                    <tr>
                        <th style="color: #ffffff; text-align: center;" rowspan="2">No</th>
                        <th style="color: #ffffff; text-align: center;" rowspan="2">Sasaran</th>
                        <th style="color: #ffffff; text-align: center;" rowspan="2">Indikator</th>
                        <th style="color: #ffffff; text-align: center;" rowspan="2">Target Kinerja</th>
                        <th style="color: #ffffff; text-align: center; border-bottom: solid #fff 0px; border-right: solid #fff 0px;" colspan="3">Target</th>
                    </tr>
                    <tr id="head-target">
                        <th style="color: #ffffff; text-align: center;">Tw</th>
                        <th style="color: #ffffff; text-align: center;">Target</th>
                        <th style="color: #ffffff; text-align: center;">Satuan</th>
                    </tr>
                </thead>
                <tbody id="tabeldata">

                </tbody>
            </table>
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

        $('#tahun_awal').keyup(function() {
            $('#tahun_akhir').val(parseInt($('#tahun_awal').val()) + 4);
        });

        function showData(data_tahun_awal, data_tahun_akhir, data_opd) {
            var tahun_awal = data_tahun_awal;
            var tahun_akhir = data_tahun_akhir;
            var opd = data_opd;

            $.ajax({
                url: 'perjanjian-kinerja/cari',
                type: 'get',
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
                            tr += "<td>" + value.deskripsi + "</td>";

                        var indikator = '';
                        
                        $.each(value.data_layout, function(i, value_layout) {
                            if(indikator == value_layout.indikator_id) {
                                tr += "<td></td>";
                            } else {
                                tr += "<td>" + value_layout.data_indikator.deskripsi + "</td>";
                                tr += "<td>" + value_layout.target_kinerja + "</td>";
                            }                          
                            
                            tr += "<td>" + value_layout.tw + "</td>";
                            tr += "<td>" + value_layout.target + "</td>";
                            tr += "<td>" + value_layout.satuan + "</td>";
                            
                            var isLastElement = i == value.data_layout.length -1;

                            if (isLastElement) {
                                
                                tr +=   "</tr>";
                            } else {
                                
                                tr +=   "</tr><td></td><td></td>";
                            }

                            indikator = value_layout.sasaran_id;
                        });

                        $('#tabeldata').append(tr);
                    });
                }
            });
        }
    });
</script>
@endsection