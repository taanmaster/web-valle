<?php

namespace App\Http\Controllers;

use App\Models\TsrAccountDueDailyReport;
use Illuminate\Http\Request;
use App\Models\TsrAccountDueIncomeReceipt;
use App\Models\TsrAccountDueIncome;
use Barryvdh\DomPDF\Facade\Pdf;

class TsrAccountsDueController extends Controller
{
    public function dashboard()
    {
        return view('tsr_accounts_due.dashboard');
    }

    public function cashbox()
    {
        $receipts = TsrAccountDueIncomeReceipt::get()->take(8);

        return view('tsr_accounts_due.cashbox')->with('receipts', $receipts);
    }

    public function dailyReport()
    {
        return view(('tsr_accounts_due.daily_report'));
    }

    public function exportDaily($id)
    {

        $report = TsrAccountDueDailyReport::find($id);

        $concepts = TsrAccountDueIncome::select('concept')->distinct()->pluck('concept');


        $incomes = [];

        foreach ($concepts as $concept) {
            $query = TsrAccountDueIncomeReceipt::whereHas('income', function ($query) use ($concept) {
                $query->where('concept', $concept);
            });

            // Solo aplicar las condiciones si las variables tienen valores
            if (!empty($report->cashier)) {
                $query->where('cashier', $report->cashier);
            }

            if (!empty($report->cashier_user)) {
                $query->where('cashier_user', $report->cashier_user);
            }

            // Filtrar por la fecha de hoy
            $query->whereDate('created_at', today()); // Asegúrate de que 'created_at' sea el campo correcto

            $incomes[$concept] = $query->paginate(10, ['*'], "page_{$concept}");
        }


        // Generar el PDF con los ingresos y los conceptos
        $pdf = PDF::loadView('tsr_accounts_due.daily_pdf', [
            'incomes' => $incomes,
            'concepts' => $concepts
        ])->setPaper('A4');

        $today = today()->format('Y-m-d');

        return $pdf->download('reporte' . $today . '.pdf');
    }

    public function report()
    {
        return view(('tsr_accounts_due.report'));
    }
}
