

//Employment
$(function () {
    $('#btnShow').on('click', function (event) {
        // $('#insert').val("Insert");  
        $('#addEmployment')[0].reset();
        event.preventDefault();
    });

});
$(document).ready(function () {
    $("#addEmployment").submit(function (event) {
        if ($('input[name="current_company"]:checked').val() === 'no')
        {
            $("#noticeperiod").val('');
            $("#current_ctc").val('');

        }
        jQuery.noConflict();
        submitFormEmployment();
        event.preventDefault();
        return false;
    });
});
$(document).ready(function () {
    $("#addResume").submit(function (event) {
        jQuery.noConflict();
        submitFormResume();
        event.preventDefault();
        return false;
    });
});
function submitFormResume() {
    // var data = new FormData(this.form);
    jQuery.ajax({

        url: "upload_resume.php",
        type: "POST",
        data: data,
        cache: false,
        success: function (data) {
            //alert(data);
            jQuery.noConflict();
            $("#modalFormAddResume").modal('hide');
            location.reload();
        },
        error: function (data) {
            //console.log(data);
            alert("Error");
        }
    });
}
function submitFormEmployment() {
    jQuery.ajax({
        type: "POST",
        url: "add_employment.php",
        cache: false,
        data: $('form#addEmployment').serialize(),
        success: function (data) {
            //alert("sucess" + data);
            jQuery.noConflict();
            $("#modalFormAddEmployment").modal('hide');
            location.reload();
        },
        error: function (data) {
            alert("fail" + data);
            alert("Error");
        }
    });
}

//Employment edit
$(function () {
    $(document).on('click', '.edit_employment', function () {
        var id = $(this).attr("id");
        $.ajax({
            url: "edit_employment.php",
            method: "POST",
            data: {id: id},
            dataType: "json",
            success: function (data) {
                //alert('js' + data.current_company_yes);
                jQuery.noConflict();
                $('#designation').val(data.designation);
                $('#organization').val(data.organization);
                $('#started_working_year').val(data.started_working_year);
                $('#started_working_month').val(data.started_working_month);
                $('#worked_till_year').val(data.worked_till_year);
                $('#worked_till_month').val(data.worked_till_month);
                $('#current_company_yes').val(data.current_company_yes);
                $('#current_company_no').val(data.current_company_no);
                $('#description').val(data.description);
                $('#noticeperiod').val(data.noticeperiod);
                $('#current_ctc').val(data.current_ctc);
                $('#id').val(data.id);
                if (data.current_company_yes === 'yes')
                {
                    $('#current_company_yes').prop('checked', true);
                    $('#current_company_no').prop('checked', false);
                    $("#notice_class").show();
                    $("#ctc_class").show();
                }
                if (data.current_company_no === 'yes')
                {
                    $('#current_company_no').prop('checked', true);
                    $('#current_company_yes').prop('checked', false);
                    $("#notice_class").hide();
                    $("#ctc_class").hide();
                }
                $('.employment').text("Edit Employment");
                $('#submitEmployment').val("UPDATE");
                $('#modalFormAddEmployment').modal('show');
            }

        });



    });

});


///Education
$(function () {
    $('#btnShowEducation').on('click', function (event) {

        // $('#insert').val("Insert");  
        $('#addEducation')[0].reset();


        event.preventDefault();
    });

});
$(document).ready(function () {
    $("#addEducation").submit(function (event) {
        jQuery.noConflict();
        event.preventDefault();
        submitFormEducation();
        return false;
    });
});

function submitFormEducation() {
    jQuery.ajax({
        type: "POST",
        url: "add_education.php",
        cache: false,
        data: jQuery('form#addEducation').serialize(),
        success: function (data) {

            jQuery.noConflict();

            $("#modalFormAddEducation").modal('hide');
            location.reload();
        },
        error: function (data) {
            alert(data);
            alert("Error");
        }
    });
}


