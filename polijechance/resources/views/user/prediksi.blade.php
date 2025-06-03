@extends('layouts.home')

@section('content')
<div class="container">
    <h2>Form Prediksi Kelulusan</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

   

@if ($errors->has('msg'))
    <div class="alert alert-danger">
        {{ $errors->first('msg') }}
    </div>
@endif


<form method="POST" action="{{ route('predict.submit') }}">
  @csrf

  <div class="mb-3">
      <label for="file">Pilih File CSV</label>
      <select name="file" id="file" class="form-select" required>
          <option value="">-- Pilih File --</option>
          @foreach($files as $file)
              <option value="{{ $file }}">{{ $file }}</option>
          @endforeach
      </select>
  </div>

  <div class="row">
      <div class="col-md-6">
          <div class="mb-3"><label>Nilai Rata-rata</label><input type="number" step="0.01" name="RATA_RATA" class="form-control" required></div>
          <div class="mb-3"><label>Nilai Matematika</label><input type="number" step="0.01" name="MAT" class="form-control" required></div>
          <div class="mb-3"><label>Nilai Biologi</label><input type="number" step="0.01" name="BIO" class="form-control" required></div>
          <div class="mb-3"><label>Nilai Kimia</label><input type="number" step="0.01" name="KIM" class="form-control" required></div>
          <div class="mb-3"><label>Nilai Bahasa Inggris</label><input type="number" step="0.01" name="BIG" class="form-control" required></div>
          <div class="mb-3"><label>Indeks</label><input type="number" step="0.001" name="INDEKS" value="0.892" class="form-control" readonly></div>
      </div>
      <div class="col-md-6">
        <div class="mb-3 border rounded p-3">
            <label class="form-label">Sertifikat (Opsional)</label>
            <input type="file" name="certificate_file" class="form-control mb-2" accept=".jpg,.jpeg,.png" onchange="handleFileUpload(event)" id="certificateFile">

            <!-- Tombol Modal -->
            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#sertifikatModal">
                Pilih Tipe + Preview
            </button>
        </div>

        <div class="modal fade" id="sertifikatModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Sertifikat - Tipe dan Preview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <!-- Preview Sertifikat -->
        <div class="mb-3">
          <label class="form-label">Preview Sertifikat:</label>
          <div id="previewContainerModal"></div>
        </div>

        <div class="row">
            <div class="col-md-4">
  <!-- Tipe Sertifikat -->
        <label class="form-label">Bidang Prestasi</label>
        <div class="form-check">
        <input class="form-check-input" type="radio" name="bidangPrestasi" value="Olahraga" id="olahraga">
        <label class="form-check-label" for="olahraga">Olahraga</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="bidangPrestasi" value="Seni Rupa/Lukis" id="seni">
        <label class="form-check-label" for="seni">Seni Rupa/Lukis</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="bidangPrestasi" value="Seni Tari" id="seni_tari">
        <label class="form-check-label" for="seni_tari">Seni Tari</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="bidangPrestasi" value="Drama/Sastra" id="drama_sastra">
        <label class="form-check-label" for="drama_sastra">Drama/Sastra</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="bidangPrestasi" value="Seni Suara/Musik" id="seni_suara">
        <label class="form-check-label" for="seni_suara">Seni Suara/Musik</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="bidangPrestasi" value="Pramuka/Ekstrakurikuler" id="pramuka">
        <label class="form-check-label" for="pramuka">Pramuka/Ekstrakurikuler</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="bidangPrestasi" value="Penelitian" id="penelitian">
        <label class="form-check-label" for="penelitian">Penelitian</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="bidangPrestasi" value="Olimpiade Matematika" id="O_mtk">
        <label class="form-check-label" for="O_mtk">Olimpiade Matematika</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="bidangPrestasi" value="Olimpiade Fisika" id="O_fis">
        <label class="form-check-label" for="O_fis">Olimpiade Fisika</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="bidangPrestasi" value="Olimpiade Kimia" id="O_kim">
        <label class="form-check-label" for="O_kim">Olimpiade Kimia</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="bidangPrestasi" value="Olimpiade Biologi" id="O_bio_1">
        <label class="form-check-label" for="O_bio_1">Olimpiade Biologi</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="bidangPrestasi" value="Olimpiade Astronomi & Astrofisika" id="O_astro_1">
        <label class="form-check-label" for="O_astro_1">Olimpiade Astronomi & Astrofisika</label>
      </div>
       <div class="form-check">
        <input class="form-check-input" type="radio" name="bidangPrestasi" value="Olimpiade Komputer" id="O_kom_1">
        <label class="form-check-label" for="O_kom_1">Olimpiade Komputer</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="bidangPrestasi" value="Olimpiade Geografi" id="O_geo_1">
        <label class="form-check-label" for="O_geo_1">Olimpiade Geografi</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="bidangPrestasi" value="Olimpiade Ilmu Kebumian" id="O_bumi">
        <label class="form-check-label" for="O_bumi">Olimpiade Ilmu Kebumian</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="bidangPrestasi" value="Olimpiade Ekonomi" id="O_eko">
        <label class="form-check-label" for="O_eko">Olimpiade Ekonomi</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="bidangPrestasi" value="Olimpiade (lainnya)" id="O_eko">
        <label class="form-check-label" for="O_eko">Olimpiade (lainnya)</label>
      </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tingkat Prestasi</label>
                <div class="form-check">
            <input class="form-check-input" type="radio" name="tingkatPrestasi" value="Internasional" id="inter">
            <label class="form-check-label" for="inter">Internasional</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="tingkatPrestasi" value="Nasional" id="nasional">
            <label class="form-check-label" for="nasional">Nasional</label>
        </div>
         <div class="form-check">
            <input class="form-check-input" type="radio" name="tingkatPrestasi" value="Provinsi" id="prov">
            <label class="form-check-label" for="prov">Provinsi</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="tingkatPrestasi" value="Kabupaten/Kota" id="Kab">
            <label class="form-check-label" for="Kab">Kabupaten/Kota</label>
        </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Individu/Kelompok</label>
                <div class="form-check">
            <input class="form-check-input" type="radio" name="jenisPeserta" value="Individu" id="single">
            <label class="form-check-label" for="single">Individu</label>
        </div>
         <div class="form-check">
            <input class="form-check-input" type="radio" name="jenisPeserta" value="Kelomok" id="grup">
            <label class="form-check-label" for="grup">Kelompok</label>
        </div>
            </div>

        </div>

        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="simpanSertifikat()" data-bs-dismiss="modal">Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
  </div>
        




  <!-- Tempat hasil sertifikat ditampilkan -->
  <div id="carouselSertifikat" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner" id="carouselInner"></div>

  <button class="carousel-control-prev btn btn-outline-secondary border-0 my-5" type="button" data-bs-target="#carouselSertifikat" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next btn btn-outline-secondary border-0 my-5" type="button" data-bs-target="#carouselSertifikat" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
  </div>

    
  </div>

      <input type="hidden" name="certificate_average_score" id="certificate_average_score" value="0">

  </div>

  <button type="submit" class="btn btn-primary">Prediksi</button>
