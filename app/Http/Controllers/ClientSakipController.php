<?php

namespace App\Http\Controllers;

use App\Opd;
use App\Lakip;
use App\PpkLayout;
use App\IkuSasaran;
use App\RpjmdTujuan;
use App\RenstraTujuan;
use App\PerjanjianKinerja2;
use Illuminate\Http\Request;
use App\PerjanjianKinerjaSasaran;

class ClientSakipController extends Controller
{
    public function index() 
    {
        return view('pages.sakip');
    }
    public function rencana_strategi() 
    {
        $opds = Opd::get();
        return view('pages.rencanaStrategi', ['opds' => $opds]);
    }
    public function rencana_strategi_cari(Request $request) 
    {
        $tahun_awal = $request->tahun_awal;
        $tahun_akhir = $request->tahun_akhir;
        $opd = $request->opd;

        $renstras = RenstraTujuan::whereHas('data_layout', function($query) {
            $query->where('deleted_at', null);
        })
        ->whereHas('data_renstra', function($query) use ($tahun_awal, $tahun_akhir, $opd) {
            $query->where('tahun_awal', $tahun_awal)->where('tahun_akhir', $tahun_akhir)->where('opd_id', $opd);
        })
        ->with('data_renstra','data_layout.data_target', 'data_layout.data_sasaran', 'data_layout.data_indikator')->get();

        return response()->json([
            'success' => 'Berhasil mengambil data',
            'data' => $renstras
        ]);
    }
    public function rencana_program_kegiatan()
    {
        $opds = Opd::get();
        return view('pages.rencanaProgramKegiatan', ['opds' => $opds]);
    }
    public function rencana_program_kegiatan_cari(Request $request)
    {
        $tahun_awal = $request->tahun_awal;
        $tahun = $request->tahun;
        $opd = $request->opd;

        $ppks = PpkLayout::whereHas('data_ppk', function($query) use ($tahun, $tahun_awal, $opd) {
            $query->where('tahun', $tahun)->where('tahun_awal', $tahun_awal)->where('opd_id', $opd);
        })
        ->where('deleted_at', null)
        ->with(
            'data_ppk', 
            'data_sasaran', 
            'data_indikator_kinerja',
            'data_indikator_kinerja.data_indikator'
        )
        ->get();

        return response()->json([
            'success' => 'Berhasil mengambil data',
            'data' => $ppks
        ]);
    }
    public function indikator_kinerja_utama() 
    {
        $opds = Opd::get();
        return view('pages.indikatorKinerjaUtama', ['opds' => $opds]);
    }
    public function indikator_kinerja_utama_cari(Request $request) 
    {
        $tahun_awal = $request->tahun_awal;
        $tahun_akhir = $request->tahun_akhir;
        $opd = $request->opd;

        $ikus = IkuSasaran::whereHas('data_layout', function($query) {
            $query->where('deleted_at', null);
        })
        ->whereHas('data_iku', function($query) use ($tahun_awal, $tahun_akhir, $opd) {
            $query->where('tahun_awal', $tahun_awal)->where('tahun_akhir', $tahun_akhir)->where('opd_id', $opd);
        })
        ->with('data_iku', 'data_layout.data_sasaran', 'data_layout.data_indikator')->get();

        return response()->json([
            'success' => 'Berhasil mengambil data',
            'data' => $ikus
        ]);
    }
    public function perjanjian_kinerja()
    {
        $opds = Opd::get();
        return view('pages.perjanjianKinerja', ['opds' => $opds]);
    }
    public function perjanjian_kinerja_cari(Request $request)
    {
        $tahun_awal = $request->tahun_awal;
        $tahun_akhir = $request->tahun_akhir;
        $opd = $request->opd;

        $perjanjianKinerjas = PerjanjianKinerjaSasaran::whereHas('data_layout', function($query) {
            $query->where('deleted_at', null);
        })
        ->whereHas('data_perjanjian_kinerja', function($query) use ($tahun_awal, $tahun_akhir, $opd) {
            $query->where('tahun_awal', $tahun_awal)->where('tahun_akhir', $tahun_akhir)->where('opd_id', $opd);
        })
        ->with('data_perjanjian_kinerja', 'data_layout.data_sasaran', 'data_layout.data_indikator')->get();

        return response()->json([
            'success' => 'Berhasil mengambil data',
            'data' => $perjanjianKinerjas
        ]);
    }
    public function perjanjian_kinerja2()
    {
        $opds = Opd::get();
        $perjanjianKinerja2s = PerjanjianKinerja2::with('data_opd')
        ->get();
        return view('pages.perjanjianKinerja', ['opds' => $opds, 'perjanjianKinerja2s' => $perjanjianKinerja2s]);
    }
    public function perjanjian_kinerja2_cari(Request $request)
    {
        $opds = Opd::get();
        $perjanjianKinerja2s = perjanjianKinerja2::where('opd_id', $request->opd)->where('tahun', $request->tahun)
        ->with('data_opd')
        ->get();
        
        $data = array(
            'tahun'  => $request->tahun,
            'opd' => $request->opd
        );

        return view('pages.perjanjianKinerja', ['data' => $data, 'opds' => $opds, 'perjanjianKinerja2s' => $perjanjianKinerja2s]);
    }
    public function realisasi_kinerja()
    {
        $opds = Opd::get();
        return view('pages.realisasiKinerja', ['opds' => $opds]);
    }
    public function realisasi_kinerja_cari(Request $request)
    {
        $tahun = $request->tahun;
        $opd = $request->opd;

        $ppk_Layout = PpkLayout::whereHas('data_ppk', function($query) use ($tahun, $opd) {
            $query->where('tahun', $tahun)->where('opd_id', $opd);
        })
        ->where('deleted_at', null)
        ->with(
            'data_ppk',
            'data_realisasi_kinerja',
            'data_sasaran',
            'data_indikator_kinerja'
        )
        ->get();

        return response()->json([
            'success' => 'Berhasil mengambil data',
            'data' => $ppk_Layout
        ]);
    }
    public function rpjmd()
    {
        $opds = Opd::get();
        return view('pages.rpjmd', ['opds' => $opds]);
    }
    public function rpjmd_cari(Request $request)
    {
        $tahun_awal = $request->tahun_awal;
        $tahun_akhir = $request->tahun_akhir;

        $rpjmds = RpjmdTujuan::whereHas('data_layout', function($query) {
            $query->where('deleted_at', null);
        })
        ->whereHas('data_rpjmd', function($query) use ($tahun_awal, $tahun_akhir) {
            $query->where('tahun_awal', $tahun_awal)->where('tahun_akhir', $tahun_akhir);
        })
        ->with('data_rpjmd','data_layout.data_target', 'data_layout.data_sasaran', 'data_layout.data_indikator')->get();

        return response()->json([
            'success' => 'Berhasil mengambil data',
            'data' => $rpjmds
        ]);
    }
    public function lakip()
    {
        $opds = Opd::get();
        $lakips = Lakip::with('data_opd')
        ->get();
        return view('pages.lakip', ['opds' => $opds, 'lakips' => $lakips]);
    }
    public function lakip_cari(Request $request)
    {
        $opds = Opd::get();
        $lakips = Lakip::where('opd_id', $request->opd)->where('tahun', $request->tahun)
        ->with('data_opd')
        ->get();
        
        $data = array(
            'tahun'  => $request->tahun,
            'opd' => $request->opd
        );

        return view('pages.lakip', ['data' => $data, 'opds' => $opds, 'lakips' => $lakips]);
    }
    public function grafik()
    {
        return view('pages.grafik');
    }
}