//Education edit
$(function () {
    $(document).on('click', '.edit_education10th', function () {
		
		
		
		
        var id = $(this).attr("id");
        var name = $(this).attr("class_name");

        $.ajax({
            url: "edit_education.php",
            method: "POST",
            data: {id: id, name: name},
            dataType: "json",
            success: function (data) {
                jQuery.noConflict();
                $('#education_select').val(data.education);
                $('#10th_spcl').val(data.Specialization);
                $('#10th_school').val(data.School_Institute);
                $('#10th_university').val(data.University_Board);
                $('#10th_percentage').val(data.Percentage_CGPA);
                $('#10th_marks').val(data.Marks_Obtained);
                $('#10th_Pyear').val(data.Year_of_Passing);
                $('#id').val(data.id);
                $('.education').text("Edit Education");
                $('#drop_values').val(data.drop_values);
                $('#submiteducation').val("UPDATE");
                $('#modalFormAddEducation').modal('show');
            }
        });
    });

});
$(function () {
    $(document).on('click', '.edit_education12th', function () {
        var id = $(this).attr("id");
        var name = $(this).attr("class_name");

        $.ajax({
            url: "edit_education.php",
            method: "POST",
            data: {id: id, name: name},
            dataType: "json",
            success: function (data) {
                //alert(data);
                jQuery.noConflict();
                $('#education_select').val(data.education);
                $('#12th_spcl').val(data.Specialization);
                $('#12th_school').val(data.School_Institute);
                $('#12th_university').val(data.University_Board);
                $('#12th_percentage').val(data.Percentage_CGPA);
                $('#12th_marks').val(data.Marks_Obtained);
                $('#12th_Pyear').val(data.Year_of_Passing);
                $('#drop_values').val(data.drop_values);
                $('.education').text("Edit Education");
                $('#12th_maths_marks').val(data.subject3);
                $('#12th_chemistry_marks').val(data.subject2);
                $('#12th_physics_marks').val(data.subject1);
                $('#id').val(data.id);
                $('#submiteducation').val("UPDATE");
                $('#modalFormAddEducation').modal('show');
            }
        });
    });

});
$(function () {
    $(document).on('click', '.edit_educationbe', function () {
        var id = $(this).attr("id");
        var name = $(this).attr("class_name");

        $.ajax({
            url: "edit_education.php",
            method: "POST",
            data: {id: id, name: name},
            dataType: "json",
            success: function (data) {
                jQuery.noConflict();
                $('#education_select').val(data.education);
                $('#be_spcl').val(data.Specialization);
                $('#be_school').val(data.School_Institute);
                $('#be_university').val(data.University_Board);
                $('#be_percentage').val(data.Percentage_CGPA);
                $('#be_marks').val(data.Marks_Obtained);
                $('#be_Pyear').val(data.Year_of_Passing);
                $('#drop_values').val(data.drop_values);
                $('.education').text("Edit Education");
                $('#id').val(data.id);
                $('#submiteducation').val("UPDATE");
                $('#modalFormAddEducation').modal('show');
            }
        });
    });

});
$(function () {
    $(document).on('click', '.edit_educationme', function () {
        var id = $(this).attr("id");
        var name = $(this).attr("class_name");

        $.ajax({
            url: "edit_education.php",
            method: "POST",
            data: {id: id, name: name},
            dataType: "json",
            success: function (data) {
                jQuery.noConflict();
                //alert(data.Specialization);
                $('#education_select').val(data.education);
                $('#me_spcl').val(data.Specialization);
                $('#me_school').val(data.School_Institute);
                $('#me_university').val(data.University_Board);
                $('#me_percentage').val(data.Percentage_CGPA);
                $('#me_marks').val(data.Marks_Obtained);
                $('#me_Pyear').val(data.Year_of_Passing);
                $('#drop_values').val(data.drop_values);
                $('.education').text("Edit Education");
                $('#id').val(data.id);
                $('#submiteducation').val("UPDATE");
                $('#modalFormAddEducation').modal('show');
            }
        });
    });

});
$(function () {
    $(document).on('click', '.edit_educationmtech', function () {
        var id = $(this).attr("id");
        var name = $(this).attr("class_name");

        $.ajax({
            url: "edit_education.php",
            method: "POST",
            data: {id: id, name: name},
            dataType: "json",
            success: function (data) {
                jQuery.noConflict();
                $('#education_select').val(data.education);
                $('#mtech_spcl').val(data.Specialization);
                $('#mtech_school').val(data.School_Institute);
                $('#mtech_university').val(data.University_Board);
                $('#mtech_percentage').val(data.Percentage_CGPA);
                $('#mtech_marks').val(data.Marks_Obtained);
                $('#mtech_Pyear').val(data.Year_of_Passing);
                $('#drop_values').val(data.drop_values);
                $('.education').text("Edit Education");
                $('#id').val(data.id);
                $('#submiteducation').val("UPDATE");
                $('#modalFormAddEducation').modal('show');
            }
        });
    });

});
$(function () {
    $(document).on('click', '.edit_educationbtech', function () {
        var id = $(this).attr("id");
        var name = $(this).attr("class_name");

        $.ajax({
            url: "edit_education.php",
            method: "POST",
            data: {id: id, name: name},
            dataType: "json",
            success: function (data) {
                jQuery.noConflict();
                $('#education_select').val(data.education);
                $('#btech_spcl').val(data.Specialization);
                $('#btech_school').val(data.School_Institute);
                $('#btech_university').val(data.University_Board);
                $('#btech_percentage').val(data.Percentage_CGPA);
                $('#btech_marks').val(data.Marks_Obtained);
                $('#btech_Pyear').val(data.Year_of_Passing);
                $('#drop_values').val(data.drop_values);
                $('.education').text("Edit Education");
                $('#id').val(data.id);
                $('#submiteducation').val("UPDATE");
                $('#modalFormAddEducation').modal('show');
            }
        });
    });

});
$(function () {
    $(document).on('click', '.edit_educationmsc', function () {
        var id = $(this).attr("id");
        var name = $(this).attr("class_name");

        $.ajax({
            url: "edit_education.php",
            method: "POST",
            data: {id: id, name: name},
            dataType: "json",
            success: function (data) {
                jQuery.noConflict();
                $('#education_select').val(data.education);
                $('#msc_spcl').val(data.Specialization);
                $('#msc_school').val(data.School_Institute);
                $('#msc_university').val(data.University_Board);
                $('#msc_percentage').val(data.Percentage_CGPA);
                $('#msc_marks').val(data.Marks_Obtained);
                $('#msc_Pyear').val(data.Year_of_Passing);
                $('#drop_values').val(data.drop_values);
                $('.education').text("Edit Education");
                $('#id').val(data.id);
                $('#submiteducation').val("UPDATE");
                $('#modalFormAddEducation').modal('show');
            }
        });
    });

});
$(function () {
    $(document).on('click', '.edit_educationphd', function () {
        var id = $(this).attr("id");
        var name = $(this).attr("class_name");

        $.ajax({
            url: "edit_education.php",
            method: "POST",
            data: {id: id, name: name},
            dataType: "json",
            success: function (data) {
                jQuery.noConflict();
                $('#education_select').val(data.education);
                $('#phd_spcl').val(data.Specialization);
                $('#phd_school').val(data.School_Institute);
                $('#phd_university').val(data.University_Board);
                $('#phd_percentage').val(data.Percentage_CGPA);
                $('#phd_marks').val(data.Marks_Obtained);
                $('#phd_Pyear').val(data.Year_of_Passing);
                $('#drop_values').val(data.drop_values);
                $('#id').val(data.id);
                $('.education').text("Edit Education");
                $('#submiteducation').val("UPDATE");

                $('#modalFormAddEducation').modal('show');
            }
        });
    });

});
$(function () {
    $(document).on('click', '.edit_educationgate', function () {
        var id = $(this).attr("id");
        var name = $(this).attr("class_name");

        $.ajax({
            url: "edit_education.php",
            method: "POST",
            data: {id: id, name: name},
            dataType: "json",
            success: function (data) {
                jQuery.noConflict();
                $('#education_select').val(data.education);
                $('#domain').val(data.domain);
                $('#gate_score').val(data.All_India_Rank);
                $('#gate_marks').val(data.Marks);
                $('#gate_Pyear').val(data.Year_of_passing);
                $('#drop_values').val(data.drop_values);
                $('#id').val(data.id);
                $('.education').text("Edit Education");
                $('#submiteducation').val("UPDATE");
                $('#modalFormAddEducation').modal('show');
            }
        });
    });

});

