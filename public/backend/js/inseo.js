$(document).ready(function() {
    $('#jenis').select2();
    $('#waktu_pelaksanaan').datepicker({
      autoclose: true
    });
    $('#krp')
        .bootstrapValidator({
            fields: {
                jenis: {
                    message: 'tidak valid',
                    validators: {
                        notEmpty: {
                            message: 'Jenis Kegiatan harus dipilih'
                        }
                    }
                },
                bidang: {
                    message: 'tidak valid',
                    validators: {
                        notEmpty: {
                            message: 'Bidang Kegiatan harus dipilih'
                        }
                    }
                },
                kegiatan: {
                    message: 'tidak valid',
                    validators: {
                        notEmpty: {
                            message: 'Nama Kegiatan harus dipilih'
                        }
                    }
                },
                tingkat: {
                    message: 'tidak valid',
                    validators: {
                        notEmpty: {
                            message: 'Tingkat harus dipilih'
                        }
                    }
                },
                partisipasi: {
                    message: 'tidak valid',
                    validators: {
                        notEmpty: {
                            message: 'Partisipasi harus dipilih'
                        }
                    }
                },
            }
        })
        .on('error.form.bv', function(e) {
        var $form = $(e.target);

        })
        .on('error.form.bv', function(e) {

        var $form = $(e.target);

        })
        .on('success.form.bv', function(e) {

        })
        .on('error.field.bv', function(e, data) {

        })
        .on('success.field.bv', function(e, data) {

        });
 });

 function kosongbidang() {
   // $('#fmbidang').html("");
   document.getElementById("bidang").innerHTML = null;
   $('#fmbidang').hide();
 }

 function kosongkegiatan() {
   // $('#fmkegiatan').html("");
   document.getElementById("kegiatan").innerHTML = null;
   $('#fmkegiatan').hide();
 }

 function kosongtingkat() {
   // $('#fmtingkat').html("");
   document.getElementById("tingkat").innerHTML = null;
   $('#fmtingkat').hide();
 }

 function kosongpartisipasi() {
   // $('#fmpartisipasi').html("");
   document.getElementById("partisipasi").innerHTML = null;
   $('#fmpartisipasi').hide();
 }

 function cmdbidang(){
    kosongbidang();
    kosongkegiatan();
    kosongtingkat();
    kosongpartisipasi();
    var jenis = $("#jenis").val();
    console.log(jenis);
    var request = $.ajax ({
      //  url : "{{ url('cmdbidang') }}/"+jenis,
       url : "/../../cmdbidang/"+jenis,
       beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
       type : "GET",
       dataType: "html"
    });

    request.done(function(output) {
      $('#bidang').select2();
      $('#bidang').html(output);
      $('#fmbidang').show();
    });
}

 function cmdkegiatan(){
    kosongkegiatan();
    kosongtingkat();
    kosongpartisipasi();
    var bidang = $("#bidang").val();
    console.log(bidang);
    var request = $.ajax ({
      //  url : "{{ url('cmdkegiatan') }}/"+bidang,
       url : "/../../cmdkegiatan/"+bidang,
       beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
       type : "GET",
       dataType: "html"
    });

    request.done(function(output) {
      $('#kegiatan').select2();
      $('#kegiatan').html(output);
      $('#fmkegiatan').show();
    });
}

  function cmdtingkat(){
   kosongtingkat();
   kosongpartisipasi();
   var kegiatan = $("#kegiatan").val();
   console.log(kegiatan);
   var request = $.ajax ({
      // url : "{{ url('cmdtingkat') }}/"+kegiatan,
      url : "/../../cmdtingkat/"+kegiatan,
      beforeSend: function (xhr) {
           var token = $('meta[name="csrf_token"]').attr('content');
           if (token) {
                 return xhr.setRequestHeader('X-CSRF-TOKEN', token);
           }
       },
      type : "GET",
      dataType: "html"
   });

   request.done(function(output) {
     if(output != "kosong"){
       $('#tingkat').select2();
       $('#tingkat').html(output);
       $('#fmtingkat').show();
     } else {
       $('#fmtingkat').hide();
     }
   });
}

function cmdpartisipasi(){
 kosongpartisipasi();
 var kegiatan = $("#kegiatan").val();
 console.log(kegiatan);
 var request = $.ajax ({
    // url : "{{ url('cmdpartisipasi') }}/"+kegiatan,
    url : "/../../cmdpartisipasi/"+kegiatan,
    beforeSend: function (xhr) {
         var token = $('meta[name="csrf_token"]').attr('content');
         if (token) {
               return xhr.setRequestHeader('X-CSRF-TOKEN', token);
         }
     },
    type : "GET",
    dataType: "html"
 });

 request.done(function(output) {
  if(output != "kosong"){
    $('#partisipasi').select2();
    $('#partisipasi').html(output);
    $('#fmpartisipasi').show();
  } else {
    $('#fmpartisipasi').hide();
  }
 });
}

var pdf=false;

function getFileExtension(filename){
  var ext = /^.+\.([^.]+)$/.exec(filename);
  return ext == null ? "" : ext[1];
}
function ValidateSingleInput(oInput) {
  // var _validFileExtensions = [".pdf", ".jpg", ".jpeg", ".png"];
  var _validFileExtensions = [".pdf"];
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    pdf=true;
                    break;
                }
            }

            if (!blnValid) {
                swal("Oops...", "File yang diupload harus .pdf", "error");
                oInput.value = "";
                pdf=false;
                return false;
            }
        }
    }
    return true;
}

function checkFileSize(inputFile) {
var max =  1024000; // 1MB

if (inputFile.files && inputFile.files[0].size > max) {
    swal("Oops...", "File terlalu besar (lebih dari 1MB) ! Mohon kompres/perkecil ukuran file", "error");
    inputFile.value = null; // Clear the field.
   }
}

function cekskkdasar(){
 var kegiatan = $("#kegiatan").val();
 var request = $.ajax ({
    // url : "{{ url('cekskkdasar') }}/"+kegiatan,
    url : "/../../cekskkdasar/"+kegiatan,
    beforeSend: function (xhr) {
         var token = $('meta[name="csrf_token"]').attr('content');
         if (token) {
               return xhr.setRequestHeader('X-CSRF-TOKEN', token);
         }
     },
    type : "GET",
    dataType: "html"
 });

 request.done(function(output) {
     document.getElementById("jenisdasar").innerHTML = output;
 });
}
