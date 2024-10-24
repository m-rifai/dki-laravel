<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationApproved;
use App\Models\AccountApplication;
use App\Models\Job;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class AccountApplicationController extends Controller
{
    /**
     * Konstruktor untuk menetapkan middleware.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:CS,Supervisor']);
    }

    /**
     * Menampilkan form pengajuan pembukaan rekening.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $jobs = Job::all();
        $provinces = Province::all();
        return view('applications.create', compact('jobs', 'provinces'));
    }

    /**
     * Menyimpan data pengajuan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => [
                'required',
                'string',
                'regex:/^[a-zA-Z\s]+$/',
                'not_regex:/\b(Profesor|Haji)\b/i',
                'unique:account_applications,full_name',
            ],
            'place_of_birth' => 'required|string',
            'date_of_birth' => 'required|date|date_format:Y-m-d',
            'gender' => 'required|in:Laki-laki,Wanita',
            'job_id' => 'required|exists:jobs,id',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'street_name' => 'required|string',
            'rt' => 'required|numeric',
            'rw' => 'required|numeric',
            'deposit_amount' => 'required|numeric',
        ]);

        $validatedData['user_id'] = Auth::id();
        $validatedData['status'] = 'Menunggu Approval';

        AccountApplication::create($validatedData);

        return redirect()->route('applications.index')->with('success', 'Pengajuan rekening berhasil dibuat dan menunggu approval.');
    }

    /**
     * Menampilkan daftar pengajuan oleh CS dengan DataTables.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            $applications = AccountApplication::where('user_id', $user->id)
                ->with(['job', 'province', 'city', 'district', 'village'])
                ->select('account_applications.*');

            return DataTables::of($applications)
                ->addIndexColumn()
                ->addColumn('status_badge', function ($application) {
                    $badgeClass = $application->status === 'Disetujui' ? 'bg-success' : 'bg-warning';
                    return '<span class="badge ' . $badgeClass . '">' . $application->status . '</span>';
                })
                ->addColumn('waktu_pengajuan', function ($application) {
                    return $application->created_at->format('Y-m-d H:i');
                })
                ->rawColumns(['status_badge'])
                ->make(true);
        }

        return view('applications.index');
    }

    /**
     * Menampilkan semua pengajuan untuk Supervisor dengan DataTables.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function indexAll(Request $request)
    {
        if ($request->ajax()) {
            $data = AccountApplication::with(['user', 'job', 'province', 'city', 'district', 'village'])->select('account_applications.*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('address', function ($row) {
                    return $row->street_name . ', RT ' . $row->rt . '/RW ' . $row->rw . ', ' . $row->village->name . ', ' . $row->district->name . ', ' . $row->city->name . ', ' . $row->province->name;
                })
                ->addColumn('status_badge', function ($row) {
                    $badgeClass = $row->status === 'Disetujui' ? 'bg-success' : ($row->status === 'Menunggu Approval' ? 'bg-warning' : 'bg-secondary');
                    return '<span class="badge ' . $badgeClass . '">' . $row->status . '</span>';
                })
                ->addColumn('action', function ($row) {
                    if ($row->status == 'Menunggu Approval') {
                        return '<button type="button" data-id="' . $row->id . '" class="approve btn btn-success btn-sm">Approve</button>';
                    }
                    return '';
                })
                ->rawColumns(['address', 'status_badge', 'action'])
                ->make(true);
        }

        return view('applications.indexAll');
    }

    /**
     * Melakukan approval oleh Supervisor.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function approve($id)
    {
        $application = AccountApplication::findOrFail($id);
        $application->status = 'Disetujui';
        $application->save();

        // Kirim email notifikasi ke CS
        $csUser = $application->user;
        Mail::to($csUser->email)->send(new ApplicationApproved($application));

        return response()->json(['success' => 'Pengajuan telah disetujui dan notifikasi email telah dikirim.']);
    }
}
