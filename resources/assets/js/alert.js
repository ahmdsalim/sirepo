window.confirmOnDel = function confirmOnDel(ele) {
   Swal.fire({
      title: 'Konfirmasi Hapus',
      text: "Apakah anda yakin ingin menghapus?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#233446',
      cancelButtonColor: '#8592a3',
      confirmButtonText: 'Ya, Lanjutkan',
      cancelButtonText: 'Batal'
   }).then((result) => {
      if (result.value) {
         ele.closest('form').submit();
      }
   })
}