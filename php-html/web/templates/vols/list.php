<?php ob_start(); ?>
<div class="border border-secondary-subtle rounded p-3 my-3">
    <form class="d-inline mx-1" id="rechercher">
        <input type="hidden" id="page">
        <div class="row">
            <div class="col-6 my-2">
                <div class="form-floating">
                    <select class="form-select" id="villeDepart">
                        <option></option>
                        <option value="BKK">Bangkok, Thaïlande - Aéroport de Bangkok-Suvarnabhumi (BKK)</option>
                        <option value="CDG">Paris, France - Aéroport Charles de Gaulle (CDG)</option>
                        <option value="MAD">Madrid, Espagne - Aéroport Adolfo-Suárez de Madrid-Barajas (MAD)</option>
                    </select>
                    <label for="villeDepart">Ville départ</label>
                </div>
            </div>
            <div class="col-6 my-2">
                <div class="form-floating">
                    <select class="form-select" id="villeRetour">
                        <option></option>
                        <option value="BKK">Bangkok, Thaïlande - Aéroport de Bangkok-Suvarnabhumi (BKK)</option>
                        <option value="CDG">Paris, France - Aéroport Charles de Gaulle (CDG)</option>
                        <option value="MAD">Madrid, Espagne - Aéroport Adolfo-Suárez de Madrid-Barajas (MAD)</option>
                    </select>
                    <label for="villeRetour">Ville retour</label>
                </div>
            </div>
            <div class="col-2 my-2">
                <div class="form-floating">
                    <input type="date" class="form-control" id="dateDepart" value="2023-05-20">
                    <label for="dateDepart">Date départ</label>
                </div>
            </div>
            <div class="col-2 my-2">
                <div class="form-floating">
                    <input type="date" class="form-control" id="dateRetour" value="2023-05-25">
                    <label for="dateRetour">Date retour</label>
                </div>
            </div>
            <div class="col-2 my-2">
                <div class="form-floating">
                    <select class="form-select" id="nombrePassagers">
                        <?php for ($i = 1; $i <= 10; $i++) { ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php } ?>
                    </select>
                    <label for="nombrePassagers">Nombre passagers</label>
                </div>
            </div>
        </div>
        <input type="submit" class="btn btn-primary" id="btnRechercher" value="Rechercher">
    </form>
</div>

<div id="vols" class="text-center"></div>