</form>

{{-- @if(session('prediction'))
  <div class="alert alert-success mt-3">
      <strong>Hasil Prediksi:</strong> {{ session('prediction') }}
  </div>
@endif --}}

@if($errors->any())
  <div class="alert alert-danger mt-3">
      <ul class="mb-0">
          @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
          @endforeach
      </ul>
  </div>
@endif

<div class="card mt-4" id="hasil-prediksi">
  <div class="card-header">
    <h4 class="card-title">Hasil Prediksi</h4>
  </div>
  <div class="card-body">
    @if (session('result'))
    <div class="alert alert-success">
        peluang Kemungkinan anda Lolos: <strong>{{ session('result') }}</strong>
    </div>
@endif


    @if($errors->has('msg'))
      <div class="alert alert-danger">
          {{ $errors->first('msg') }}
      </div>
    @endif
  </div>
</div>

</div>

<script>
  let selectedFileDataURL = null;
  let sertifikatCounter = 1;
  let nilaiSertifikatList = [];
  let nilaiKategori = {
    bidangPrestasi: [],
    tingkatPrestasi: [],
    jenisPeserta: []
};

const nilaiMap = {
    bidangPrestasi: {
        "Olahraga": 5,
        "Seni Rupa/Lukis": 5,
        "Seni Tari": 5,
        "Drama/Sastra": 5,
        "Seni Suara/Musik": 5,
        "Pramuka/Ekstrakurikuler": 5,
        "Penelitian": 5,
        "Olimpiade Matematika": 10,
        "Olimpiade Fisika": 10,
        "Olimpiade Kimia": 10,
        "Olimpiade Biologi": 10,
        "Olimpiade Astronomi & Astrofisika": 10,
        "Olimpiade Komputer": 10,
        "Olimpiade Geografi": 10,
        "Olimpiade Ilmu Kebumian": 10,
        "Olimpiade Ekonomi": 10,
        "Olimpiade (lainnya)": 10
    },
    tingkatPrestasi: {
        "Internasional": 20,
        "Nasional": 15,
        "Provinsi": 10,
        "Kabupaten/Kota": 5
    },
    jenisPeserta: {
        "Individu": 20,
        "Kelompok": 10
    }
};

