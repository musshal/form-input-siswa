<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <title>Form Input Siswa</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      margin: 32px;
    }

    .flex-container {
      display: flex;
      gap: 32px;
    }

    .card {
      width: 100%;
      height: 700px;
    }

    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
    }

    .error {
      color: red;
    }

    .submit, .edit {
      position: absolute;
      bottom: 15px;
    }

    .reset {
      position: absolute;
      bottom: 15px;
      left: 100px;
    }
  </style>
  <script>
    function validateEskul() {
      const eskul = document.forms["form_input_siswa"]["eskul[]"];
      let countEskul = 0;

      for (let i = 0; i < eskul.length; i++) {
        if (eskul[i].checked == true) {
          countEskul++;
        }
      }

      if (countEskul < 1) {
        document.getElementById("error_eskul").innerHTML = `
          Pilih minimal 1 ekstrakulikuler`;

        return false;
      } else if (countEskul > 3) {
        document.getElementById("error_eskul").innerHTML = `
          Pilih maksimal 3 ekstrakulikuler`;

        return false;
      }

      return true;
    }
  </script>
</head>
<body>
  <div class="flex-container">
    <div class="card">
      <div class="card-header">
        Form Input Siswa
      </div>
      <div class="card-body">
        <?php 
          if (isset($_POST["submit"])) {
            // validasi nis: tidak boleh kosong dan hanya boleh berisi angka
            $nis = test_input($_POST["nis"]);

            if (empty($nis)) {
              $error_nis = "NIS harus diisi";
            } else if (!preg_match("/^[0-9]*$/", $nis)) {
              $error_nis = "NIS hanya dapat berisi angka 0-9";
            }

            // validari nama: tidak boleh kosong dan hanya boleh berisi huruf
            $nama = test_input($_POST["nama"]);

            if (empty($nama)) {
              $error_nama = "Nama harus diisi";
            } else if (!preg_match("/^[a-zA-Z ]*$/", $nama)) {
              $error_nama = "Nama hanya dapat berisi huruf dan spasi";
            }

            // validasi jenis kelamin: tidak boleh kosong
            if (empty($_POST["jk"])) {
              $error_jk = "Jenis kelamin harus dipilih";
            }

            // validasi kelas: tidak boleh kosong
            $kelas = test_input($_POST["kelas"]);

            if (empty($kelas)) {
              $error_kelas = "Kelas harus dipilih";
            }
          }

          function test_input($data) {
            $data = trim($data);
            $data = stripslashes(($data));
            $data = htmlspecialchars($data);

            return $data;
          }
        ?>
        <form method="POST" autocomplete="on" id="form_input_siswa" onsubmit="return validateEskul()">
          <div class="mb-3">
            <label for="nis" class="form-label">NIS</label>
            <input type="text" class="form-control" id="nis" name="nis" maxlength="10" min="0">
            <div class="error"><?php if (isset($error_nis)) echo $error_nis; ?></div>
          </div>
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="name" class="form-control" id="nama" name="nama">
            <div class="error"><?php if (isset($error_nama)) echo $error_nama; ?></div>
          </div>
          <div class="mb-3">
            <label>Jenis Kelamin</label>
            <div class="form-check">
              <input type="radio" class="form-check-input" id="jk" name="jk" value="pria">
              <label class="form-check-label">Pria</label><br />
              <input type="radio" class="form-check-input" id="jk" name="jk" value="wanita">
              <label class="form-check-label">Wanita</label>
            </div>
            <div class="error"><?php if (isset($error_jk)) echo $error_jk; ?></div>
          </div>
          <div class="mb-3">
            <label for="kelas">Kelas:</label>
            <select name="kelas" id="kelas" class="form-select" onchange="getEskul()">
              <option value="">-- Pilih kelas --</option>
              <option value="x">X</option>
              <option value="xi">XI</option>
              <option value="xii">XII</option>
            </select>
            <div id="error_kelas" class="error"><?php if (isset($error_kelas)) echo $error_kelas; ?></div>
          </div>
          <div class="mb-3" id="eskul_element"></div>
          <button type="submit" class="submit btn btn-primary" name="submit">Submit</button>
          <button type="reset" class="reset btn btn-danger">Reset</button>
        </form>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        Data Hasil Input Siswa
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label for="nis" class="form-label">NIS</label>
          <input type="nis" class="form-control" id="nis" aria-describedby="emailHelp" disabled value="<?php if (isset($_POST["nis"])) echo $_POST["nis"] ?>">
        </div>
        <div class="mb-3">
          <label for="nama" class="form-label">Nama</label>
          <input type="name" class="form-control" id="nama" disabled value="<?php if (isset($_POST["nama"])) echo $_POST["nama"] ?>">
        </div>
        <div class="mb-3">
          <label>Jenis Kelamin</label>
          <div class="mb-3 form-check">
            <input type="radio" class="form-check-input" id="jk" value="pria" disabled <?php if (isset($_POST["jk"]) && $_POST["jk"] == "pria") echo "checked" ?>>
            <label class="form-check-label" for="jk">Pria</label><br />
            <input type="radio" class="form-check-input" id="jk" value="wanita" disabled <?php if (isset($_POST["jk"]) && $_POST["jk"] == "wanita") echo "checked" ?>>
            <label class="form-check-label" for="jk">Wanita</label>
          </div>
        </div>
        <div class="mb-3">
          <label for="kelas">Kelas:</label>
          <select name="kelas" id="kelas" class="form-control" disabled>
            <option <?php if (isset($_POST["kelas"]) && $_POST["kelas"] == "") echo "selected" ?>></option>
            <option value="x" <?php if (isset($_POST["kelas"]) && $_POST["kelas"] == "x") echo "selected" ?>>X</option>
            <option value="xi" <?php if (isset($_POST["kelas"]) && $_POST["kelas"] == "xi") echo "selected" ?>>XI</option>
            <option value="xii" <?php if (isset($_POST["kelas"]) && $_POST["kelas"] == "xii") echo "selected" ?>>XII</option>
          </select>
          <div id="error_kelas"></div>
        </div>
        <div class="mb-3">
          <label>Ekstrakulikuler</label>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="eskul[]" value="pramuka" disabled <?php if (isset($_POST["eskul"]) && in_array("pramuka", $_POST["eskul"])) echo "checked" ?>>
            <label class="form-check-label" for="eskul[]">Pramuka</label><br />
            <input type="checkbox" class="form-check-input" id="eskul[]" value="seni_tari" disabled <?php if (isset($_POST["eskul"]) && in_array("seni_tari", $_POST["eskul"])) echo "checked" ?>>
            <label class="form-check-label" for="eskul[]">Seni Tari</label><br />
            <input type="checkbox" class="form-check-input" id="eskul[]" value="sinematografi" disabled <?php if (isset($_POST["eskul"]) && in_array("sinematografi", $_POST["eskul"])) echo "checked" ?>>
            <label class="form-check-label" for="eskul[]">Sinematografi</label><br />
            <input type="checkbox" class="form-check-input" id="eskul[]" value="basket" disabled <?php if (isset($_POST["eskul"]) && in_array("basket", $_POST["eskul"])) echo "checked" ?>>
            <label class="form-check-label" for="eskul[]">Basket</label>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function getEskul() {
      const kelas = document.forms["form_input_siswa"]["kelas"].value;

      if ((kelas === "x") || (kelas === "xi")) {
        document.getElementById("error_kelas").innerHTML = '';
        document.getElementById("eskul_element").innerHTML = `
          <label>Ekstrakulikuler</label>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="eskul[]" name="eskul[]" value="pramuka">
            <label class="form-check-label" for="eskul[]">Pramuka</label><br />
            <input type="checkbox" class="form-check-input" id="eskul[]" name="eskul[]" value="seni_tari">
            <label class="form-check-label" for="eskul[]">Seni Tari</label><br />
            <input type="checkbox" class="form-check-input" id="eskul[]" name="eskul[]" value="sinematografi">
            <label class="form-check-label" for="eskul[]">Sinematografi</label><br />
            <input type="checkbox" class="form-check-input" id="eskul[]" name="eskul[]" value="basket">
            <label class="form-check-label" for="eskul[]">Basket</label>
          </div>
          <div id="error_eskul" class="error"></div>`;
      } else {
        document.getElementById("eskul_element").innerHTML = '';
      }
    }
  </script>
</body>
</html>