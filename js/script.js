$(function(e) {

	/* Bouton qui permet de répondre sur le forum. */
	$('.btn-repondre').click(function(e) {
		var id = $(this).attr('idPost');
		$('input[name=idPostParent]').attr('name', 'idPostParent' + id);
		$('input[name=idPostParent' + id + ']').val(id);

	});

	/* Bouton qui j'aime. */ 
	$('.btn-jaime').click(function(e) {
		e.preventDefault();
		var lien = $(this).attr('href');
		var id = $(this).attr('idJaime');
		var target = $('.nb-jaime' + id);
		var nb;
		$.ajax({
			type: 'GET',
			url: lien,
			success: function() {
				nb = parseInt(target.html());	
				target.html(nb + 1);
			},
		});
	});

	/* Le bouton pour se connecter. */
	$('.btn-connexion').click(function(e) {
		e.preventDefault();
		connexion();
	});

	/* Le bouton pour se déconnecter. */
	$('.btn-deconnexion').click(function(e) {
		e.preventDefault();
		deconnexion();
	});

	/* Le bouton pour s'inscrire. */
	$('.btn-inscription').click(function(e) {
		e.preventDefault();
		inscription();
	});

	/* Le bouton pour envoyer un mail de contact. */
	$('.btn-contact').click(function(e) {
		e.preventDefault();
		contact();
	});

	/* Le bouton qui permet de restaurer son mot de passe. */
	$('.btn-restaurer').click(function(e) {
		e.preventDefault();
		restaurer();
	});

	/* Le bouton pour changer son mot de passe. */
	$('.btn-changer').click(function(e) {
		e.preventDefault();
		changer();
    });

    /* Le bouton pour confirmer la RGPD. */
    $('.btn-supprimer-compte').click(function (e) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer votre compte ?\nCette action est irréversible.')) {
            e.preventDefault();
        } else {
            alert('Au revoir, à très bientôt !');
        }
    });

    /* Le bouton qui permet de supprimer un avis. */
    $('.btn-supprimer-avis').click(function (e) {
        e.preventDefault();
        if (confirm('Voulez-vous vraiment supprimer cet avis ?')) {
            var id = $(this).attr('id');
            supprimerAvis(id);
            alert('Supprimé avec succès !');
            var pathname = window.location.pathname;
            let searchParams = new URLSearchParams(window.location.search);
            $(location).attr('href', '?' + searchParams);
        }
    });

    /* Pas de commentaire vide. */
    $('#form-comment').submit(function (e) {
        var saisieTexte = $('textarea[name=comm]');

        var texte = saisieTexte.val();
        var texteM = texte.replace(/\ /g, '');
        if (texteM.length < 1) {
            e.preventDefault();
            mettreEnRouge(saisieTexte);
        }
    });

    /* Que des chiffres. */
    $('.saisie-douane').keyup(function () {
        var val = $(this).val();
        if (isNaN(val) || parseInt(val) < 0) {
            $(this).val(0);
        }
    });

    /* Le bouton pour poster. */
    $('.btn-poster').click(function(e) {
    	var saisieSujet = $('textarea[name=sujetPost]');
    	var sujet = saisieSujet.val();
    	var sujetM = sujet.replace(/\ /g, '');
    	if (sujetM.length < 1) {
            e.preventDefault();
            mettreEnRouge(saisieSujet);
        }
    });

    /* Tooltip */
    $('[data-toggle="tooltip"]').tooltip();

});

/* Savoir si le pseudo a un longueur supérieur à 3. */
function estPseudo(pseudo) {
	return pseudo.length > 3;
}

/* Savoir si l'email correspond au critère d'email. */
function estEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
};

/* Savoir si le mot de passe contient 8 caractères, 1 lettre et 1 chiffre. */ 
function estMotDePasse(motDePasse) {
	var regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
	return regex.test(motDePasse);
};

/* Pour les insertions en cas d'erreur. */
function mettreEnRouge(classe) {
	classe.css('background-color', '#F08080');
};

/* Pour réinitialiser les insetions après une erreur. */
function mettreEnBlanc(classe) {
	classe.css('background-color', '#ffffff');
}

/* La fonction pour se connecter. */
function connexion() {

	var saisieEmail = $('input[name=email]');
	var saisieMotDePasse = $('input[name=motDePasse]');

	var tokenConnexion = $('input[name=tokenConnexion]').val();
	var email = saisieEmail.val();
	var motDePasse = saisieMotDePasse.val();

	$.ajax({
		type: 'POST',
		url: '?module=connexion&action=connecter',
		dataType: 'text',
		data: {
			tokenConnexion: tokenConnexion,
			email: email,
			motDePasse: motDePasse
		},
		success: function(texte) {
			if (!texte.length) {
				/*$(location).attr('href', '?module=profil');*/
				location.reload();
			} else {
                $('.text-danger').remove();
				$('.texte').append('<div class="text-danger">' + texte + '</div>');
			}
		},
	});

};

