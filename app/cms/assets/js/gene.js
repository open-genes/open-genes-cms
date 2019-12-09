let newProteinActivityFormsCount = 0;

$('.js-add-protein-activity').click(function () {
    newProteinActivityFormsCount++;
    $.get('/gene/load-gene-protein-activity-form?id=new'+newProteinActivityFormsCount, function (data) {
        $('.js-protein-activities').append(data);
    });
});

$('.js-delete').click(function () {
    if ($(this).is(':checked')) {
        $(this).closest('.js-protein-activity').find('.js-protein-activity-block').css('opacity', '0.5').css('pointer-events', 'none');
    } else {
        $(this).closest('.js-protein-activity').find('.js-protein-activity-block').removeAttr('style');
    }
});