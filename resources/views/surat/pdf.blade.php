<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat {{ $surat->jenis_surat }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 30px;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat h2, .kop-surat h3, .kop-surat p {
            margin: 0;
        }
        .judul-surat {
            text-align: center;
            margin-bottom: 30px;
        }
        .judul-surat h4 {
            margin: 0;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .content {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
        }
        td {
            vertical-align: top;
            padding: 4px 0;
        }
        .td-label {
            width: 30%;
        }
        .td-titik {
            width: 2%;
        }
        .td-value {
            width: 68%;
        }
        .ttd-container {
            margin-top: 50px;
            width: 100%;
        }
        .ttd-box {
            float: right;
            width: 300px;
            text-align: center;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h2>PENGURUS RUKUN TETANGGA (RT) {{ $surat->user->warga->rt_number ?? '...' }}</h2>
        <h3>RUKUN WARGA (RW) 01</h3>
        <p>Desa Suak Lanjut, Kecamatan Siak, Kabupaten Siak</p>
    </div>

    <div class="judul-surat">
        @php
            $jenis = strtoupper($surat->jenis_surat);
            $judul = str_starts_with($jenis, 'SURAT') ? $jenis : 'SURAT ' . $jenis;
        @endphp
        <h4>{{ $judul }}</h4>
        <p>Nomor: {{ rand(100,999) }}/RT.{{ $surat->user->warga->rt_number ?? '00' }}/{{ date('Y') }}</p>
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Pengurus RT {{ $surat->user->warga->rt_number ?? '...' }} Desa Suak Lanjut, menerangkan bahwa:</p>
        
        <table>
            <tr>
                <td class="td-label">Nama Lengkap</td>
                <td class="td-titik">:</td>
                <td class="td-value">{{ $surat->user->warga->nama_lengkap ?? $surat->user->name }}</td>
            </tr>
            <tr>
                <td class="td-label">NIK</td>
                <td class="td-titik">:</td>
                <td class="td-value">{{ $surat->user->warga->nik ?? '-' }}</td>
            </tr>
            <tr>
                <td class="td-label">Jenis Kelamin</td>
                <td class="td-titik">:</td>
                <td class="td-value">{{ $surat->user->warga->jenis_kelamin ?? '-' }}</td>
            </tr>
            <tr>
                <td class="td-label">Agama</td>
                <td class="td-titik">:</td>
                <td class="td-value">{{ $surat->user->warga->agama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="td-label">Pekerjaan</td>
                <td class="td-titik">:</td>
                <td class="td-value">{{ $surat->user->warga->pekerjaan ?? '-' }}</td>
            </tr>
            
            @if($surat->data_tambahan)
                @foreach($surat->data_tambahan as $key => $value)
                <tr>
                    <td class="td-label" style="text-transform: capitalize;">{{ str_replace('_', ' ', $key) }}</td>
                    <td class="td-titik">:</td>
                    <td class="td-value">{{ $value }}</td>
                </tr>
                @endforeach
            @endif
        </table>

        <p style="margin-top: 20px;">
            Orang tersebut di atas adalah benar warga kami dan bertempat tinggal di lingkungan RT {{ $surat->user->warga->rt_number ?? '...' }}. 
            Surat keterangan ini dibuat untuk keperluan: <strong>{{ $surat->keperluan }}</strong>.
        </p>
        <p>
            Demikian surat keterangan ini dibuat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya.
        </p>
    </div>

    <div class="ttd-container">
        <div class="ttd-box">
            <p>Kabupaten Siak, {{ date('d F Y') }}</p>
            <p style="margin-bottom: 70px;">Ketua RT {{ $surat->user->warga->rt_number ?? '...' }}</p>
            <p><strong>(.......................................)</strong></p>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>
