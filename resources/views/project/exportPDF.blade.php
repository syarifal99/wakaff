<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{$projek->nama}}</title>
    <style>
        @font-face {
            font-family: SourceSansPro;
            src: url(SourceSansPro-Regular.ttf);
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #00622f;
            text-decoration: none;
        }

        body {
            position: relative;
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #555555;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-family: SourceSansPro;
        }

        header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #AAAAAA;
        }

        #logo {
            float: left;
            margin-top: 8px;
            text-align: left;
        }

        #logo img {
            height: 70px;
        }

        #company {
            float: right;
            text-align: right;
        }

        #details {
            margin-bottom: 10px;
        }

        #client {
            padding-left: 6px;
            border-left: 6px solid #00622f;
            float: left;
            text-align: left;
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1.4em;
            font-weight: normal;
            margin: 0;
        }

        #invoice {
            float: right;
            text-align: right;
        }

        #invoice h1 {
            color: #00622f;
            font-size: 2.4em;
            line-height: 1em;
            font-weight: normal;
            margin: 0 0 10px 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }
        #thanks {
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices {
            padding-left: 6px;
            border-left: 6px solid #00622f;
        }

        #notices .notice {
            font-size: 1.2em;
        }

        footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #AAAAAA;
            padding: 8px 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <header class="clearfix">
        <table>
            <thead>
                <tr>
                    <th id="logo">
                        <img src="{{ public_path('img/logo.png') }}">
                    </th>
                    <th id="company">
                        <h2 class="name">PT. Sentral Fintech Indonesia</h2>
                        {{-- <div>Alamat : Lorem, ipsum dolor sit amet consectetur adipisicing elit. Veritatis, quibusdam.</div> --}}
                        {{-- <div><a href="mailto:company@example.com">company@example.com</a></div> --}}
                    </th>
                </tr>
            </thead>
        </table>
    </header>
    <main>
        <div id="details" class="clearfix">
            <table>
                <thead>
                    <tr>
                        <th id="client">
                            <div class="to">Detail projek:</div>
                            <h2 class="name">Nama: {{$projek->nama}}</h2>
                            {{-- <div class="address">Gambar: <img src="{{url($projek->gambar)}}" alt="Image"></div> --}}
                            <div class="address">Kategori: {{$projek->kategori->kategori}}</div>
                            <div class="address">Label: {{$projek->label->label}}</div>
                            <div class="address">Nominal: {{$projek->nominal}}</div>
                            <div class="address">Tenggang Waktu: {{$projek->tenggat_waktu}}</div>
                            <div class="address">Alamat: {{$projek->kota->kota}}, {{$projek->kota->provinsi->provinsi}}</div>
                            
                            {{-- <div class="email"><a href="mailto:john@example.com">john@example.com</a></div> --}}
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
        <div id="notices">
            <div>CATATAN:</div>
            <div class="notice">-</div>
        </div>
    </main>
    <footer>
        <script>document.write(new Date().getFullYear())</script> © Waqaf Zakat
    </footer>
</body>

</html>