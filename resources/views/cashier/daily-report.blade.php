@extends('layouts.cashier')

@section('title', 'Daily Sales Report')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-orange-50 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-chart-line text-orange-500 mr-2"></i>Daily Sales Report
                </h2>
                <div class="flex space-x-3">
                    <input type="date" id="reportDate" value="{{ $date ?? date('Y-m-d') }}" 
                           class="px-3 py-1 border rounded-lg focus:outline-none focus:border-orange-500 text-sm">
                    <button onclick="loadReport()" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-1 rounded-lg transition text-sm">
                        <i class="fas fa-search"></i> View
                    </button>
                    <button onclick="exportToExcel()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded-lg transition text-sm">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </button>
                </div>
            </div>
        </div>
        
        <div id="reportContent" class="p-6">
            <!-- Report Header -->
            <div class="text-center mb-6 border-b pb-4">
                <h2 class="text-2xl font-bold text-gray-800"><span class="text-yellow-400 text-3xl">G</span>ameTech UNLI FIBER</h2>
                <p class="text-gray-600">Daily Sales Report</p>
                <p class="text-gray-500">{{ date('F d, Y', strtotime($date ?? date('Y-m-d'))) }}</p>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-green-50 rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-600">Total Amount</p>
                    <p class="text-2xl font-bold text-green-600">₱{{ number_format($totalAmount ?? 0, 2) }}</p>
                </div>
                <div class="bg-blue-50 rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-600">Transactions</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalTransactions ?? 0 }}</p>
                </div>
                <div class="bg-purple-50 rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-600">Average Payment</p>
                    <p class="text-2xl font-bold text-purple-600">₱{{ isset($totalTransactions) && $totalTransactions > 0 ? number_format(($totalAmount ?? 0) / $totalTransactions, 2) : '0.00' }}</p>
                </div>
                <div class="bg-orange-50 rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-600">Prepared By</p>
                    <p class="text-lg font-bold text-orange-600">{{ auth()->user()->name }}</p>
                </div>
            </div>

            <!-- Payment Methods Breakdown -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="border rounded-lg p-3 text-center">
                    <i class="fas fa-money-bill-wave text-green-500 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">Cash</p>
                    <p class="font-bold text-gray-800">₱{{ number_format($cashTotal ?? 0, 2) }}</p>
                </div>
                <div class="border rounded-lg p-3 text-center">
                    <i class="fas fa-credit-card text-blue-500 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">Card</p>
                    <p class="font-bold text-gray-800">₱{{ number_format($cardTotal ?? 0, 2) }}</p>
                </div>
                <div class="border rounded-lg p-3 text-center">
                    <i class="fas fa-university text-purple-500 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">Bank Transfer</p>
                    <p class="font-bold text-gray-800">₱{{ number_format($bankTransferTotal ?? 0, 2) }}</p>
                </div>
                <div class="border rounded-lg p-3 text-center">
                    <i class="fas fa-mobile-alt text-orange-500 text-xl mb-1"></i>
                    <p class="text-xs text-gray-500">GCash</p>
                    <p class="font-bold text-gray-800">₱{{ number_format($gcashTotal ?? 0, 2) }}</p>
                </div>
            </div>

            <!-- Transactions Table -->
            @if(isset($payments) && $payments->count() > 0)
            <div class="overflow-x-auto">
                <table id="reportTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Receipt #</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment Method</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reference #</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($payments as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $payment->created_at->format('h:i A') }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-orange-500">{{ $payment->receipt_number }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $payment->customer->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm font-bold text-green-600">₱{{ number_format($payment->amount, 2) }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100">
                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $payment->reference_number ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-right font-bold">TOTAL:</td>
                            <td class="px-4 py-3 text-sm font-bold text-green-600">₱{{ number_format($totalAmount ?? 0, 2) }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-receipt fa-3x mb-2"></i>
                <p>No transactions found for this date</p>
            </div>
            @endif

            <!-- Report Footer -->
            <div class="mt-6 pt-4 border-t text-center text-xs text-gray-400">
                <p>This is a system-generated report. For inquiries, please contact the administrator.</p>
                <p>Generated on: {{ now()->format('F d, Y h:i A') }}</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

<script>
    function loadReport() {
        const date = document.getElementById('reportDate').value;
        window.location.href = "{{ route('cashier.daily.report') }}?date=" + date;
    }
    
    function exportToExcel() {
        // Get the current date for filename
        const date = document.getElementById('reportDate').value;
        const formattedDate = date.replace(/-/g, '');
        
        // Get the report table
        const table = document.getElementById('reportTable');
        
        if (!table) {
            alert('No data to export');
            return;
        }
        
        // Get report header info
        const companyName = "GameTech UNLI FIBER";
        const reportDate = new Date(date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
        const preparedBy = "{{ auth()->user()->name }}";
        const generatedDate = new Date().toLocaleString();
        
        // Prepare data for Excel
        const data = [];
        
        // Add header info
        data.push([companyName]);
        data.push(['Daily Sales Report']);
        data.push(['Date:', reportDate]);
        data.push(['Generated On:', generatedDate]);
        data.push(['Prepared By:', preparedBy]);
        data.push([]); // Empty row
        
        // Add summary row
        data.push(['SUMMARY STATISTICS']);
        data.push(['Total Amount:', '₱{{ number_format($totalAmount ?? 0, 2) }}']);
        data.push(['Total Transactions:', '{{ $totalTransactions ?? 0 }}']);
        data.push(['Average Payment:', '₱{{ isset($totalTransactions) && $totalTransactions > 0 ? number_format(($totalAmount ?? 0) / $totalTransactions, 2) : '0.00' }}']);
        data.push([]);
        
        // Add payment methods breakdown
        data.push(['PAYMENT METHODS BREAKDOWN']);
        data.push(['Cash:', '₱{{ number_format($cashTotal ?? 0, 2) }}']);
        data.push(['Card:', '₱{{ number_format($cardTotal ?? 0, 2) }}']);
        data.push(['Bank Transfer:', '₱{{ number_format($bankTransferTotal ?? 0, 2) }}']);
        data.push(['GCash:', '₱{{ number_format($gcashTotal ?? 0, 2) }}']);
        data.push([]);
        
        // Extract table headers
        const headers = [];
        const headerCells = table.querySelectorAll('thead th');
        headerCells.forEach(cell => {
            // Get text without icon
            let headerText = cell.innerText.trim();
            headerText = headerText.replace('↓', '').replace('↑', '').trim();
            headers.push(headerText);
        });
        data.push(headers);
        
        // Extract table rows
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const rowData = [];
            const cells = row.querySelectorAll('td');
            cells.forEach(cell => {
                // Clean up cell text (remove any HTML span elements)
                let cellText = cell.innerText.trim();
                rowData.push(cellText);
            });
            data.push(rowData);
        });
        
        // Add footer
        data.push([]);
        data.push(['Report Footer']);
        data.push(['This is a system-generated report. For inquiries, please contact the administrator.']);
        
        // Create worksheet
        const ws = XLSX.utils.aoa_to_sheet(data);
        
        // Adjust column widths
        ws['!cols'] = [
            {wch: 12},  // Time
            {wch: 18},  // Receipt #
            {wch: 25},  // Customer
            {wch: 15},  // Amount
            {wch: 18},  // Payment Method
            {wch: 20}   // Reference #
        ];
        
        // Style the header row (bold)
        const headerRange = XLSX.utils.decode_range(ws['!ref']);
        for (let C = headerRange.s.c; C <= headerRange.e.c; ++C) {
            const address = XLSX.utils.encode_cell({ r: 10, c: C }); // Row where headers are
            if (!ws[address]) continue;
            ws[address].s = { font: { bold: true, sz: 12 } };
        }
        
        // Create workbook
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, `Daily_Report_${formattedDate}`);
        
        // Export to Excel
        XLSX.writeFile(wb, `Daily_Sales_Report_${formattedDate}.xlsx`);
    }
</script>
@endsection