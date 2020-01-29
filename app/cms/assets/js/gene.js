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

$('.js-delete').click(function () {
    if ($(this).is(':checked')) {
        $(this).closest('.js-gene-link-section').find('.js-gene-link-block').css('opacity', '0.5').css('pointer-events', 'none');
    } else {
        $(this).closest('.js-gene-link-section').find('.js-gene-link-block').removeAttr('style');
    }
});