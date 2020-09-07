import Swal from 'sweetalert2'

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 5000
});

window.Toast = Toast;

jQuery(document).ready(function($){
    
    //----- Open model CREATE -----//
    jQuery('#btn-form').click(function () {
        jQuery('#btn-create-notification').val("add");
        jQuery("#title").removeClass("is-invalid");  
        jQuery("#title-error-message").text(); 
        jQuery("#description").removeClass("is-invalid");  
        jQuery("#description-error-message").text(); 
        jQuery("#role").removeClass("is-invalid");  
        jQuery("#role-error-message").text(); 
        jQuery('#notificationForm').trigger("reset");
        jQuery('#notificationModal').modal('show');

    });

    // CREATE
    $("#btn-create-notification").click(function (e) {
        // console.log('imworking');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var formData = {
            title: jQuery('#title').val(),
            description: jQuery('#description').val(),
            role: jQuery('#role').val(),
        };
        var state = jQuery('#btn-create-notification').val();
        var type = "POST";
        // var exam_id = jQuery('#exam_id').val();
        var ajaxurl = 'notifications';
        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                // var exam = '<tr id="exam' + data.id + '"><td scope="row">' + data.id + '</td><td>' + data.title + '</td>';
                // exam += '<td><button type="button" class="btn btn-outline-info btn-sm" id="examView" data-id="'+ data.id +'">view</button>';
                // exam += '<button type="button" class="btn btn-outline-secondary btn-sm" id="examEdit" data-id="'+ data.id +'">Edit</button>';
                // exam += '<button type="button" class="btn btn-outline-danger btn-sm" id="examDelete" data-id="'+ data.id +'">Delete</button></td></tr>';
                // if (state == "add") {
                //     jQuery('#exam-lists').append(exam);
                // } else {
                //     jQuery("#exam" + exam_id).replaceWith(exam);
                // }

                // console.log(data.status);
                if (data.status === true) {
                    Toast.fire({
                      type: 'success',
                      title: data.message
                    });

                    jQuery('#notificationForm').trigger("reset");
                    jQuery('#notificationModal').modal('hide')
                } else {
                    Toast.fire({
                      type: 'error',
                      title: data.message
                    });
                }
            },
            error: function (data) {
                // console.log(data.responseJSON.errors);

                if (data.responseJSON.errors.title) {
                    jQuery("#title").addClass("is-invalid");   
                    jQuery("#title-error-message").text(data.responseJSON.errors.title);
                }

                if (data.responseJSON.errors.description) {
                    jQuery("#description").addClass("is-invalid");   
                    jQuery("#description-error-message").text(data.responseJSON.errors.description);
                }

                if (data.responseJSON.errors.role) {
                    jQuery("#role").addClass("is-invalid");   
                    jQuery("#role-error-message").text(data.responseJSON.errors.role);
                }
            }
        });
    });

    // Delete
    $("#btn-delete").click(function (e) {
        // console.log('imworking');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var formData = {
            title: jQuery('#title').val(),
        };
        var type = "DELETE";
        var exam_id = jQuery('#exam_id').val();
        var ajaxurl = 'exam/'+exam_id;
        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                jQuery("#exam" + exam_id).remove();

                jQuery('#myForm').trigger("reset");
                jQuery('#deleteExam').modal('hide');
            },
            error: function (data) {
                console.log(data);
            }
        });
    });

    // remove error message
    $( "#title" ).keydown(function () {
        jQuery("#title").removeClass("is-invalid");  
        jQuery("#title-error-message").text(); 
    });

    $( "#description" ).keydown(function () {
        jQuery("#description").removeClass("is-invalid");  
        jQuery("#description-error-message").text(); 
    });

    $( "#role" ).keydown(function () {
        jQuery("#role").removeClass("is-invalid");  
        jQuery("#role-error-message").text(); 
    });

    // edit exam
    $(document).on( "click" ,"#examEdit", function() {
        axios.get('/exam/'+$(this).data("id")).then(({data}) => (
            jQuery('#btn-save').val("add"),
            jQuery("#error").css("display", "none"),
            jQuery("#title").removeClass("is-invalid"),
            jQuery("#title-error-message").text(),
            jQuery('#examForm').trigger("reset"),
            jQuery('#ExamModal').modal('show'),
            $("#new-exam").hide(),
            $("#update-exam").show(),
            $("#new-exam").hide(),
            $("#btn-save").hide(),
            $("#btn-update").show(),
            jQuery('#exam_id').val(data.id),
            jQuery("#title").val(data.title)
        ));
    });

    // delete exam
    $(document).on( "click" ,"#examDelete", function() {
        console.log('Delete me' + $(this).data("id"));
        axios.get('/exam/'+$(this).data("id")).then(({data}) => (
            jQuery('#exam_id').val(data.id),
            jQuery('#deleteExam').modal('show'),
            jQuery("#exam-delete").text("Are you sure you want to delete "+ data.title +"?")
        ));
    });

    // view exam
    $(document).on( "click" ,"#examView", function() {
        // console.log('Hit me');
        window.location.href ="/exam/"+$(this).data("id")+"/edit";
    });

});