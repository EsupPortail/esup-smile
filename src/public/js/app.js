/**
 * Fonction JS de base de l'application
 */
function closeModal(event){
    event.div.modal('hide');
}
function refreshFlashMessage(event){
    var target = $(event.target);
    target.find('#flash-message').refresh();
}

/*
    Code pour le chargement lorsqu'un formulaire est soumis
    TODO : a revoir pourquoi la loading in progress ne donne pas un résultat correct en css
 */
function addLoadingProgress(event){
    if(!event.target.classList.contains("loadingForm")){return;}
    var element = $(event.target);
    loadContent = "<span class='loadingInProgress fas fa-spinner fa-pulse fas fa-4x'></span>";
    element.append(loadContent);
}
$(function() {
    var body = $("body");
    body.on('submit', addLoadingProgress);
})


/** Chargement par défaut des tooltip **/
$(function (){
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
})

/** Back-btn **/
$(function (){
    $('.btn-back').on('click', function(e){
        e.preventDefault();
        that = $(this);
        if (typeof that.data('url') !== 'undefined') {
            url = that.data('url');
            window.location.href=url;
        }
        else{
            parent.history.back();
        }
        return false;
    });
})



/** Template pour tinymce */
$(function () {
    tinymce.init({
        selector: '.type1',
        toolbar: 'newdocument undo redo | bold italic | bullist | bullist | highlight',
        language: 'fr_FR',
        entity_encoding : "raw",
        resize: true,
        statusbar: true,
        browser_spellcheck : true,
        branding: false,
        menu: {},
        setup: function (editor) {
            editor.addButton('highlight', {
                text: '',
                icon: 'codesample',
                title: 'Définition',
                onclick: function () {
                    let content =  editor.selection.getContent();
                    if (content !== '') {
                        let new_content = "";
                        let regex = /<abbr title="">.*<\/abbr>/g;
                        let found = content.match(regex);
                        if (found) {
                            new_content = content.replace('</abbr>', '');
                            new_content = new_content.replace('<abbr title="">', '');
                        } else {
                            new_content = '<abbr title="">' + content + '</abbr>';
                        }
                        editor.insertContent(new_content);
                    }
                }
            });
        }
    });
    tinymce.init({
        selector: '.type2',
        plugins: 'lists',
        toolbar: 'newdocument undo redo | bold italic | bullist',
        browser_spellcheck : true,
        language: 'fr_FR',
        entity_encoding : "raw",
        statusbar: false,
        resize: false,
        branding: false,
        menu: {},
        setup: function (editor) {}
    });

    tinymce.init({
        selector: '.tiny-type-smile',
        plugins: 'lists',
        toolbar: 'newdocument undo redo | bold italic | bullist',
        browser_spellcheck : true,
        language: 'fr_FR',
        entity_encoding : "raw",
        statusbar: true,
        resize: true,
        branding: false,
        menu: {},
        setup: function (editor) {}
    });

    $('.info-icon').popover({
        html: true
    })

});
