<?php

namespace App\Http\Controllers;

use App\Models\CertificateDetail;
use App\Models\ComplaintDetail;
use App\Models\ProjectDetail;
use App\Models\Resident;
use App\Models\TransactionDetail;
use App\Models\Violation;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $total_residents = Resident::count();
        $total_certificates = CertificateDetail::count();
        $total_complaints = ComplaintDetail::count();
        $total_projects = ProjectDetail::count();
        $total_transactions = TransactionDetail::count();
        $total_violations = Violation::count();

        $complaintsPerYear = ComplaintDetail::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        return view('Dashboard', compact(
            'total_residents',
            'total_certificates',
            'total_complaints',
            'total_projects',
            'total_transactions',
            'total_violations',
            'complaintsPerYear'
        ));
    }

    public function AdminStaff()
    {
        $total_residents = Resident::count();
        $total_certificates = CertificateDetail::count();
        $total_complaints = ComplaintDetail::count();
        $total_projects = ProjectDetail::count();
        $total_transactions = TransactionDetail::count();
        $total_violations = Violation::count();

        $complaintsPerYear = ComplaintDetail::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        return view('DashboardAdminStaff', compact(
            'total_residents',
            'total_certificates',
            'total_complaints',
            'total_projects',
            'total_transactions',
            'total_violations',
            'complaintsPerYear'
        ));
    }

}
