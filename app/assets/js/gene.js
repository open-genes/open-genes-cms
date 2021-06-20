let newGeneLinkBlocksCount = 0;

$('.js-add-protein-activity').click(function () {
    newGeneLinkBlocksCount++;
    $.get('/gene/load-widget-form?modelName=GeneToProteinActivity&widgetName=GeneProteinActivity&id=new'+newGeneLinkBlocksCount, function (data) {
        $('.js-protein-activities').append(data);
    });
});

$('.js-add-lifespan-experiment').click(function () {
    newGeneLinkBlocksCount++;
    $.get('/gene/load-widget-form?modelName=LifespanExperiment&widgetName=LifespanExperimentWidget&id=new'+newGeneLinkBlocksCount, function (data) {
        $('.js-lifespan-experiments').append(data);
    });
});

$('.js-add-age-related-change').click(function () {
    newGeneLinkBlocksCount++;
    $.get('/gene/load-widget-form?modelName=AgeRelatedChange&widgetName=AgeRelatedChangeWidget&id=new'+newGeneLinkBlocksCount, function (data) {
        $('.js-age-related-changes').append(data);
    });
});

$('.js-add-intervention-to-vital-process').click(function () {
    newGeneLinkBlocksCount++;
    $.get('/gene/load-widget-form?modelName=GeneInterventionToVitalProcess&widgetName=GeneInterventionToVitalProcessWidget&id=new'+newGeneLinkBlocksCount, function (data) {
        $('.js-intervention-to-vital-processes').append(data);
    });
});

$('.js-add-protein-to-gene').click(function () {
    newGeneLinkBlocksCount++;
    $.get('/gene/load-widget-form?modelName=ProteinToGene&widgetName=ProteinToGeneWidget&id=new'+newGeneLinkBlocksCount, function (data) {
        $('.js-protein-to-genes').append(data);
    });
});

$('.js-add-gene-to-progeria').click(function () {
    newGeneLinkBlocksCount++;
    $.get('/gene/load-widget-form?modelName=GeneToProgeria&widgetName=GeneToProgeriaWidget&id=new'+newGeneLinkBlocksCount, function (data) {
        $('.js-gene-to-progerias').append(data);
    });
});

$('.js-add-gene-to-longevity-effect').click(function () {
    newGeneLinkBlocksCount++;
    $.get('/gene/load-widget-form?modelName=GeneToLongevityEffect&widgetName=GeneToLongevityEffectWidget&id=new'+newGeneLinkBlocksCount, function (data) {
        $('.js-gene-to-longevity-effects').append(data);
    });
});

$('.js-add-additional-evidence').click(function () {
    newGeneLinkBlocksCount++;
    $.get('/gene/load-widget-form?modelName=GeneToAdditionalEvidence&widgetName=AdditionalEvidencesWidget&id=new'+newGeneLinkBlocksCount, function (data) {
        $('.js-gene-to-additional-evidence').append(data);
    });
});

$(document).on('click', '.js-delete', function() {
    if ($(this).is(':checked')) {
        $(this).closest('.js-gene-link-section').find('.js-gene-link-block').css('opacity', '0.5').css('pointer-events', 'none');
    } else {
        $(this).closest('.js-gene-link-section').find('.js-gene-link-block').removeAttr('style');
    }
});

$('#experiments-form').on('submit', function(e){
    e.preventDefault();
    e.stopImmediatePropagation();
    let form = $(this);
    let formData = form.serialize();
    let submitBtn = $('#experiments-form button.btn-success').removeClass('has-error')

    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: formData,
        success: function (data) {
            let response = $.parseJSON(data);
            if (typeof response.error !== 'undefined') {

                let model_id = response.error.id
                let model_name = response.error.model
                let model_fields = response.error.fields

                submitBtn.addClass('has-error')
                if (!submitBtn.next('.help-block').length) {
                    $('<div class="help-block">Форма не прошла валидацию. Пожалуйста, проверьте поля</div>').insertAfter(submitBtn);
                }

                $.each(model_fields, function (field, error) {

                    let field_id = model_name.toLowerCase() + '-' + model_id + '-' + field
                    let experimentsInput = $('input#' + field_id)
                    let experimentsText = $('textarea#' + field_id)
                    let select2container = $('.select2-hidden-accessible#' + field_id).next('.select2-container')
                    console.log(field_id)

                    select2container.find('.select2-selection').addClass('has-error');
                    if (!select2container.next('.help-block').length) {
                        $('<div class="help-block">' + error + '</div>').insertAfter(select2container);
                    }
                    experimentsInput.addClass('has-error');
                    if (!experimentsInput.next('.help-block').length) {
                        $('<div class="help-block">' + error + '</div>').insertAfter('input#' + field_id);
                    }
                    experimentsText.addClass('has-error');
                    if (!experimentsText.next('.help-block').length) {
                        $('<div class="help-block">' + error + '</div>').insertAfter('textarea#' + field_id);
                    }
                });
            } else {
                submitBtn.removeClass('has-error')
                submitBtn.next('.help-block').remove()
                $('<div class="help-block green">OK!</div>').insertAfter(submitBtn);
                setTimeout(location.reload.bind(location), 1000);
            }
        },
        error: function () {
            alert("Something went wrong");
        }
    });
    return false;
});

$(document).on('change', '#experiments-form .form-control', function() {
    $(this).removeClass('has-error')
    $(this).next('.select2-container').find('.select2-selection').removeClass('has-error')
    $(this).next('.select2-container').next('.help-block').remove()
    $(this).next('.help-block').remove()
});

$(document).on('change', '#experiments-form .form-control.form_age', function() {
    if($(this).val() == '') {
        $(this).closest('.js-gene-link-block').find('.form_age_unit').removeClass('has-error')
        $(this).closest('.js-gene-link-block').find('.form_age_unit').closest('.select2-container').next('.help-block').remove()
    }
});