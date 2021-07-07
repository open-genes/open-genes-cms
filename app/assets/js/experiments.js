let newFormsCounter = 0;
let UsId = currentUserId;

$('.js-add-protein-activity').click(function () {
    newFormsCounter++;
    $.get('/gene/load-widget-form?modelName=GeneToProteinActivity&widgetName=GeneProteinActivity&id=' + makeNewId(UsId, newFormsCounter), function (data) {
        $('.js-protein-activities').append(data);
    });
});

$('.js-add-lifespan-experiment').click(function () {
    newFormsCounter++;
    $.get('/gene/load-widget-form?modelName=LifespanExperiment&widgetName=LifespanExperimentWidget&id=' + makeNewId(UsId, newFormsCounter), function (data) {
        $('.js-lifespan-experiments').append(data);
    });
});

$('.js-add-age-related-change').click(function () {
    newFormsCounter++;
    $.get('/gene/load-widget-form?modelName=AgeRelatedChange&widgetName=AgeRelatedChangeWidget&id=' + makeNewId(UsId, newFormsCounter), function (data) {
        $('.js-age-related-changes').append(data);
    });
});

$('.js-add-intervention-to-vital-process').click(function () {
    newFormsCounter++;
    $.get('/gene/load-widget-form?modelName=GeneInterventionToVitalProcess&widgetName=GeneInterventionToVitalProcessWidget&id=' + makeNewId(UsId, newFormsCounter), function (data) {
        $('.js-intervention-to-vital-processes').append(data);
    });
});

$('.js-add-protein-to-gene').click(function () {
    newFormsCounter++;
    $.get('/gene/load-widget-form?modelName=ProteinToGene&widgetName=ProteinToGeneWidget&id=' + makeNewId(UsId, newFormsCounter), function (data) {
        $('.js-protein-to-genes').append(data);
    });
});

$('.js-add-gene-to-progeria').click(function () {
    newFormsCounter++;
    $.get('/gene/load-widget-form?modelName=GeneToProgeria&widgetName=GeneToProgeriaWidget&id=' + makeNewId(UsId, newFormsCounter), function (data) {
        $('.js-gene-to-progerias').append(data);
    });
});

$('.js-add-gene-to-longevity-effect').click(function () {
    newFormsCounter++;
    $.get('/gene/load-widget-form?modelName=GeneToLongevityEffect&widgetName=GeneToLongevityEffectWidget&id=' + makeNewId(UsId, newFormsCounter), function (data) {
        $('.js-gene-to-longevity-effects').append(data);
    });
});

$('.js-add-additional-evidence').click(function () {
    newFormsCounter++;
    $.get('/gene/load-widget-form?modelName=GeneToAdditionalEvidence&widgetName=AdditionalEvidencesWidget&id=' + makeNewId(UsId, newFormsCounter), function (data) {
        $('.js-gene-to-additional-evidence').append(data);
    });
});

function makeNewId(userId, newFormsCounter) {
    return 'new_exp_' + userId + '_' + newFormsCounter;
}

$(document).on('click', '.js-delete', function () {
    if ($(this).is(':checked')) {
        $(this).closest('.js-gene-link-section').find('.js-gene-link-block').css('opacity', '0.5').css('pointer-events', 'none');
    } else {
        $(this).closest('.js-gene-link-section').find('.js-gene-link-block').removeAttr('style');
    }
});

$('#experiments-form').on('submit', function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    let form = $('#experiments-form');
    let formData = form.serialize();
    let formUrl = form.attr("action");
    if (saveExperimentsForm(formUrl, formData)) {
        $('<div class="help-block green">OK!</div>').insertAfter(submitBtn);
        setTimeout(location.reload.bind(location), 1000);
    }
    return false;
});

function saveExperimentsForm(url, formData) {
    let submitBtn = $('#experiments-form button.btn-success');

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        success: function (data) {
            let response = $.parseJSON(data);
            if (typeof response.fatal_error !== 'undefined') {
                alert(response.fatal_error);
            }
            if (response.success) {
                $.each(response.success, function (modelName, saved) {
                    if (typeof saved.new !== 'undefined') {
                        console.log(saved.new);
                        $.each(saved.new, (old_id, new_id) => {
                            const formId = modelName.toLowerCase() + '_form_' + old_id;
                            const select2inputs = document.querySelectorAll(`#${formId}select.select2-hidden-accessible`);
                            console.log('select2inputs: ', select2inputs);
                            const inputsIds = [];
                            select2inputs.forEach((input) => {
                                inputsIds.push($(input).attr('id'));
                                $(input).select2('destroy');
                            });
                            console.log('Old id: ', old_id);
                            console.log('New id: ', new_id);
                            const regex = new RegExp(old_id, 'g');
                            $('#' + formId).html($('#' + formId).html().replace(regex, new_id));
                            const select2newInputs = [];

                            inputsIds.forEach((inputId) => {
                                console.log('inputId: ', inputId);
                                const newInputId = inputId.replace(old_id, new_id);
                                $('#' + newInputId).select2();
                            });
                        });
                    }
                });
            }
            if (typeof response.error !== 'undefined') {
                $.each(response.error, function (index, error) {
                    let model_id = error.id
                    let model_name = error.model
                    let model_fields = error.fields

                    submitBtn.addClass('has-error')
                    if (!submitBtn.next('.help-block').length) {
                        $('<div class="help-block">Форма не прошла валидацию. Пожалуйста, проверьте поля</div>').insertAfter(submitBtn);
                    }

                    $.each(model_fields, function (field, error) {

                        let field_id = model_name.toLowerCase() + '-' + model_id + '-' + field
                        let experimentsInput = $('input#' + field_id)
                        let experimentsText = $('textarea#' + field_id)
                        let select2container = $('.select2-hidden-accessible#' + field_id).next('.select2-container')

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
                });
            } else {
                submitBtn.removeClass('has-error')
                submitBtn.next('.help-block').remove()
                return true;
            }
        },
        error: function () {
            alert("Something went wrong");
        }
    });
    return false;
}

function saveFormChanges(exceptId) {
    let form = $('#experiments-form');
    let formData = $('#experiments-form .js-form-changed:not(#' + exceptId + ') .form-control').serialize();
    let formUrl = form.attr("action");
    if (formData.length) {
        saveExperimentsForm(formUrl, formData)
    }
}

$(document).on('change', '#experiments-form .form-control', function () {
    $(this).removeClass('has-error')
    $(this).next('.select2-container').find('.select2-selection').removeClass('has-error')
    $(this).next('.select2-container').next('.help-block').remove()
    $(this).next('.help-block').remove()
    let section = $(this).closest('.js-gene-link-section');
    section.addClass('js-form-changed')
    saveFormChanges(section.attr('id'))
});

$(document).on('change', '#experiments-form .form-control.form_age', function () {
    if ($(this).val() == '') {
        $(this).closest('.js-gene-link-block').find('.form_age_unit').removeClass('has-error')
        $(this).closest('.js-gene-link-block').find('.form_age_unit').closest('.select2-container').next('.help-block').remove()
    }
});
