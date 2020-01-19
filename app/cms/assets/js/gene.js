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

$('.js-delete').click(function () {
    if ($(this).is(':checked')) {
        $(this).closest('.js-gene-link-section').find('.js-gene-link-block').css('opacity', '0.5').css('pointer-events', 'none');
    } else {
        $(this).closest('.js-gene-link-section').find('.js-gene-link-block').removeAttr('style');
    }
});