///Skills

$(function () {
    $('#btnShowSkills').on('click', function (event) {
        event.preventDefault();
    });

});
$(document).ready(function () {
    $("#addSkill").submit(function (event) {
        event.preventDefault();
        submitFormSkill();
        return false;
    });
});

function submitFormSkill() {
    jQuery.ajax({
        type: "POST",
        url: "add_skills.php",
        cache: false,
        data: $('form#addSkill').serialize(),
        success: function (data) {
            //alert(data);
            jQuery.noConflict();
            $("#modalFormAddSkill").modal('hide');
            location.reload();
        },
        error: function () {
            alert("Error");
        }
    });
}
/*$(function () {
 $(document).on('click', '.edit_skill', function () {
 var id = $(this).attr("id");
 $.ajax({
 url: "edit_skill.php",
 method: "POST",
 data: {id: id},
 dataType: "json",
 success: function (data) {
 //alert(data);
 jQuery.noConflict();
 $('#skill_id').val(data.skill_id);
 $('#version').val(data.version);
 $('#last_used').val(data.last_used);
 $('#experience_year').val(data.experience_year);
 $('#experience_month').val(data.experience_month);
 $('#proficiency_level').val(data.proficiency_level);
 $('#id').val(data.id);
 $('.skill').text("Edit Skill");
 $('#submitskills').val("UPDATE");
 $('#us_id').val(data.us_id);
 $('#modalFormAddSkill').modal('show');
 
 }
 });
 });
 
 });*/
