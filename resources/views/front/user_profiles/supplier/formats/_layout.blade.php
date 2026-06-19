<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:w="urn:schemas-microsoft-com:office:word"
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>@yield('title')</title>
    <!--[if gte mso 9]>
    <xml>
        <w:WordDocument>
            <w:View>Print</w:View>
            <w:Zoom>100</w:Zoom>
        </w:WordDocument>
    </xml>
    <![endif]-->
    <style>
        @page Section1 {
            size: 21.59cm 27.94cm;
            margin: 2.5cm 2.5cm 2.5cm 2.5cm;
        }
        div.Section1 { page: Section1; }
        body {
            font-family: 'Calibri', 'Arial', sans-serif;
            font-size: 11pt;
            color: #000000;
            line-height: 1.5;
        }
        h1 {
            text-align: center;
            font-size: 22pt;
            font-weight: normal;
            margin: 0 0 6pt 0;
        }
        .subtitle {
            text-align: center;
            color: #2d2d86;
            font-size: 12pt;
            font-weight: bold;
            letter-spacing: .5px;
            margin: 0 0 40pt 0;
        }
        .date-line { text-align: right; margin: 28pt 0 40pt 0; }
        .addressee { font-weight: bold; margin-bottom: 30pt; line-height: 1.4; }
        p { text-align: justify; margin: 0 0 14pt 0; }
        .fields p { text-align: left; margin: 0 0 2pt 0; font-weight: bold; }
        .signature { text-align: center; margin-top: 70pt; }
        .note { font-size: 9pt; margin-top: 30pt; text-align: justify; }
        .center { text-align: center; }
    </style>
</head>
<body>
<div class="Section1">
    @yield('content')
</div>
</body>
</html>