function handleFileUpload(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
        selectedFileDataURL = e.target.result;
        const preview = document.getElementById("previewContainerModal");
        preview.innerHTML = "";

        if (file.type.startsWith("image/")) {
            const img = document.createElement("img");
            img.src = selectedFileDataURL;
            img.className = "img-fluid";
            img.style.maxHeight = "300px";
            preview.appendChild(img);
        } else {
            preview.innerHTML = `<a href="${e.target.result}" target="_blank">Lihat File</a>`;
        }
    };
    reader.readAsDataURL(file);
}
document.addEventListener("DOMContentLoaded", function() {
        const resultSection = document.getElementById("hasil-prediksi");
        if (resultSection) {
            resultSection.scrollIntoView({ behavior: "smooth" });
        }
    });

function simpanSertifikat() {
    if (!selectedFileDataURL) {
        alert("Harap upload file terlebih dahulu.");
        return;
    }

    const bidang = document.querySelector('input[name="bidangPrestasi"]:checked');
    const tingkat = document.querySelector('input[name="tingkatPrestasi"]:checked');
    const jenis = document.querySelector('input[name="jenisPeserta"]:checked');

    if (!bidang || !tingkat || !jenis) {
        alert("Harap pilih bidang, tingkat, dan jenis peserta.");
        return;
    }

    const carouselInner = document.getElementById("carouselInner");

    const carouselItem = document.createElement("div");
    carouselItem.className = carouselInner.children.length === 0 ? "carousel-item active" : "carousel-item";

    const wrapper = document.createElement("div");
    wrapper.className = "p-3 text-center position-relative";

    const label = document.createElement("h5");
    label.textContent = `Sertifikat ${sertifikatCounter++}`;

    const previewDiv = document.createElement("div");
    if (selectedFileDataURL.startsWith("data:image")) {
        const img = document.createElement("img");
        img.src = selectedFileDataURL;
        img.className = "img-fluid";
        img.style.maxHeight = "250px";
        previewDiv.appendChild(img);
    } else {
        const link = document.createElement("a");
        link.href = selectedFileDataURL;
        link.target = "_blank";
        link.textContent = "Lihat Sertifikat";
        previewDiv.appendChild(link);
    }

    const nilaiBidang = nilaiMap.bidangPrestasi[bidang.value] || 0;
    const nilaiTingkat = nilaiMap.tingkatPrestasi[tingkat.value] || 0;
    const nilaiJenis = nilaiMap.jenisPeserta[jenis.value] || 0;

    nilaiKategori.bidangPrestasi.push(nilaiBidang);
    nilaiKategori.tingkatPrestasi.push(nilaiTingkat);
    nilaiKategori.jenisPeserta.push(nilaiJenis);
    nilaiSertifikatList.push(1); // untuk menghitung jumlah

    const keterangan = document.createElement("p");
    keterangan.textContent = `${bidang.value} - ${tingkat.value} - ${jenis.value}`;

    const btnHapus = document.createElement("button");
    btnHapus.className = "btn btn-sm btn-danger position-absolute top-0 end-0 m-2";
    btnHapus.textContent = "Hapus";
    btnHapus.onclick = () => {
        const isActive = carouselItem.classList.contains("active");
        const idx = Array.from(carouselInner.children).indexOf(carouselItem);

        carouselItem.remove();

        if (idx !== -1) {
            nilaiSertifikatList.splice(idx, 1);
            nilaiKategori.bidangPrestasi.splice(idx, 1);
            nilaiKategori.tingkatPrestasi.splice(idx, 1);
            nilaiKategori.jenisPeserta.splice(idx, 1);
        }

        updateAverageScore();

        if (isActive && carouselInner.children.length > 0) {
            carouselInner.children[0].classList.add("active");
        }
    };

    wrapper.appendChild(btnHapus);
    wrapper.appendChild(label);
    wrapper.appendChild(previewDiv);
    wrapper.appendChild(keterangan);
    carouselItem.appendChild(wrapper);
    carouselInner.appendChild(carouselItem);

    document.getElementById("certificateFile").value = "";
    document.getElementById("previewContainerModal").innerHTML = "";
    document.querySelectorAll('input[name="bidangPrestasi"]').forEach(cb => cb.checked = false);
    document.querySelectorAll('input[name="tingkatPrestasi"]').forEach(cb => cb.checked = false);
    document.querySelectorAll('input[name="jenisPeserta"]').forEach(cb => cb.checked = false);
    selectedFileDataURL = null;

    updateAverageScore();
}

function updateAverageScore() {
    const allValues = [
        ...(nilaiKategori.bidangPrestasi || []),
        ...(nilaiKategori.tingkatPrestasi || []),
        ...(nilaiKategori.jenisPeserta || [])
    ];

    const average = allValues.length > 0
        ? allValues.reduce((a, b) => a + b, 0) / nilaiSertifikatList.length
        : 0;

    const inputAverageScore = document.getElementById("certificate_average_score");
    if (inputAverageScore) {
        inputAverageScore.value = average.toFixed(2);
    }

    const display = document.getElementById("average_score_display");
    if (display) {
        display.textContent = average.toFixed(2);
    }
}



</script>

@endsection

