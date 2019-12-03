let newProteinActivityFormsCount = 0;

$('.js-add-protein-activity').click(function () {
    newProteinActivityFormsCount++;
    $.get('/gene/load-gene-protein-activity-form?id=new'+newProteinActivityFormsCount, function (data) {
        $('.js-protein-activities').append(data);
    });
});