<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $query = Activity::query();

        // Apply filters
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($request->filled('log_name')) {
            $query->where('log_name', $request->log_name);
        }

        if ($request->filled('causer_id')) {
            $query->where('causer_id', $request->causer_id);
        }

        $logs = $query->with('causer')->latest()->paginate(20);
        $users = \App\Models\User::all();
        $logNames = Activity::select('log_name')->distinct()->pluck('log_name');

        return view('admin.reports.index', compact('logs', 'users', 'logNames'));
    }

    public function downloadPdf(Request $request)
    {
        $query = Activity::query();

        // Apply same filters as index
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($request->filled('log_name')) {
            $query->where('log_name', $request->log_name);
        }

        if ($request->filled('causer_id')) {
            $query->where('causer_id', $request->causer_id);
        }

        $logs = $query->with('causer')->latest()->get();

        $pdf = Pdf::loadView('admin.reports.pdf', compact('logs'));
        return $pdf->download('activity-report-' . now()->format('Y-m-d-H-i-s') . '.pdf');
    }

    public function downloadCsv(Request $request)
    {
        $query = Activity::query();

        // Apply same filters as index
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($request->filled('log_name')) {
            $query->where('log_name', $request->log_name);
        }

        if ($request->filled('causer_id')) {
            $query->where('causer_id', $request->causer_id);
        }

        $logs = $query->with('causer')->latest()->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="activity-report-' . now()->format('Y-m-d-H-i-s') . '.csv"',
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Log Name', 'Description', 'User', 'Subject Type', 'Subject ID', 'Created At']);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->log_name,
                    $log->description,
                    $log->causer ? $log->causer->name : 'N/A',
                    $log->subject_type ?? 'N/A',
                    $log->subject_id ?? 'N/A',
                    $log->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}