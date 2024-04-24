<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar Nilai Mahasiswa</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
  body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f3f4f6;
  }
  .container {
    width: 80%;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    padding: 20px;
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
  th, td {
    text-align: left;
    padding: 8px;
    border-bottom: 1px solid #ddd;
  }
  th {
    background-color: #f3f4f6;
  }
  .btn {
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
  }
  .btn-update {
    background-color: #4caf50;
    color: #fff;
    border: none;
  }
  .btn-delete {
    background-color: #f44336;
    color: #fff;
    border: none;
  }
  .btn-insert {
    background-color: #2196f3;
    color: #fff;
    border: none;
    margin-bottom: 10px;
  }
</style>
</head>
<body>

<div class="container">
  <h2 class="text-2xl font-bold mb-4">Daftar Nilai Mahasiswa</h2>

  <table>
    <thead>
      <tr>
        <th>NIM</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Tanggal Lahir</th>
        <th>Kode MK</th>
        <th>Nama MK</th>
        <th>SKS</th>
        <th>Nilai</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="nilaiMahasiswa">
      
    </tbody>
  </table>
  <br>
  <a href="insertNilai.php" class="btn btn-insert mt-4">Tambah Nilai</a>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const tableBody = document.querySelector('#nilaiMahasiswa');

    fetch('http://localhost/sait_project_api%20-%20UTS/api.php')
      .then(response => response.json())
      .then(data => {
        data.data.forEach(mahasiswa => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${mahasiswa.nim}</td>
            <td>${mahasiswa.nama}</td>
            <td>${mahasiswa.alamat}</td>
            <td>${mahasiswa.tanggal_lahir}</td>
            <td>${mahasiswa.kode_mk}</td>
            <td>${mahasiswa.nama_mk}</td>
            <td>${mahasiswa.sks}</td>
            <td>${mahasiswa.nilai}</td>
            <td>
                <a href="updateNilai.php?nim=${mahasiswa.nim}&kode_mk=${mahasiswa.kode_mk}" class="btn btn-update">Update</a>
                <button class="btn btn-delete" data-nim="${mahasiswa.nim}" data-kode-mk="${mahasiswa.kode_mk}">Delete</button>
            </td>
          `;
          tableBody.appendChild(row);
        });
      })
      .catch(error => console.error('Error fetching data:', error));

    tableBody.addEventListener('click', function(event) {
      if (event.target.classList.contains('btn-delete')) {
        const nim = event.target.getAttribute('data-nim');
        const kodeMk = event.target.getAttribute('data-kode-mk');
        if (confirm(`Apakah Anda yakin ingin menghapus data dengan NIM ${nim} dan kode MK ${kodeMk}?`)) {
          fetch(`http://localhost/sait_project_api%20-%20UTS/api.php?nim=${nim}&kode_mk=${kodeMk}`, {
            method: 'DELETE'
          })
          .then(response => response.json())
          .then(data => {
            alert(data.success || data.error);
            if (data.success) {
              event.target.closest('tr').remove();
            }
          })
          .catch(error => console.error('Error deleting data:', error));
        }
      }
    });
  });
</script>

</body>
</html>
