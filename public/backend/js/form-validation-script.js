var Script = function () {

    // $.validator.setDefaults({
    //     submitHandler: function() { alert("submitted!"); }
    // });

    $().ready(function() {
        // validate the comment form when it is submitted
        // $("#commentForm").validate();

        // validate signup form on keyup and submit
        // $("#hasil").validate({
        //     rules: {
        //         jawaban: "required",
        //         deskripsi: "required",
        //     },
        //     messages: {
        //         jawaban: "Silahkan Jawab",
        //         deskripsi: "Masukkan Deskripsi Bukti Fisik",
        //     }
        // });

        $("#create_output").validate({
            rules: {
                terserap: {
                  required: true,
                  digits: true,
                },
                realisasi: {
                  required: true,
                  digits: true,
                },
                tgl_digunakan: "required",
                keterangan: "required",
            },
            messages: {
                terserap: {
                  required: "Masukkan dana yang terserap",
                  digits: "Dana harus angka",
                },
                realisasi: {
                  required: "Masukkan realisasi",
                  digits: "Realisasi harus angka",
                },
                tgl_digunakan: "Masukkan kegiatan",
                keterangan: "Masukkan Hasil",
            }
        });

        $("#logbook").validate({
            rules: {
                tgl: "required",
                tempat: "required",
                kegiatan: "required",
                hasil: "required",
            },
            messages: {
                tgl: "Pilih tanggal",
                tempat: "Masukkan tempat kegiatan",
                kegiatan: "Masukkan kegiatan",
                hasil: "Masukkan Hasil",
            }
        });

        $("#fmarsip").validate({
            rules: {
                arsip: "required",
            },
            messages: {
                arsip: "Judul arsip harus diisi",
            }
        });

        $("#fmfile").validate({
            rules: {
                judul: "required",
                file: "required",
            },
            messages: {
                judul: "Judul File harus diisi",
                file: "File harus diisi",
            }
        });

        $("#fmusers").validate({
            rules: {
                name: "required",
                username: "required",
                username: {
                    required: true,
                    minlength: 2
                },
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                },
                email: {
                    required: true,
                    email: true
                },
            },
            messages: {
                name: "Nama harus diisi",
                username: {
                    required: "Masukkan Username",
                    minlength: "Username minimal 2 karakter"
                },
                password: {
                    required: "Masukkan Password",
                    minlength: "Password minimal 6 digit"
                },
                password_confirmation: {
                    required: "Masukkan Password",
                    minlength: "Password minimal 6 digit",
                    equalTo: "Masukkan Password yang sama"
                },
                email: "Masukkan email yang benar",
            }
        });

        $("#fmusersedit").validate({
            rules: {
                name: "required",
                username: "required",
                username: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
            },
            messages: {
                name: "Nama harus diisi",
                username: {
                    required: "Masukkan Username",
                    minlength: "Username minimal 2 karakter"
                },
                email: "Masukkan email yang benar",
            }
        });

        $("#biodata").validate({
            rules: {
                nama: "required",
                noidentitas: "required",
                tmplahir: "required",
                tgllahir: "required",
                jeniskelamin: "required",
                alamat: "required",
                instansi: "required",
                jabatan: "required",
                photo: "required",
            },
            messages: {
                nama: "Nama harus diisi",
                noidentitas: "Nomor Identitas harus diisi",
                tmplahir: "Tempat lahir harus diisi",
                tgllahir: "Tanggal lahir harus diisi",
                jeniskelamin: "Jenis kelamin harus diisi",
                alamat: "Alamat harus diisi",
                instansi: "Instansi harus diisi",
                jabatan: "Jabatan harus diisi",
                photo: "Foto harus diisi",
            }
        });

        $("#instrumen").validate({
            rules: {
                nomor_urut: {
                    required: true,
                    minlength: 1,
                    maxlength: 3,
                    digits: true
                },
                subjek: "required",
                kompetensi: "required",
                pertanyaan: "required",
            },
            messages: {
                adphone: {
                  required: "Masukkan nomor urut",
                  minlength: "Minimal 1 Digit",
                  maxlength: "3 Digit",
                  digits: "Nomor urut harus angka"
                },
                subjek: "Pilih subjek",
                kompetensi: "Nama harus diisi",
                pertanyaan: "Nomor Identitas harus diisi",
            }
        });

        $("#fmwork").validate({
            rules: {
                masa_kerja: {
                    required: true,
                    digits: true
                },
            },
            messages: {
                masa_kerja: {
                  required: "Masukkan nomor urut",
                  digits: "Harus angka"
                }
            }
        });

        // propose username by combining first- and lastname
        $("#username").focus(function() {
            var firstname = $("#firstname").val();
            var lastname = $("#lastname").val();
            if(firstname && lastname && !this.value) {
                this.value = firstname + "." + lastname;
            }
        });

        //code to hide topic selection, disable for demo
        var newsletter = $("#newsletter");
        // newsletter topics are optional, hide at first
        var inital = newsletter.is(":checked");
        var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
        var topicInputs = topics.find("input").attr("disabled", !inital);
        // show when newsletter is checked
        newsletter.click(function() {
            topics[this.checked ? "removeClass" : "addClass"]("gray");
            topicInputs.attr("disabled", !this.checked);
        });
    });


}();