$(function () {
    $(document).on('click', '.edit_skill', function () {
        var id = $(this).attr("id");
        $.ajax({
            url: "edit_skill.php",
            method: "POST",
            data: {id: id},
            dataType: "json",
            success: function (data) {
                jQuery.noConflict();
                valArr = data.skill_id.split(":");
                var size = valArr.length;
                $('#skill_id option').each(function () {
                    var option_val = this.value;
                    for (var i = 0; i < size; i++) {
                       
                        if (valArr[i] == option_val) {
                           
                            $("#skill_id option[value='" + valArr[i] + "']").attr("selected", true);
                        }
                    }
                });
              $('#skill_id').multiselect(
        {            
            buttonWidth: '100%',
                nonSelectedText: 'Select Skills',
                 templates: {button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown" style="background:#fff;color: #000;"><span class="multiselect-selected-text" style="float:left"></span> <span style="float:right"><b class="caret"></b></span></button>'},
            });
              $('#tool_id').multiselect(
        {            
            buttonWidth: '100%',
                nonSelectedText: 'Select Tools', 
                templates: {button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown" style="background:#fff;color: #000;"><span class="multiselect-selected-text" style="float:left"></span> <span style="float:right"><b class="caret"></b></span></button>'},
            });
      
              
                $('select#skill_id').multiselect('refresh');
                 valArr1 = data.tool_id.split(",");
                 $('#tool_id').multiselect(
                        'select', valArr1
                        ).trigger("chosen:updated");
                $('#tool_version').val(data.version);
                $('#tool_last_used').val(data.last_used);
                $('#source').val(data.source_of_learning);
                $('#tool_proficiency_level').val(data.proficiency_level);
                $('#operating_systems').val(data.operating_systems);
                $('#id').val(data.id);
                $('.skill').text("Edit Skills and Tools");
                $('#submitskills').val("UPDATE");
                $('#us_id').val(data.us_id);
                $('#modalFormAddSkill').modal('show');

            }
        });
    });

});

//Tools

$(function () {
    $('#btnShowTools').on('click', function (event) {

        event.preventDefault();
    });

});
$(document).ready(function () {
    $("#addTool").submit(function (event) {
        //alert("hi");
        event.preventDefault();
        submitFormTool();
        return false;
    });
});

function submitFormTool() {
    jQuery.ajax({
        type: "POST",
        url: "add_tools.php",
        cache: false,
        data: $('form#addTool').serialize(),
        success: function (data) {
            //alert(data);
            jQuery.noConflict();
            $("#modalFormAddTools").modal('hide');
            location.reload();
        },
        error: function () {
            alert("Error");
        }
    });
}
$(function () {
    $(document).on('click', '.edit_tool', function () {
        var id = $(this).attr("id");
        $.ajax({
            url: "edit_tools.php",
            method: "POST",
            data: {id: id},
            dataType: "json",
            success: function (data) {
                //alert(data);
                jQuery.noConflict();
                $('#tool_id').val(data.tool_id);
                $('#tool_version').val(data.version);
                $('#tool_last_used').val(data.last_used);
                $('#source').val(data.knowledge_source);
                $('#tool_proficiency_level').val(data.proficiency_level);
                $('#id').val(data.id);
                $('.tools').text("Edit Tool");
                $('#submittools').val("UPDATE");
                $('#tooledit_id').val(data.us_id);
                $('#modalFormAddTools').modal('show');

            }
        });
    });

});


///Personal

$(function () {
    $('#btnShowPersonal').on('click', function (event) {

        event.preventDefault();
    });

});
$(document).ready(function () {
    $("#addPersonal").submit(function (event) {
        event.preventDefault();
        submitFormPersonal();
        return false;
    });
});

function submitFormPersonal() {
    jQuery.ajax({
        type: "POST",
        url: "addPersonal.php",
        cache: false,
        data: $('form#addPersonal').serialize(),
        success: function (data) {
            //alert(data);
            jQuery.noConflict();
            $("#modalFormAddPersonal").modal('hide');
            location.reload();
        },
        error: function () {
            alert("Error");
        }
    });
}

//Personal edit
jQuery(function () {
    jQuery(document).on('click', '.edit_personal', function () {
        var id = $(this).attr("id");
        jQuery.ajax({
            url: "get_personal.php",
            method: "POST",
            data: {id: id},
            dataType: "json",
            success: function (data) {jQuery.noConflict();
                //alert(data.id);
                $('#date_of_birth').val(data.date_of_birth);
                $('#permanent_address').val(data.permanent_address);
              //  $('#pin_code').val(data.pin_code);
                $('#passport_number').val(data.passport_number);
                $('#id').val(data.id);
                $('.personal').text("Edit Personal Details");
                $('#submitpersonal').val("UPDATE");
                $('#modalFormAddPersonal').modal('show');
            }
        });
    });

});


///Resume Headline


$(function () {
    $('#btnShowResumeHeadline').on('click', function (event) {

        event.preventDefault();
    });

});
$(document).ready(function () {
    $("#addResumeHeadline").submit(function (event) {
        submitFormResumeHeadline();
        event.preventDefault();
        return false;
    });
});

function submitFormResumeHeadline() {
    $.ajax({
        type: "POST",
        url: "add_resumeheadline.php",
        cache: false,
        data: $('form#addResumeHeadline').serialize(),
        success: function (data) {
            jQuery.noConflict();
            $("#modalFormResumeHeadline").modal('hide');
            location.reload();
        },
        error: function () {
            alert("Error");
        }
    });
}
$(function () {
    $(document).on('click', '.edit_headline', function () {
        var id = $(this).attr("id");
        $.ajax({
            url: "get_headline.php",
            method: "POST",
            data: {id: id},
            dataType: "json",
            success: function (data) {
                jQuery.noConflict();
                $('#resume_headline').val(data.resume_headline);
                $('#idheadline').val(data.user_id);
                $('.headline').text("Edit Resume Headline");
                $('#modalFormResumeHeadline').modal('show');
            }
        });
    });

});


///Basic Details
$(function () {
    $(document).on('click', '.btnShowBasicDetails', function () {



        var id = $(this).attr("id");
        $.ajax({
            url: "get_basicdetails.php",
            method: "POST",
            data: {id: id},
            dataType: "json",

            success: function (data) {
                jQuery.noConflict();
                $('#profile_name').val(data.profile_name);
                $('#username').val(data.username);
                $('#gender').val(data.gender);
                $('#key_words').val(data.skills_expertise);
                $('#mobile_number').val(data.mobile_number);
                $('#current_ctc_lakhs').val(data.current_ctc_lakhs);
                $('#current_ctc_thousands').val(data.current_ctc_thousands);
                $('#work_exp_years').val(data.work_exp_years);
                $('#work_exp_months').val(data.work_exp_months);
                $('#city').val(data.city);
                $('#email').val(data.email);
                $('#profile_photo').val(data.profile_photo);
                $('#id').val(data.user_id);
                $('#expected_annual_ctc').val(data.expected_salary);
                $('#expected_designation').val(data.expected_designation);
                $('#achievements').val(data.achivements);
                $('#multiple-checkboxes').multiselect(
                        'select', [data.job_location1, data.job_location2, data.job_location3]
                        ).trigger("chosen:updated");



                $('.basic').text("Edit Basic Details");
                $('#modalFormBasicDetails').modal('show');
            }
        });
    });

});

/*$(function () {
 $('#btnShowBasicDetails').on('click', function (event) {
 
 event.preventDefault();
 });
 
 });*/
$(document).ready(function () {
    $("#addBasicDetails").submit(function (event) {
		  jQuery.noConflict();
           event.preventDefault();
        submitFormBasicDetails();
        return false;
    });
    
    $("#form_register").submit(function (event) {



        var bool = null;
        var username = $('#username').val();


        $.ajax({
            url: "checkusername.php",
            method: "POST",
            async: false,
            data: {
                username: username,
            },
            success: function (response) {
                bool = response;
                //alert(response);
            },
            error: function () {
                alert("Error");
            }
        });

        if (bool === 'exist')
        {
            alert('Username Already Exist.');
            return false;
        }
        var recaptcha = $("#g-recaptcha-response").val();
        if (recaptcha === "") {
            event.preventDefault();
            alert("Please check the recaptcha");
            return false;
        }
        var numb = $('#resume_file')[0].files[0].size / 1024 / 1024;
        var type = $('#resume_file')[0].files[0].type;
        //alert(type);
        numb = numb.toFixed(2);
        if (numb > 2) {
            alert('Please upload resume of size <=2MB');
            return false;
        } else if (type != 'application/pdf') {
            alert('Sorry, invalid File Type of Resume.');
            return false;
        } else if (numb > 2 && type != 'application/pdf')
        {
            alert('Please upload pdf of size <=2MB.');
            return false;
        }

        return true;
    });
});

function submitFormBasicDetails() {
    var file_data = $('#uploadphoto').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    var data = $('form#addBasicDetails').serialize();
    form_data.append('post', data);
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "update_basicdetails.php",

        // cache: false,
        //data: $('form#addBasicDetails').serialize(),

        data: form_data,
        contentType: false,
        cache: false,
        processData: false,

        success: function (data) {
            //alert(data);

            $("#modalFormBasicDetails").modal('hide');
            location.reload();
        },
        error: function () {
            alert("Error");
        }
    });
}
$(document).ready(function () {
    $('#user_subject').hide();
    $('#user_marks').hide();
    $('[data-toggle="tooltip"]').tooltip();
    $('#education').on("change", function () {
        if ($('#education :selected').text() === '12th')
        {
            $('#user_subject').show();
            $('#user_marks').show();

        } else
        {
            $('#user_subject').hide();
            $('#user_marks').hide();
        }
    });
    
    $(".textarea_count_achi").on('keyup', function () { 

        var words1 = this.value.match(/\S+/g).length;

        if (words1 > 500) {
            // Split the string on first 200 words and rejoin on spaces
            var trimmed = $(this).val().split(/\s+/, 500).join(" ");
            // Add a space at the end to make sure more typing creates new words
            $(this).val(trimmed + " ");
        } else {
            //$('#display_count').text(words);
            $('.smalltextBoxAchi').val(500 - words1);
        }
    });
    
    $(".textarea_count").on('keyup', function () { 

        var words1 = this.value.match(/\S+/g).length;

        if (words1 > 500) {
            // Split the string on first 200 words and rejoin on spaces
            var trimmed = $(this).val().split(/\s+/, 500).join(" ");
            // Add a space at the end to make sure more typing creates new words
            $(this).val(trimmed + " ");
        } else {
            //$('#display_count').text(words);
            $('.smalltextBox').val(500 - words1);
        }
    });
    
    
       $(".textarea_count_key_words").on('keyup', function () { 

        var words1 = this.value.match(/\S+/g).length;

        if (words1 > 500) {
            // Split the string on first 200 words and rejoin on spaces
            var trimmed = $(this).val().split(/\s+/, 500).join(" ");
            // Add a space at the end to make sure more typing creates new words
            $(this).val(trimmed + " ");
        } else {
            //$('#display_count').text(words);
            $('.smalltextBox_key_words').val(500 - words1);
        }
    });
    
     
    
    
    $("#subject_count").on('keyup', function () {

        var words = this.value.match(/\S+/g).length;

        if (words > 40) {
            // Split the string on first 200 words and rejoin on spaces
            var trimmed = $(this).val().split(/\s+/, 40).join(" ");
            // Add a space at the end to make sure more typing creates new words
            $(this).val(trimmed + " ");
        } else {
            //$('#display_count').text(words);
            $('.subject_count_text').val(40 - words);
        }
    });
    

    
    

   



    $('#clear').on("click", function () {

        var elements = this.form.elements;

        //this.form.reset();

        for (i = 0; i < elements.length; i++) {

            field_type = elements[i].type.toLowerCase();
            //alert(field_type );
            switch (field_type) {

                case "text":
                case "password":
                case "textarea":
                case "hidden":

                    elements[i].value = "";
                    break;

                case "radio":
                case "checkbox":
                    if (elements[i].checked) {
                        elements[i].checked = false;
                    }
                    break;

                case "select-one":

                    elements[i].selectedIndex = -1;
                    break;

                default:
                    break;
            }
        }
    });


});