/* La fonction pour s'inscrire. */
function inscription() {

	var saisiePseudo = $('input[name=pseudo]');
	var saisieEmail = $('input[name=email]');
	var saisieMotDePasse = $('input[name=motDePasse');
	var saisieConfirmation = $('input[name=motDePasseConfirmation');

	var token = $('input[name=token]').val();
	var pseudo = saisiePseudo.val();
	var email = saisieEmail.val();
	var motDePasse = saisieMotDePasse.val();
	var motDePasseConfirmation = saisieConfirmation.val();

	if (estPseudo(pseudo) && estEmail(email) && estMotDePasse(motDePasse) && motDePasse == motDePasseConfirmation) {
		$.ajax({
			type: 'POST',
			url: '?module=inscription&action=inscrire',
			dataType: 'text',
			data: {
				token: token,
				email: email,
				pseudo: pseudo,
				motDePasse: motDePasse,
				motDePasseConfirmation: motDePasseConfirmation
			},
			success: function(texte) {
                if (!texte.length) {
                    $(location).attr('href', '?module=profil');
                } else {
                    $('.text-danger').remove();
					$('.texte').append('<div class="text-danger">' + texte + '</div>');
                }
			},
		});
	} else {
		mettreEnRouge(saisiePseudo);
		mettreEnRouge(saisieEmail);
		mettreEnRouge(saisieMotDePasse);
		mettreEnRouge(saisieConfirmation);
        $('.text-danger').remove();
		$('.texte').append('<div class="text-danger">Vérifiez vos saisies.</div>');
		if (!estPseudo(pseudo)) {
			mettreEnRouge(saisiePseudo);
		}
		if (!estEmail(email)) {
			mettreEnRouge(saisieEmail);
		}
		if (!estMotDePasse(motDePasse) || motDePasse !== motDePasseConfirmation) {
			mettreEnRouge(saisieMotDePasse);
			mettreEnRouge(saisieConfirmation);
		}
	}
};

/* La fonction pour envoyer un mail de contact. */
function contact() {

	var saisiePseudo = $('input[name=pseudo]');
	var saisieEmail = $('input[name=email]');
	var saisieSujet = $('input[name=sujet]');
	var saisieMessage = $('textarea[name=message]');

	var pseudo = saisiePseudo.val();
	var email = saisieEmail.val();
	var sujet = saisieSujet.val();
	var message = saisieMessage.val();

	var token = $('input[name=token]').val();

	if ((((email !== undefined && pseudo !== undefined && estEmail(email) && estPseudo(pseudo)) || (email === undefined && pseudo === undefined)) && sujet.length > 1 && message.length > 10)) {
		$.ajax({
			type: 'POST',
			url: '?module=contact&action=envoyer',
			dataType: 'text',
			data: {
				token: token,
				email: email,
				pseudo: pseudo,
				sujet: sujet,
				message: message
			},
			success: function(texte) {
				if (!texte.length) {
					$('form').remove();
					$('.texte').append('<div class="text-success">Mail envoyé avec succès.</div>');
				} else {
                    $('.text-danger').remove();
					$('.texte').append('<div class="text-danger">' + texte + '</div>');
				}
			},
		});
	} else {
		mettreEnBlanc(saisieEmail);
		mettreEnBlanc(saisiePseudo);
		mettreEnBlanc(saisieMessage);
		mettreEnBlanc(saisieSujet);
        $('.text-danger').remove();
		$('.texte').append('<div class="text-danger">Vérifiez vos saisies.</div>');
		if (email !== undefined && !estEmail(email)) {
			mettreEnRouge(saisieEmail);
		}
		if (pseudo !== undefined && !estPseudo(pseudo)) {
			mettreEnRouge(saisiePseudo);
		}
		if (!(message.length > 10)) {
			mettreEnRouge(saisieMessage);
		}
		if (!(sujet.length > 1)) {
			mettreEnRouge(saisieSujet);
		}
	}
	
};

/* La fonction qui permet de restaurer son mot de passe. */
function restaurer() {

	var saisieEmail = $('input[name=email-restaurer]');
	var email = saisieEmail.val();

	var tokenOublier = $('input[name=tokenOublier]').val();

	$.ajax({
			type: 'POST',
			url: '?module=connexion&action=restaurer',
			dataType: 'text',
			data: {
				email: email,
				tokenOublier: tokenOublier
			},
			success: function(texte) {
				if (!texte.length) {
					$('form').remove();
					$('.modal-body').append('<div class="text-success">Votre mot de passe vous a été envoyé par mail.</div>');
				} else {
					mettreEnRouge(saisieEmail);
                    $('.text-danger').remove();
					$('.texte').append('<div class="text-danger">' + texte + '</div>');
				}
			},
		});

};

/* Fonction qui met à jour le mot de passe. */
function changer() {

	var saisieMotDePasse = $('input[name=nouveau-mot-de-passe]');
	var motDePasse = saisieMotDePasse.val();

	var tokenPasse = $('input[name=tokenPasse]').val();

	if (!estMotDePasse(motDePasse)) {
        $('.text-danger').remove();
		$('.texte').append('<div class="text-danger">Mot de passe non conforme.</div>');
		mettreEnRouge(saisieMotDePasse);
	} else {
		$.ajax({
			type: 'POST',
			url: '?module=profil&action=changer',
			dataType: 'text',
			data: {
				tokenPasse: tokenPasse,
				motDePasse: motDePasse
			},
			success: function(texte) {
				if (!texte.length) {
					$('form').remove();
					$('.modal-body').append('<div class="text-success">Votre mot de passe a été mis à jour.</div>');
				} else {
					mettreEnRouge(saisieMotDePasse);
                    $('.text-danger').remove();
					$('.texte').append('<div class="text-danger">' + texte + '</div>');
				}
			},
		});
	}

};

/* Function qui permet de supprimer un avis. */
function supprimerAvis(id) {
    $.ajax({
        type: 'POST',
        url: '?module=liste&action=supprimerAvis',
        dataType: 'text',
        data: {
            id: id
        },
        success: function () {
            $('#' + id).remove();
        }
    });
}