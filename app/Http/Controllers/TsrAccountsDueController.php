<?php

namespace App\Http\Controllers;

use App\Exports\TsrAccountDueDailyReportExport;
use App\Models\TsrAccountDueCustomeReport;
use App\Models\TsrAccountDueDailyReport;
use App\Models\TsrAccountDueIncomeReceipt;
use App\Models\TsrAccountDueIncome;
use App\Models\TsrAccountDueProvisionalInteger;
use App\Models\TsrCashierDailyCut;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TsrAccountsDueController extends Controller
{
    public function dashboard()
    {
        return view('tsr_accounts_due.dashboard');
    }

    public function cashbox()
    {
        $receipts = TsrAccountDueIncomeReceipt::get()->take(8);


        $recibos = TsrAccountDueIncomeReceipt::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),  // lunes
            Carbon::now()->endOfWeek()     // domingo
        ])->get();


        $weekCounts = [
            'Monday' => 0,  // Mo
            'Tuesday' => 0, // Tu
            'Wednesday' => 0, // We
            'Thursday' => 0, // Th
            'Friday' => 0, // Fr
            'Saturday' => 0, // Sa
            'Sunday' => 0  // Su
        ];


        foreach ($recibos as $recibo) {
            $day = Carbon::parse($recibo->created_at)->format('l'); // Ej: 'Monday'
            if (isset($weekCounts[$day])) {
                $weekCounts[$day]++;
            }
        }

        // Convertir a array de valores en orden
        $values = array_values($weekCounts);

        $latestDailyCut = TsrCashierDailyCut::query()
            ->whereDate('cut_date', today())
            ->latest('id')
            ->first();




        return view('tsr_accounts_due.cashbox')
            ->with('receipts', $receipts)
            ->with('values', $values)
            ->with('latestDailyCut', $latestDailyCut);
    }

    public function storeDailyCut(Request $request)
    {
        $validated = $request->validate([
            'cut_date' => 'required|date',
            'cashier' => 'nullable|string|max:255',
            'cashier_user' => 'nullable|string|max:255',
            'denominations' => 'required|array',
            'denominations_cashier' => 'nullable|string|max:255',
            'denominations_payed' => 'nullable|string|max:255',
        ]);

        $denominations = collect($validated['denominations'])
            ->mapWithKeys(function ($quantity, $denomination) {
                return [(string) $denomination => (float) ($quantity ?: 0)];
            })
            ->filter(function ($quantity) {
                return $quantity > 0;
            })
            ->toArray();

        $totalCash = 0;
        foreach ($denominations as $denomination => $quantity) {
            $totalCash += ((float) $denomination) * ((float) $quantity);
        }

        TsrCashierDailyCut::updateOrCreate(
            [
                'cut_date' => $validated['cut_date'],
                'cashier' => $validated['cashier'] ?? null,
            ],
            [
                'cashier_user' => $validated['cashier_user'] ?? null,
                'total_cash' => $totalCash,
                'denominations' => $denominations,
                'denominations_cashier' => $validated['denominations_cashier'] ?? null,
                'denominations_payed' => $validated['denominations_payed'] ?? null,
            ]
        );

        return redirect()
            ->route('account_due.cashbox')
            ->with('success', 'Corte diario guardado correctamente.');
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

        $conceptsToExport = !empty($report->concept)
            ? collect([$report->concept])
            : $concepts;

        foreach ($conceptsToExport as $concept) {
            $query = TsrAccountDueIncomeReceipt::whereHas('income', function ($query) use ($concept, $report) {
                $query->where('concept', $concept);

                if (!empty($report->dependency_name)) {
                    $query->where('department', $report->dependency_name);
                }
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
        $pdf = Pdf::loadView('tsr_accounts_due.daily_pdf', [
            'incomes' => $incomes,
            'concepts' => $concepts,
            'printedAt' => now(),
            'printedBy' => auth()->user()?->name ?? 'Sistema',
        ])->setPaper('A4');

        $today = today()->format('Y-m-d');

        return $pdf->download('reporte' . $today . '.pdf');
    }

    public function exportDailyExcel($id)
    {
        $report = TsrAccountDueDailyReport::findOrFail($id);

        $query = $this->buildDailyReportQuery($report)->with('income');

        $receipts = $query->orderBy('created_at', 'desc')->get();

        $today = today()->format('Y-m-d');

        return Excel::download(new TsrAccountDueDailyReportExport($receipts), 'reporte_diario_' . $today . '.xlsx');
    }

    private function buildDailyReportQuery(TsrAccountDueDailyReport $report)
    {
        $query = TsrAccountDueIncomeReceipt::query();

        if (!empty($report->cashier)) {
            $query->where('cashier', $report->cashier);
        }

        if (!empty($report->cashier_user)) {
            $query->where('cashier_user', $report->cashier_user);
        }

        if (!empty($report->dependency_name) || !empty($report->concept)) {
            $query->whereHas('income', function ($query) use ($report) {
                if (!empty($report->dependency_name)) {
                    $query->where('department', $report->dependency_name);
                }

                if (!empty($report->concept)) {
                    $query->where('concept', $report->concept);
                }
            });
        }

        return $query->whereDate('created_at', today());
    }

    public function report()
    {
        return view(('tsr_accounts_due.report'));
    }

    public function exportCustome($id)
    {

        $report = TsrAccountDueCustomeReport::find($id);

        // Realizar la consulta para obtener los ingresos filtrados
        $query = TsrAccountDueIncomeReceipt::query();

        if ($report->start_date) {
            $query->whereDate('created_at', '>=', $report->start_date);
        }
        if ($report->end_date) {
            $query->whereDate('created_at', '<=', $report->end_date);
        }

        if ($report->cashier) {
            $query->where('cashier', $report->cashier);
        }
        if ($report->cashier_user) {
            $query->where('cashier_user', $report->cashier_user);
        }
        if ($report->account) {
            $query->where('account', $report->account);
        }

        if (!empty($report->dependency_name) || !empty($report->concept)) {
            $query->whereHas('income', function ($query) use ($report) {
                if (!empty($report->dependency_name)) {
                    $query->where('department', $report->dependency_name);
                }

                if (!empty($report->concept)) {
                    $query->where('concept', $report->concept);
                }
            });
        }

        // Filtrado por métodos de pago
        // Filtrado por métodos de pago
        if (!empty($report->payment_methods)) {
            // Decodificar el campo JSON a un array
            $paymentMethods = json_decode($report->payment_methods, true);

            // Inicializar una consulta de tipo "or"
            $query->where(function ($query) use ($paymentMethods) {
                foreach ($paymentMethods as $method) {
                    switch ($method) {
                        case 'Tarjeta':
                            $query->orWhere('total_card', '>', 0);
                            break;
                        case 'Cheque':
                        case 'Voucher':
                            $query->orWhere('total_check', '>', 0);
                            break;
                        case 'Transferencia':
                            $query->orWhere('total_transfer', '>', 0);
                            break;
                        case 'Efectivo':
                            $query->orWhere('total_cash', '>', 0);
                            break;
                    }
                }
            });
        }

        // Obtener los ingresos filtrados
        $incomes = $query->get();

        // Generar el PDF con los ingresos y los conceptos
        $pdf = Pdf::loadView('tsr_accounts_due.custome_pdf', [
            'incomes' => $incomes,
            'printedAt' => now(),
            'printedBy' => auth()->user()?->name ?? 'Sistema',
        ])->setPaper('A4');

        $today = today()->format('Y-m-d');

        return $pdf->download('Reporte' . $today . '.pdf');
    }

    public function printInteger($id)
    {
        $integer = TsrAccountDueProvisionalInteger::find($id);

        $pdf = Pdf::loadView('tsr_accounts_due.provisional_integers.utilities.pdf', [
            'integer' => $integer,
            'printedAt' => now(),
            'printedBy' => auth()->user()?->name ?? 'Sistema',
        ])->setPaper('A4');


        return $pdf->download('Entero.pdf');
    }
}
