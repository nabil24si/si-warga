<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan {{ $namaBulan }} {{ $tahun }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10pt;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            color: #0f172a;
            font-size: 18pt;
        }
        .header p {
            margin: 5px 0 0;
            color: #64748b;
            font-size: 12pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #e2e8f0;
        }
        th {
            background-color: #0f172a;
            color: #ffffff;
            text-align: left;
            text-transform: uppercase;
            font-size: 9pt;
        }
        tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .text-emerald {
            color: #059669;
        }
        .text-red {
            color: #dc2626;
        }
        .summary-box {
            width: 100%;
            margin-top: 20px;
        }
        .summary-box table {
            width: 50%;
            float: right;
            border: none;
        }
        .summary-box th, .summary-box td {
            border: none;
            padding: 6px 10px;
            font-size: 11pt;
        }
        .summary-box th {
            background-color: transparent;
            color: #333;
            text-transform: none;
            text-align: right;
            font-weight: bold;
        }
        .summary-box .saldo-row th, .summary-box .saldo-row td {
            border-top: 2px solid #0f172a;
            font-size: 12pt;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN KAS RT/RW</h2>
        <p>Periode {{ $namaBulan }} {{ $tahun }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="25%">Kategori</th>
                <th width="35%">Keterangan</th>
                <th width="20%" class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $index => $t)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $t->tanggal_transaksi->format('d/m/Y') }}</td>
                    <td>{{ $t->kategori }}</td>
                    <td>{{ $t->keterangan ?: '-' }}</td>
                    <td class="text-right">
                        @if($t->jenis_transaksi === 'pemasukan')
                            <span class="text-emerald">+ {{ number_format($t->nominal, 0, ',', '.') }}</span>
                        @else
                            <span class="text-red">- {{ number_format($t->nominal, 0, ',', '.') }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada transaksi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary-box">
        <table>
            <tr>
                <th>Total Pemasukan:</th>
                <td class="text-right text-emerald">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total Pengeluaran:</th>
                <td class="text-right text-red">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
            <tr class="saldo-row">
                <th>SALDO AKHIR:</th>
                <td class="text-right"><strong>Rp {{ number_format($saldo, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
        <div class="clear"></div>
    </div>

    <div style="margin-top: 50px; text-align: right; padding-right: 50px;">
        <p>Dicetak pada: {{ date('d F Y H:i') }}</p>
    </div>

</body>
</html>
