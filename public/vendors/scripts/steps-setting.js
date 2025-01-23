$(".tab-wizard").steps({
    headerTag: "h5",
    bodyTag: "section",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: "Submit"
    },
    onStepChanged: function (event, currentIndex, priorIndex) {
        $('.steps .current').prevAll().addClass('disabled');
    },
    onFinished: function (event, currentIndex) {
        // Empêcher la soumission immédiate du formulaire
        event.preventDefault();

        // Afficher le modal
        $('#success-modal').modal('show');

        // Attendre 3 secondes avant de soumettre le formulaire
        setTimeout(function () {
            // Soumettre le formulaire
            $("#profile-update-form")[0].submit();
        }, 1000); // Délai de 3 secondes pour afficher le modal avant soumission
    }
});
