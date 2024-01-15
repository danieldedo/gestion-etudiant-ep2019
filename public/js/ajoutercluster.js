// public/js/formclusters.js

$(document).ready(function () {

    // Lorsque le département change
    $('#clusters_departement').change(function () {
        let departementId = $(this).val();
        console.log(departementId)

        // Effectuer une requête AJAX pour obtenir les communes pour ce département
        $.ajax({
            url: '/ajax/get_communes/' + departementId ,
            type: 'POST',
            success: function (data) {
                // alert("BOBOAdjanou")
                console.log(data)

                // Mettre à jour la liste déroulante des communes
                $('#clusters_commune')
                    .removeAttr('disabled')
                    .empty()
                    .append('<option value="">Sélectionnez une commune</option>');

                
                $.each(data, function (id, name) {
                    $('#clusters_commune').append($('<option>', {
                        value: id,
                        text: name
                    }));
                });
            }
        });
    });

    

    // Lorsque la commune change
    $('#clusters_commune').change(function () {
        let communeId = $(this).val();
        console.log(communeId)

        // Effectuer une requête AJAX pour obtenir les communes pour ce département
        $.ajax({
            url: '/ajax/get_arrondissements/' + communeId,
            type: 'POST',
            success: function (data) {
                // alert("BOBOAdjanou")
                console.log(data)

                // Mettre à jour la liste déroulante des arrondissement
                $('#clusters_arrondissement')
                    .removeAttr('disabled')
                    .empty()
                    .append('<option value="">Sélectionnez un arrondissement</option>');

                
                $.each(data, function (id, name) {
                    $('#clusters_arrondissement').append($('<option>', {
                        value: id,
                        text: name
                    }));
                });
            }
        });
    });



     // Lorsque l'arrondissement change
     $('#clusters_arrondissement').change(function () {
        let arrondissementId = $(this).val();
        console.log(arrondissementId)

        // Effectuer une requête AJAX pour obtenir les arrondissements pour ce département
        $.ajax({
            url: '/ajax/get_villages/' + arrondissementId,
            type: 'POST',
            success: function (data) {
                // alert("BOBOAdjanou")
                console.log(data)

                // Mettre à jour la liste déroulante des villages
                $('#clusters_village')
                    .removeAttr('disabled')
                    .empty()
                    .append('<option value selected="selected" >Sélectionnez un village</option>');

                
                $.each(data, function (id, name) {
                    $('#clusters_village').append($('<option>', {
                        value: id,
                        text: name
                    }));
                });
            }
        });
    });


});