<div id="reservationModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Réservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reserver">
                    <input type="hidden" id="reservationVolId">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom">
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email">
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="text" class="form-control" id="telephone">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button form="reserver" type="submit" class="btn btn-primary">Réserver</button>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php ob_start(); ?>
<script>
    // Affichage des messages d'alertes (success, error)
    const appendAlert = (message, type) => {
        const wrapper = document.createElement('div')
        wrapper.innerHTML = [
            '<div class="alert alert-' + type + ' alert-dismissible" role="alert">' +
            '<div>' + message + '</div>' +
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
            '</div>'
        ].join('')

        document.getElementById('alert').append(wrapper)
    }
    document.getElementById("rechercher").addEventListener("submit", (event) => {
        event.preventDefault()

        let page = document.getElementById("page").value !== '' ? document.getElementById("page").value : 1
        let villeDepart = document.getElementById("villeDepart").value
        let villeRetour = document.getElementById("villeRetour").value
        let dateDepart = document.getElementById("dateDepart").value
        let dateRetour = document.getElementById("dateRetour").value
        let nombrePassagers = document.getElementById("nombrePassagers").value

        if (villeDepart && villeRetour && dateDepart && dateRetour && nombrePassagers) {
            let data = {
                villeDepart: villeDepart,
                villeRetour: villeRetour,
                dateDepart: dateDepart,
                dateRetour: dateRetour,
                nombrePassagers: nombrePassagers
            }
            // Nettoyage de la liste des vols pour l'affichage du résultat de la recherche
            document.getElementById("vols").innerHTML = ''

            // Envoie de la recherche à l'API
            fetch("/?action=rechercher&page=" + page, {
                method: 'post',
                body: JSON.stringify(data),
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            }).then((response) => {
                return response.json()
            }).then((res) => {
                if (res.status === 201) {
                    if (res.total === 0) {
                        document.getElementById("vols").innerText = "Aucuns vols trouvés"
                    } else {
                        res.data.forEach((vol) => {
                            // Création des éléments de lignes de vols pour l'affichage
                            let volId = vol.id
                            let volBlock = document.createElement("div")
                            volBlock.setAttribute("id", "vol_" + volId)
                            volBlock.setAttribute("class", "card my-3")
                            let volElem = document.createElement("div")
                            volElem.setAttribute("class", "card-body")
                            let volContent = document.createElement("p")
                            volContent.innerText = "Vol n°" + volId + "\n" +
                                "Allée " + vol.villeDepart + " - " + vol.dateDepart + " " + vol.heureDepart + "\n" +
                                "Retour " + vol.villeRetour + " - " + vol.dateRetour + " " + vol.heureRetour + "\n" +
                                "Prix : " + vol.prix + " €"
                            volElem.appendChild(volContent)
                            let buttonBlock = document.createElement("div")
                            buttonBlock.setAttribute("class", "card-footer")
                            let buttonElem = document.createElement("button")
                            buttonElem.innerText = "Réserver"
                            buttonElem.setAttribute("class", "btn btn-sm btn-primary btnReservation")
                            buttonElem.setAttribute("data-bs-toggle", "modal")
                            buttonElem.setAttribute("data-bs-target", "#reservationModal")
                            buttonElem.setAttribute("data-bs-volid", volId)
                            buttonElem.setAttribute("id", "btn_vol_" + volId)
                            buttonBlock.appendChild(buttonElem)
                            volBlock.appendChild(volElem)
                            volBlock.appendChild(buttonBlock)
                            document.getElementById("vols").appendChild(volBlock)
                        })
                        // pagination
                        let paginationBlock = document.createElement("div")
                        paginationBlock.setAttribute("class", "text-center")
                        let currentPage = res.page
                        let totalPage = Math.ceil(res.total / res.perPage)

                        // précédent
                        let prevElem = document.createElement("button")
                        prevElem.setAttribute("class", "btn btn-sm btn-outline-primary")
                        prevElem.innerText = 'Page précédente'
                        if (currentPage == 1 || totalPage == 1) {
                            prevElem.setAttribute("disabled", true)
                        }
                        paginationBlock.appendChild(prevElem)

                        prevElem.addEventListener('click', (event) => {
                            document.getElementById('page').value = currentPage - 1
                            document.getElementById("btnRechercher").click()
                        })

                        // actuel
                        let currentPageElem = document.createElement("b")
                        currentPageElem.setAttribute("class", "mx-2")
                        currentPageElem.innerText = currentPage
                        paginationBlock.appendChild(currentPageElem)

                        // suivant
                        let nextElem = document.createElement("button")
                        nextElem.setAttribute("class", "btn btn-sm btn-outline-primary")
                        nextElem.innerText = 'Page suivante'
                        if (currentPage >= totalPage) {
                            nextElem.setAttribute("disabled", true)
                        }
                        paginationBlock.appendChild(nextElem)

                        nextElem.addEventListener('click', (event) => {
                            document.getElementById('page').value = currentPage + 1
                            document.getElementById("btnRechercher").click()
                        })
                        document.getElementById("vols").appendChild(paginationBlock)
                    }
                } else if (res.status === 500) {
                    appendAlert(res.error, 'danger')
                }
            }).catch((error) => {
                console.log(error)
            })
        }
    })
    // Mise à jour de l'ID du vol dans le formulaire pour la réservation
    document.getElementById('reservationModal').addEventListener('show.bs.modal', event => {
        let volId = event.relatedTarget.getAttribute('data-bs-volid')
        document.getElementById('reservationVolId').value = volId
    })

    document.getElementById("reserver").addEventListener("submit", (event) => {
        event.preventDefault()

        let volId = document.getElementById("reservationVolId").value
        let nom = document.getElementById("nom").value
        let prenom = document.getElementById("prenom").value
        let email = document.getElementById("email").value
        let telephone = document.getElementById("telephone").value

        if (volId && nom && prenom && email && telephone) {
            let data = {
                nom: nom,
                prenom: prenom,
                email: email,
                telephone: telephone
            }

            // Envoie de la réservation à l'API
            fetch("/?action=reserver&volId=" + volId, {
                method: 'post',
                body: JSON.stringify(data),
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            }).then((response) => {
                return response.json()
            }).then((res) => {
                if (res.status === 201) {
                    document.getElementById('reservationModal').style.display = "none"
                    document.querySelector('.modal-backdrop').remove()
                    appendAlert('Votre réservation a bien été enregistré !', 'success')
                } else if (res.status === 500) {
                    document.getElementById('reservationModal').style.display = "none"
                    document.querySelector('.modal-backdrop').remove()
                    appendAlert(res.error, 'danger')
                }
            }).catch((error) => {
                console.log(error)
            })
        }
    })
</script>
<?php $script = ob_get_clean(); ?>

<?php require 'templates/layout.php'; ?>