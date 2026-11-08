<!DOCTYPE html>
<html lang="la">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Document - Logos Institute</title>

  <!-- ໂຫຼດ PDF.js Library ຈາກ CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

  <style>
    /* ປ້ອງກັນການເລືອກຂໍ້ຄວາມ ແລະ ຄລິກຂວາ */
    body {
      background-color: #525659;
      margin: 0;
      padding: 20px 0;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    #pdf-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 15px;
    }

    /* ຕົບແຕ່ງ Canvas ທີ່ສະແດງ PDF */
    canvas {
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
      max-width: 95%;
      height: auto !important;
      pointer-events: none; /* ປ້ອງກັນການ Drag ຫຼື ຄລິກຂວາເທິງ Canvas */
    }

    /* ຖ້າຜູ້ໃຊ້ພະຍາຍາມ Print ໜ້າເວັບ ຈະຊ່ອນເນື້ອຫາທັງໝົດ */
    @media print {
      body {
        display: none !important;
      }
    }
  </style>
</head>
<body>
<?php include_once __DIR__ . '/site_header.php'; ?>

  <!-- ສ່ວນທີ່ຈະ Render ໜ້າ PDF ອອກມາ -->
  <div id="pdf-container"></div>

  <script>
    // ຕັ້ງຄ່າ Worker ສຳລັບ PDF.js
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

 // 1. ດຶງຊື່ໄຟລ໌ຈາກ URL Parameter (ຖ້າບໍ່ມີ Parameter ຈະໃຊ້ໄຟລ໌ Default)
    const urlParams = new URLSearchParams(window.location.search);
    const pdfUrl = urlParams.get('file') || 'student re/student Regulations.pdf';

    // 2. ດຶງຂໍ້ມູນ PDF
    pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
      const container = document.getElementById('pdf-container');

      for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
        pdf.getPage(pageNum).then(page => {
          const scale = 1.5;
          const viewport = page.getViewport({ scale: scale });

          const canvas = document.createElement('canvas');
          const context = canvas.getContext('2d');
          canvas.height = viewport.height;
          canvas.width = viewport.width;

          const renderContext = {
            canvasContext: context,
            viewport: viewport
          };

          container.appendChild(canvas);
          page.render(renderContext);
        });
      }
    }).catch(err => {
      console.error('Error loading PDF:', err);
    });

    // --- ເພີ່ມ JavaScript ປ້ອງກັນການ Save/Print/Screenshot ---

    // 1. ປ້ອງກັນການຄລິກຂວາ
    document.addEventListener('contextmenu', e => e.preventDefault());

    // 2. ປ້ອງກັນຄີລັດ (Ctrl+S, Ctrl+P, Ctrl+U, F12)
    document.addEventListener('keydown', function (e) {
      if ((e.ctrlKey || e.metaKey) && (e.key === 's' || e.key === 'p' || e.key === 'u')) {
        e.preventDefault();
      }
      if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && e.key === 'I')) {
        e.preventDefault();
      }
      // ປ້ອງກັນ PrintScreen
      if (e.key === 'PrintScreen') {
        navigator.clipboard.writeText('');
        alert('ການແຄັບໜ້າຈໍຖືກປ້ອງກັນ!');
      }
    });
  </script>
</body>
</html>