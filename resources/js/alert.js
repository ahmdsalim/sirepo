window.confirmOnDel = function confirmOnDel(ele) {
    Swal.fire({
       title: 'Yakin ingin menghapus?',
       text: "Semua data yang berkaitan akan ikut terhapus",
       icon: 'question',
       showCancelButton: true,
       confirmButtonColor: '#233446',
       cancelButtonColor: '#8592a3',
       confirmButtonText: 'Hapus',
       cancelButtonText: 'Batal'
    }).then((result) => {
       if (result.value) {
          ele.closest('form').submit();
       }
    })
 }