let newGeneLinkBlocksCount = 0;

$(document).on('click', '.js-add-lifespan-experiment-control', function() {
    newGeneLinkBlocksCount++;
    let block = $(this);
    $.get('/gene/load-widget-form?modelName=LifespanExperiment&widgetName=LifespanExperimentWidget&id=new'
        +newGeneLinkBlocksCount
        +'&modelParams[general_lifespan_experiment_id]='+$(this).attr('generalLifespanExperimentId')
        +'&params[currentGeneId]='+$(this).attr('currentGeneId')
        +'&modelParams[type]=control', function (data) {
        $(block).closest('.js-lifespan-experiment-block').find('.js-lifespan-experiments-control').append(data);
    });
});

$(document).on('click', '.js-add-lifespan-experiment-gene', function() {
    newGeneLinkBlocksCount++;
    let block = $(this);
    $.get('/gene/load-widget-form?modelName=LifespanExperiment&widgetName=LifespanExperimentWidget&id=new'
        +newGeneLinkBlocksCount
        +'&modelParams[general_lifespan_experiment_id]='+$(this).attr('generalLifespanExperimentId')
        +'&params[currentGeneId]='+$(this).attr('currentGeneId')
        +'&modelParams[type]=experiment', function (data) {
        
        $(block).closest('.js-lifespan-experiment-block').find('.js-lifespan-experiments-gene').append(data);
    });
});

$('.js-add-general-lifespan-experiment').click(function () {
    newGeneLinkBlocksCount++;
    $.get('/gene/load-widget-form?modelName=LifespanExperiment&widgetName=GeneralLifespanExperimentWidget&id=new'
        +newGeneLinkBlocksCount
        +'&modelParams[gene_id]='+$(this).attr('geneId')
        +'&modelParams[type]=experiment'
        +'&geneId='+$(this).attr('geneId'), function (data) {
        $('.js-general-lifespan-experiments').append(data);
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

                submitBtn.addClass('has-error');
                let errorMessage = 'Форма не прошла валидацию. Пожалуйста, проверьте поля'
                if (!model_name) {
                    errorMessage = response.error
                }
                if (!submitBtn.next('.help-block').length) {
                    $('<div class="help-block">'+errorMessage+'</div>').insertAfter(submitBtn)
                } else {
                    submitBtn.next('.help-block').html(errorMessage);
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

$(document).on('click', '#experiments-form .js-experiment-short', function() {
    let modelName = $(this).attr('model-name')
    let widgetName = $(this).attr('widget-name')
    let modelId = $(this).attr('model-id')
    let container =  $(this).closest('.js-short-form-container')
    $.get('/gene/load-widget-form?modelName='+ modelName +'&widgetName='+ widgetName +'&id='+modelId, function (data) {
            container.html(data);
        });
});

$(document).on('click', '#experiments-form .js-lifespan-experiment-short', function() {
    let modelId = $(this).attr('model-id')
    let container = $(this).closest('.js-short-form-container')
    $.get('/gene/load-widget-form?modelName=LifespanExperiment&widgetName=GeneralLifespanExperimentWidget&id='
        + modelId
        + '&modelParams[gene_id]=' + $(this).attr('gene-id')
        + '&modelParams[type]=experiment'
        + '&geneId=' + $(this).attr('gene-id'), function (data) {
        container.html(data);
    })
})

//ортологи в эксперименты
$(document).on('change', '#experiments-form .js-lifespan-experiment-block [id$="model_organism_id"]', function() {
    let t = $(this);
    let model_organism_id = t.val();
    let gene_id = $('.js-lifespan-experiment-block [name$="[currentGeneId]"]').val();
    $.get('/gene/get-orthologs?modelOrganismId='+model_organism_id+'&geneId='+gene_id, function (data) {
        let orthologs = JSON.parse(data);
        let select = t.parents('.js-lifespan-experiment').find('.js-lifespan-experiments-gene .orthologs');
        select.empty();
        let options = Object.entries(orthologs);
        for (const [id, symbol] of options) {
            select.append($('<option>', {
                value: id,
                text: symbol
            }));
        }
        if (options.length == 1) {
            select.val(options[0][0]);
        }
        select.change();
    });
});

//запрет изменения организма при существующем доп воздействии
$(document).on('click', '.js-add-lifespan-experiment-control, .js-add-lifespan-experiment-gene', function() {
    let t = $(this);
    let general_le_name = t.parents('.js-gene-link-section').find('input[name^="GeneralLifespanExperiment"')[0].name;
    let matches = general_le_name.match(/GeneralLifespanExperiment\[(\d+)\]\[(\w+)\]/);
    let general_le_id = matches[1];
    let select = $('select#generallifespanexperiment-'+general_le_id+'-model_organism_id');

    select.data('data-value', select.val())
    $('select#generallifespanexperiment-'+general_le_id+'-model_organism_id').next().children().each(function () {
        $(this).css('pointer-events', 'none');
    });
    $('#select2-generallifespanexperiment-'+general_le_id+'-model_organism_id-container')
        .parents('[aria-labelledby="select2-generallifespanexperiment-'+general_le_id+'-model_organism_id-container"]')
        .css('background-color', '#d6d8d9').css('border-color', '#c6c8ca');
    $('#select2-generallifespanexperiment-'+general_le_id+'-model_organism_id-container .select2-selection__clear').css('display', 'none');
})

//ортологи при изменении гена в доп воздействии
$(document).on('change', '.js-lifespan-experiment [id$="gene_id"]', function() {
    let t = $(this);
    let gene_id = t.val();
    let select = t.parents('.js-lifespan-experiment').parents('.js-lifespan-experiment').find('[id$="model_organism_id"]');
    console.log(select);
    let model_organism_id = select.data('data-value');

    $.get('/gene/get-orthologs?modelOrganismId='+model_organism_id+'&geneId='+gene_id, function (data) {
        let orthologs = JSON.parse(data);
        let select = t.parents('.gene-modulation.js-gene-link-section').find('.orthologs');
        select.empty();
        let options = Object.entries(orthologs);
        for (const [id, symbol] of options) {
            select.append($('<option>', {
                value: id,
                text: symbol
            }));
        }
        if (options.length == 1) {
            select.val(options[0][0]);
        }
        select.change();
    });
});