///GATE Details

$(function () {
    $('#btnShowGateDetails').on('click', function (event) {
        event.preventDefault();
    });

});
$(document).ready(function () {
    $("#addGateDetails").submit(function (event) {
        event.preventDefault();
        submitFormGateDetails();
        return false;
    });
});

function submitFormGateDetails() {
    jQuery.ajax({
        type: "POST",
        url: "add_gatedetails.php",
        cache: false,
        data: $('form#addGateDetails').serialize(),
        success: function (data) {
            //alert(data);
            jQuery.noConflict();
            $("#modalFormGATEdetails").modal('hide');
            location.reload();
        },
        error: function () {
            alert("Error");
        }
    });
}
$(function () {
    $(document).on('click', '#edit_gatedetails', function () {
        var id = $(this).attr("user_id");
        $.ajax({
            url: "edit_gatedetails.php",
            method: "POST",
            data: {id: id},
            dataType: "json",
            success: function (data) {
                //alert(data.domain);
                jQuery.noConflict();
                $('#domain').val(data.domain);
                $('#gate_score').val(data.All_India_Rank);
               // $('#gate_marks').val(data.Marks);
                $('#gate_Pyear').val(data.Year_of_passing);
                $('#update').val('update');
                $('.gate_details').text("Edit GATE Details");
                $('#submigatedetails').val("UPDATE");
                $('#modalFormGATEdetails').modal('show');

            }
        });
    });

});




