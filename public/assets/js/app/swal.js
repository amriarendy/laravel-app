const flashStatus = $('.flashdata').data('flashdata-true');
const flashMassage = $('.flashdata').data('flashdata-msg');
if (flashMassage) {
    swal({
        title: flashStatus,
        text: flashMassage,
        icon: flashStatus,
        button: "Ok!",
    })
}